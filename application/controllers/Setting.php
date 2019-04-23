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
        $settings = $this->Setting_model->get_all();
        foreach ($settings as $setting) {
            $data[$setting['name']] = $setting['value'];
        }
		template('setting/index', $data, array('title'=>'ตั้งค่า', 'script' => 'setting.js'));
	}

	public function save()
	{
		$cols = array('company_name', 'address', 'tax_no', 'branch', 'tel', 'fax', 'website', 'logo','vat');
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
