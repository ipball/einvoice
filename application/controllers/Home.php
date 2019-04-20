<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	private $sess;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Invoice_model');
		$this->sess = $this->session->userdata(app_session());
	}

	public function index()
	{				
		redirect('invoice');
				
	}
}
