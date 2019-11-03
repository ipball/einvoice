<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Invoice extends CI_Controller
{
    private $sess;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Document_model');
        $this->load->model('Documentdetail_model');
        $this->load->model('Product_model');
        $this->load->model('Setting_model');
        $this->load->library('Bahttext');
        $this->sess = $this->session->userdata(app_session());
    }

    public function index()
    {
        $data['status'] = get_status('สถานะทั้งหมด');

        template('invoice/index', $data, array('title' => 'รายการขาย (Invoice)', 'script' => 'invoice.js'));
    }

    public function get_by_id($id)
    {
        $document = $this->Document_model->get_by_id($id);
        $detail = $this->Documentdetail_model->get_by_document($id);
        $document['total_after_vat'] = 0;
        $document['products'] = $detail;
        json_output($document);
    }

    public function create()
    {
        template('invoice/invoice_form', array(), array('title' => 'สร้างรายการขาย (Invoice)', 'script' => 'invoice-vue.js'));
    }

    public function edit()
    {
        template('invoice/invoice_form', array(), array('title' => 'แก้ไขรายการขาย (Invoice)', 'script' => 'invoice-vue.js'));
    }

    public function delete($id)
    {
        $this->db->trans_start();
        $details = $this->Documentdetail_model->get_by_document($id);
        foreach ($details as $detail) {
            $product = $this->Product_model->get_by_id($detail['id']);
            if ($product['type'] == 1) {
                $this->Product_model->set_quantity($detail['id'], $detail['amount']);
            }
        }

        $this->Documentdetail_model->delete_by_document($id);
        $data = $this->Document_model->delete($id);
        $this->db->trans_complete();
        json_output($data);
    }

    public function save()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $doc_date = db_datejs($data['doc_date']);
        $frm_date = DateTime::createFromFormat('Y-m-d', $doc_date);

        $prefix = 'INV' . $frm_date->format('ym');

        if (empty($data['id'])) {
            $row = $this->Document_model->data();
        }
        $now = get_now();
        $this->db->trans_start();

        $row['id'] = !empty($data['id']) ? $data['id'] : null;
        $row['doc_no'] = !empty($data['id']) ? $data['doc_no'] : get_running($prefix);
        $row['doc_date'] = $doc_date;
        $row['due_date'] = db_datejs($data['due_date']);
        $row['ref_doc'] = $data['ref_doc'];
        $row['payment_type'] = $data['payment_type'];
        $row['credit_day'] = $data['credit_day'];
        $row['contact_name'] = $data['contact_name'];
        $row['contact_address'] = $data['contact_address'];
        $row['contact_email'] = $data['contact_email'];
        $row['contact_tel'] = $data['contact_tel'];
        $row['contact_fax'] = $data['contact_fax'];
        $row['contact_tax_no'] = $data['contact_tax_no'];
        $row['contact_branch_name'] = $data['contact_branch_name'];
        $row['remark'] = $data['remark'];
        $row['vat_type'] = $data['vat_type'];
        $row['vat'] = $data['vat'];
        $row['discount'] = $data['discount'];
        $row['total'] = $data['total'];
        $row['grand_total'] = $data['grand_total'];
        $row['pay_total'] = $data['pay_total'];
        $row['balance'] = $row['grand_total'] - $row['pay_total'];
        $row['type'] = 1;
        $row['status'] = $data['status'];
        $row['updated_at'] = $now;
        $row['updated_by'] = $this->sess['id'];
        $row['contact_id'] = $data['contact_id'];

        if (empty($data['id'])) {
            $row['created_at'] = $now;
            $row['created_by'] = $this->sess['id'];
            $this->Document_model->save($row);

            $row['id'] = $this->db->insert_id();
            set_running($prefix);
        } else {
            $this->Document_model->update($row);

            $details = $this->Documentdetail_model->get_by_document($row['id']);
            foreach ($details as $detail) {
                $product = $this->Product_model->get_by_id($detail['id']);
                if ($product['type'] == 1) {
                    $this->Product_model->set_quantity($detail['id'], $detail['amount']);
                }
            }

            $this->Documentdetail_model->delete_by_document($row['id']);
        }

        foreach ($data['products'] as $key => $product) {
            $detail = $this->Documentdetail_model->data();
            $detail_id = $key + 1;

            $detail['id'] = $detail_id;
            $detail['line_no'] = $detail_id;
            $detail['product_name'] = $product['name'];
            $detail['quantity'] = $product['amount'];
            $detail['price'] = $product['sell_price'];
            $detail['cost_price'] = $product['buy_price'];
            $detail['total'] = $product['amount'] * $product['sell_price'];
            $detail['unit'] = $product['unit'];
            $detail['product_id'] = $product['id'];
            $detail['document_id'] = $row['id'];

            $this->Documentdetail_model->save($detail);

            $product_detail = $this->Product_model->get_by_id($product['id']);
            if ($product_detail['type'] == 1) {
                $quantity = $product['amount'] * (-1);
                $this->Product_model->set_quantity($product['id'], $quantity);
            }
        }

        $this->db->trans_complete();

        $row['status_code'] = true;
        if ($this->db->trans_status() === false) {
            json_output(array('status_code' => false));
        }
        json_output($row);
    }

    public function datatables()
    {
        $order_index = $this->input->get('order[0][column]');
        $param['page_size'] = $this->input->get('length');
        $param['start'] = $this->input->get('start');
        $param['draw'] = $this->input->get('draw');
        $param['keyword'] = trim($this->input->get('keyword'));
        $param['column'] = $this->input->get("columns[{$order_index}][data]");
        $param['dir'] = $this->input->get('order[0][dir]');
        $param['status'] = $this->input->get('status');
        $param['start_doc_date'] = !empty($this->input->get('start_doc_date')) ? $this->input->get('start_doc_date') : date('Y-m-01');
        $param['end_doc_date'] = !empty($this->input->get('end_doc_date')) ? $this->input->get('end_doc_date') : date('Y-m-t');
        $results = $this->Document_model->get_with_page($param);

        $data['draw'] = $param['draw'];
        $data['recordsTotal'] = $results['count'];
        $data['recordsFiltered'] = $results['count_condition'];
        $data['data'] = $results['data'];
        $data['error'] = $results['error_message'];

        json_output($data);
    }

    public function pdf($id)
    {        
        // get document
        $data['source'] = $this->input->get('source') == 1 ? 'ต้นฉบับ' : 'สำเนา';
        $data['document'] = $this->Document_model->get_by_id($id);
        $data['document']['contact_branch_name'] = !empty($data['document']['contact_branch_name']) ? "({$data['document']['contact_branch_name']})" : "";
        $detail = $this->Documentdetail_model->get_by_document($id);
        $data['document']['products'] = $detail;

        $pdf = new TCPDF('A4', 'mm', 'P', true, 'UTF-8', false);
        $pdf->SetTitle($data['document']['doc_no']);

        // get setting
        $settings = $this->Setting_model->get_all();
        foreach ($settings as $setting) {
            $data['company'][$setting['name']] = $setting['value'];
        }

        $baht = new Bahttext();
        $data['grand_total_text'] = $baht->convert($data['document']['grand_total']);

        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->SetAuthor('Tawatsak Tangeaim');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetHeaderData();

        $pdf->SetFont('thsarabun', '', 13, '', true);

        // perpage of document
        $per_page = 15;
        $count_detail = count($detail);
        $count = ceil($count_detail / $per_page);
        for ($i = 0; $i < $count; $i++) {
            $data['curr_page'] = $i + 1;
            $data['count'] = $count;
            $data['start_page'] = $i * $per_page;
            $data['last_page'] = ($count_detail < ($data['start_page'] + $per_page)) ? $count_detail : ($data['start_page'] + $per_page);

            $html = $this->load->view('invoice/pdf', $data, true);
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '');

            $footer = $this->load->view('invoice/pdf_footer', array(), true);
            $y = $pdf->getPageHeight() - 70;
            $pdf->writeHTMLCell(0, 0, '', $y, $footer, 0, 0, 0, true, 'J', true);
        }

        $pdf->Output("{$data['document']['doc_no']}.pdf", "I");
    }

    public function view($code)
    {
        $decode = base64_decode($code);
        $exp = explode('INV', $decode);
        $id = $exp[0];        
        $data['document'] = $this->Document_model->get_by_id($id);
        if(empty($data['document'])){
            show_404();
        }

        $data['document']['contact_branch_name'] = !empty($data['document']['contact_branch_name']) ? "({$data['document']['contact_branch_name']})" : "";

        $data['products'] = $this->Documentdetail_model->get_by_document($id);        
        $data['title'] = 'ใบกำกับภาษี/ใบเสร็จรับเงิน - ' . $data['document']['doc_no'];

        $settings = $this->Setting_model->get_all();
        foreach ($settings as $setting) {
            $data['company'][$setting['name']] = $setting['value'];
        }

        $baht = new Bahttext();
        $data['grand_total_text'] = $baht->convert($data['document']['grand_total']);

        $this->load->view('invoice/invoice_view', $data);
    }
}
