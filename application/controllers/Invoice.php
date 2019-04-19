<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice extends CI_Controller {
	private $sess;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_model');				
		$this->sess = $this->session->userdata(app_session());
    }

    public function index()
	{		
		$data['status'] = get_status('สถานะทั้งหมด');		
				
		template('invoice/index', $data, array('title'=>'รายการใบแจ้งหนี้ (Invoice)', 'script' => 'invoice.js'));
	}	

    public function create()
    {		        
		$data['result'] = $this->Invoice_model->data();	
		template('invoice/invoice_form', $data, array('title'=>'สร้างใบแจ้งหนี้ (Invoice)', 'script' => 'invoice-vue.js'));
    }

    public function edit($id){			
		$employee = $this->Employee_model->get_by_id($this->sess['id']);
		$leave_par['employee_id'] = $this->sess['id'];
		$leave_par['status'] = 2;
		$sum_leave = $this->Leave_model->employee_leave($leave_par);		
		$data['remain_leave'] = $employee['leave_of_year'] - (!empty($sum_leave['total']) ? $sum_leave['total'] : 0);		

		$data['result'] = $this->Leave_model->get_by_id($id);
		
		template('invoice/index', $data, array('title'=>'แก้ไขใบแจ้งหนี้ (Invoice)', 'script' => 'invoice.js'));
	}

	public function delete($id){
		$result = $this->Leave_model->get_by_id($id);
		if(!empty($result['reference_file'])){			
			@unlink(FCPATH.'uploads/file/' . $result['reference_file']);
		}
		$data = $this->Leave_model->delete($id);
		json_output($data);
	}

	public function save(){
		$data = json_decode(file_get_contents('php://input'),true);		

		if(empty($data['id'])){
			$row = $this->Leave_model->data();
		}

		$row['id'] = !empty($data['id']) ? $data['id'] : null;
        $row['type'] = $data['type'];
        $row['start_date'] = db_date($data['start_date']);
		$row['end_date'] = db_date($data['end_date']);
		$row['total'] = $data['total'];
		$row['reason'] = !empty($data['reason']) ? $data['reason'] : null;
		$row['address'] = !empty($data['address']) ? $data['address'] : null;
		$row['tel'] = !empty($data['tel']) ? $data['tel'] : null;
		$row['temple_name'] = !empty($data['temple_name']) ? $data['temple_name'] : null;
		$row['temple_address'] = !empty($data['temple_address']) ? $data['temple_address'] : null;
		$row['temple_tel'] = !empty($data['temple_tel']) ? $data['temple_tel'] : null;
		$row['wife_name'] = !empty($data['wife_name']) ? $data['wife_name'] : null;
		$row['spawn_date'] = !empty($data['spawn_date']) ? db_date($data['spawn_date']) : null;
		$row['summons'] = !empty($data['summons']) ? $data['summons'] : null;
		$row['summons_address'] = !empty($data['summons_address']) ? $data['summons_address'] : null;
		$row['summons_date'] = !empty($data['summons_date']) ? db_date($data['summons_date']) : null;
		$row['summons_reason'] = !empty($data['summons_reason']) ? $data['summons_reason'] : null;
		$row['summons_place'] = !empty($data['summons_place']) ? $data['summons_place'] : null;
		$row['reference_file'] = !empty($data['reference_file']) ? $data['reference_file'] : null;
		$row['status_detail'] = !empty($data['status_detail']) ? $data['status_detail'] : null;
		$row['employee_id'] = $this->sess['id'];
		$row['leave_type_id'] = $data['leave_type_id'];		
		
		if(empty($data['id'])){
			$row['status'] = 1;
			$row['created_at'] = date('Y-m-d H:i:s');
			$this->Leave_model->save($row);
		}else{
			$this->Leave_model->update($row);
		}

		json_output($row);
	}
    
    public function datatables_leave()
    {
        $order_index = $this->input->get('order[0][column]');
		$param['page_size'] = $this->input->get('length');
		$param['start'] = $this->input->get('start');
		$param['draw'] = $this->input->get('draw');
		$param['keyword'] = trim($this->input->get('keyword'));
		$param['column'] = $this->input->get("columns[{$order_index}][data]");
		$param['dir'] = $this->input->get('order[0][dir]');
		$param['department_id'] = $this->input->get('department_id');
		$param['leave_type_id'] = $this->input->get('leave_type_id');
		$param['status'] = $this->input->get('status');
		$param['start_date'] = !empty($this->input->get('start_date')) ? $this->input->get('start_date') : date('Y-m-01');
		$param['end_date'] = !empty($this->input->get('end_date')) ? $this->input->get('end_date') : date('Y-m-t');
		$param['is_employee'] = $this->input->get('is_employee');
		$param['employee_id'] = $this->sess['id'];
		$results = $this->Leave_model->get_with_page($param);

		foreach($results['data'] as &$value) {
			$value['own_action'] = $this->sess['id']==$value['employee_id'] ? true : false;
			$value['role'] = strtoupper($this->sess['role']);
		}

		$data['draw'] = $param['draw'];
		$data['recordsTotal'] = $results['count'];
		$data['recordsFiltered'] = $results['count_condition'];
		$data['data'] = $results['data'];
		$data['error'] = $results['error_message'] ;

		json_output($data);
	}
	
	public function uploadfile(){
		$datafile = upload_file('file_upload', 'leave');	

		json_output($datafile);
	}

	public function approval($id)
	{
		$data['result'] = $this->Leave_model->get_by_id($id);	
		$data['title'] = 'อนุมัติการลา - ' . $data['result']['firstname'] . ' ' . $data['result']['lastname'];		
		$data['result']['type_name'] = get_type_text($data['result']['type']);
		$data['result']['image_url'] = get_img($data['result']['profile_picture'], '_sm');
		$data['result']['leave_date'] = str_date($data['result']['start_date']) . (!empty($data['result']['end_date']) ? ' - '.str_date($data['result']['end_date']) : '');
		$this->load->view('leave/approval_form', $data);
	}

	public function set_status()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$row['id'] = $data['id'];
		$row['status'] = $data['status'];
		$this->Leave_model->update($row);
		json_output($row);
	}

	public function pdf($id)
	{		
		$data['leave'] = $this->Leave_model->get_by_id($id);		
        
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