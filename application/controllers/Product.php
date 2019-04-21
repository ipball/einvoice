<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index()
	{		
		template('product/index', array(), array('title'=>'สินค้า', 'script' => 'product.js'));
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
		$param['department_id'] = $this->input->get('department_id');
		$results = $this->Product_model->get_with_page($param);

		$data['draw'] = $param['draw'];
		$data['recordsTotal'] = $results['count'];
		$data['recordsFiltered'] = $results['count_condition'];
		$data['data'] = $results['data'];
		$data['error'] = $results['error_message'] ;

		json_output($data);
    }
    
    public function create()
    {
        $data['title'] = 'เพิ่มสินค้า';
		$data['result'] = $this->Product_model->data();
        $data['result']['image_url'] = get_img($data['result']['profile_picture'], '_sm');
        $data['categories'] = get_categorie();
        $data['types'] = get_product_type();
		$this->load->view('product/product_form', $data);
    }

    public function edit($id){
		$data['result'] = $this->Product_model->get_by_id($id);
		$data['result']['image_url'] = get_img($data['result']['profile_picture'], '_sm');
		$data['title'] = $data['result']['username'];
        $data['categories'] = get_categorie();
        $data['types'] = get_product_type();
		$this->load->view('product/product_form', $data);
	}

    public function get_all()
	{
        $data = $this->Product_model->get_all_active();
		json_output($data);
    }
    
    public function sku_check(){
		$row = $this->Product_model->get_sku($this->input->post('sku'));
		if(!empty($row)){
			echo ($this->input->post('id') == $row['id']) ? 'true' : 'false';
		}else{
			echo 'true';
		}
    }
    
    public function uploadpic(){
		$datafile = upload_img('file_upload', 'pro_');	

		json_output($datafile);
    }
    
    public function save(){
		$data = json_decode(file_get_contents('php://input'),true);		
		if(empty($data['id'])){
			$row = $this->Product_model->data();
		}

		$row['id'] = !empty($data['id']) ? $data['id'] : null;
		$row['sku'] = $data['sku'];
        $row['barcode'] = $data['barcode'];
        $row['name'] = $data['name'];
		$row['unit'] = $data['unit'];
		$row['updated_at'] = date('Y-m-d H:i:s');
		$row['detail'] = $data['detail'];
		$row['buy_price'] = $data['buy_price'];
		$row['sell_price'] = $data['sell_price'];
		$row['type'] = $data['type'];
		$row['quantity'] = $data['quantity'];
		$row['profile_picture'] = $data['profile_picture'];
		$row['categorie_id'] = $data['categorie_id'];
		$row['status'] = isset($data['status']) ? $data['status'] : 0;

		if(empty($data['id'])){
			$row['created_at'] = date('Y-m-d H:i:s');
			$this->Product_model->save($row);
		}else{
			$this->Product_model->update($row);
		}

		json_output($row);
    }
    
    public function delete($id){
		$result = $this->Product_model->get_by_id($id);
        $data = $this->Product_model->delete($id);
        
        if($data){
            if(!empty($result['profile_picture'])){
                delete_image(FCPATH.'uploads/img/', $result['profile_picture']);
            }
        }

		json_output($data);
	}
}