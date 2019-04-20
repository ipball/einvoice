<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function get_all()
	{
        $data = $this->Product_model->get_all_active();
		json_output($data);
	}
}