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
        $this->sess = $this->session->userdata(app_session());
    }

    public function index()
    {
        $data['status'] = get_status('สถานะทั้งหมด');

        template('invoice/index', $data, array('title' => 'รายการใบแจ้งหนี้ (Invoice)', 'script' => 'invoice.js'));
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
        template('invoice/invoice_form', array(), array('title' => 'สร้างใบแจ้งหนี้ (Invoice)', 'script' => 'invoice-vue.js'));
    }

    public function edit()
    {
        template('invoice/invoice_form', array(), array('title' => 'แก้ไขใบแจ้งหนี้ (Invoice)', 'script' => 'invoice-vue.js'));
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

        $prefix = 'INV' . date('ym');

        if (empty($data['id'])) {
            $row = $this->Document_model->data();
        }
        $now = get_now();
        $this->db->trans_start();

        $row['id'] = !empty($data['id']) ? $data['id'] : null;
        $row['doc_no'] = !empty($data['id']) ? $data['doc_no'] : get_running($prefix);
        $row['doc_date'] = db_datejs($data['doc_date']);
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

    public function uploadfile()
    {
        $datafile = upload_file('file_upload', 'leave');

        json_output($datafile);
    }

    public function approval($id)
    {
        $data['result'] = $this->Document_model->get_by_id($id);
        $data['title'] = 'อนุมัติการลา - ' . $data['result']['firstname'] . ' ' . $data['result']['lastname'];
        $data['result']['type_name'] = get_type_text($data['result']['type']);
        $data['result']['image_url'] = get_img($data['result']['profile_picture'], '_sm');
        $data['result']['leave_date'] = str_date($data['result']['start_date']) . (!empty($data['result']['end_date']) ? ' - ' . str_date($data['result']['end_date']) : '');
        $this->load->view('leave/approval_form', $data);
    }

    public function set_status()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $row['id'] = $data['id'];
        $row['status'] = $data['status'];
        $this->Document_model->update($row);
        json_output($row);
    }

    public function pdf($id)
    {
        $data['leave'] = $this->Document_model->get_by_id($id);

        $pdf = new TCPDF('A4', 'mm', 'P', true, 'UTF-8', false);
        $pdf->SetTitle('ใบลางาน');

        /* ตั้งค่าระยะห่างของขอบกระดาษ */
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        /* ลบการตั้งค่า Header / footer */
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->SetAuthor('Tawatsak Tangeaim');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetHeaderData();

        $pdf->SetFont('thsarabun', '', 13, '', true);

        $html = $this->load->view('leave/pdf', $data, true);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('filename.pdf', 'I');
    }
}
