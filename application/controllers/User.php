<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

	public function index()
	{
		template('user/index', array(), array('title'=>'ผู้ใช้งาน | ระบบลางานออนไลน์', 'script' => 'user.js'));
    }

    public function create()
    {
        $data['title'] = 'เพิ่มข้อมูลสมาชิก';
        $data['result'] = $this->User_model->data();        
		$this->load->view('user/user_form', $data);
    }

    public function edit($id){
		$data['result'] = $this->User_model->get_by_id($id);
		$data['title'] = $data['result']['username'];		
		$this->load->view('user/user_form', $data);
	}

	public function delete($id){
		$data = $this->User_model->delete($id);
		json_output($data);
	}

	public function save(){
		$data = json_decode(file_get_contents('php://input'),true);		
		if(empty($data['id'])){
			$row = $this->User_model->data();
		}

		$row['id'] = !empty($data['id']) ? $data['id'] : null;
		$row['username'] = $data['username'];
		$row['name'] = $data['name'];
		$row['email'] = $data['email'];
		$row['status'] = isset($data['status']) ? $data['status'] : 0;

		if((!empty($data['password']))) {
			$row['password'] = md5($data['password']);
		}

		if(empty($data['id'])){
			$this->User_model->save($row);
		}else{			
			$this->User_model->update($row);
		}

		json_output($row);
	}

	public function username_check(){
		$row = $this->User_model->get_username($this->input->post('name'));
		if(!empty($row)){
			echo ($this->input->post('id') == $row['id']) ? 'true' : 'false';
		}else{
			echo 'true';
		}
	}

	public function email_check(){
		$row = $this->User_model->get_email($this->input->post('name'));
		if(!empty($row)){
			echo ($this->input->post('id') == $row['id']) ? 'true' : 'false';
		}else{
			echo 'true';
		}
	}
    
    public function datatables_user()
    {
        $order_index = $this->input->get('order[0][column]');
		$param['page_size'] = $this->input->get('length');
		$param['start'] = $this->input->get('start');
		$param['draw'] = $this->input->get('draw');
		$param['keyword'] = trim($this->input->get('search[value]'));
		$param['column'] = $this->input->get("columns[{$order_index}][data]");
		$param['dir'] = $this->input->get('order[0][dir]');

		$results = $this->User_model->get_with_page($param);

		$data['draw'] = $param['draw'];
		$data['recordsTotal'] = $results['count'];
		$data['recordsFiltered'] = $results['count_condition'];
		$data['data'] = $results['data'];
		$data['error'] = $results['error_message'] ;

		json_output($data);
    }
}
