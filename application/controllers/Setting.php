<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	private $sess;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Setting_model');		
		$this->sess = $this->session->userdata(app_session());
	}

	public function index()
	{	
		$data['company_name'] = $this->Setting_model->get_by_name('company_name');
		$data['address'] = $this->Setting_model->get_by_name('address');
		$data['news'] = $this->Setting_model->get_by_name('news');
		$data['logo'] = $this->Setting_model->get_by_name('logo');
		template('setting/index', $data, array('title'=>'ตั้งค่า | ระบบลางานออนไลน์', 'script' => 'setting.js'));
	}

	public function save()
	{
		$cols = array('company_name', 'address', 'logo', 'news');
		foreach($cols as $key => $col) {
			$id = $key+1;
			$row['id'] = $id;
			$row['value'] = $this->input->post($col);
			$this->Setting_model->update($row);
		}
		$flash = array('type'=>'success', 'msg'=>'บันทึกข้อมูลเรียบร้อยแล้ว');
		$this->session->set_flashdata('message', $flash);
		redirect('setting');
	}
}
