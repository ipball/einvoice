<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contact_model');
    }

	public function index()
	{
		template('contact/index', array(), array('title'=>'หมวดหมู่สินค้า', 'script' => 'contact.js'));
    }

    public function create()
    {
        $data['title'] = 'เพิ่มลูกค้า';
        $data['result'] = $this->Contact_model->data();        
		$this->load->view('contact/contact_form', $data);
    }

    public function edit($id){
		$data['result'] = $this->Contact_model->get_by_id($id);
		$data['title'] = $data['result']['name'];		
		$this->load->view('contact/contact_form', $data);
	}

	public function delete($id){
		$data = $this->Contact_model->delete($id);
		json_output($data);
	}

	public function save(){
		$data = json_decode(file_get_contents('php://input'),true);		
		if(empty($data['id'])){
			$row = $this->Contact_model->data();
        }
        
        $now = get_now();

		$row['id'] = !empty($data['id']) ? $data['id'] : null;
		$row['code'] = $data['code'];
		$row['tax_no'] = $data['tax_no'];
		$row['name'] = $data['name'];
		$row['contact_name'] = $data['contact_name'];
		$row['email'] = $data['email'];
		$row['tel'] = $data['tel'];
		$row['fax'] = $data['fax'];
		$row['website'] = $data['website'];
		$row['address'] = $data['address'];
		$row['credit_day'] = $data['credit_day'];
		$row['type'] = 1; // 1= customer
		$row['branch_no'] = $data['branch_no'];
		$row['branch_name'] = $data['branch_name'];
		$row['note'] = $data['note'];
        $row['updated_at'] = $now;
		$row['status'] = isset($data['status']) ? $data['status'] : 0;

		if(empty($data['id'])){
            $row['created_at'] = $now;
			$this->Contact_model->save($row);
		}else{			
			$this->Contact_model->update($row);
		}

		json_output($row);
	}	
    
    public function datatables()
    {
        $order_index = $this->input->get('order[0][column]');
		$param['page_size'] = $this->input->get('length');
		$param['start'] = $this->input->get('start');
		$param['draw'] = $this->input->get('draw');
		$param['keyword'] = trim($this->input->get('search[value]'));
		$param['column'] = $this->input->get("columns[{$order_index}][data]");
		$param['dir'] = $this->input->get('order[0][dir]');

		$results = $this->Contact_model->get_with_page($param);

		$data['draw'] = $param['draw'];
		$data['recordsTotal'] = $results['count'];
		$data['recordsFiltered'] = $results['count_condition'];
		$data['data'] = $results['data'];
		$data['error'] = $results['error_message'] ;

		json_output($data);
	}
	
	public function code_check()
    {
        $row = $this->Contact_model->get_code($this->input->post('code'));
        if (!empty($row)) {
            echo ($this->input->post('id') == $row['id']) ? 'true' : 'false';
        } else {
            echo 'true';
        }
	}
	
	public function get_all()
    {
        $data = $this->Contact_model->get_all_active();
        json_output($data);
    }
}
