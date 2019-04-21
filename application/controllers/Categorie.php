<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorie extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Categorie_model');
    }

	public function index()
	{
		template('categorie/index', array(), array('title'=>'หมวดหมู่สินค้า', 'script' => 'categorie.js'));
    }

    public function create()
    {
        $data['title'] = 'เพิ่มหมวดหมู่สินค้า';
        $data['result'] = $this->Categorie_model->data();        
		$this->load->view('categorie/categorie_form', $data);
    }

    public function edit($id){
		$data['result'] = $this->Categorie_model->get_by_id($id);
		$data['title'] = $data['result']['name'];		
		$this->load->view('categorie/categorie_form', $data);
	}

	public function delete($id){
		$data = $this->Categorie_model->delete($id);
		json_output($data);
	}

	public function save(){
		$data = json_decode(file_get_contents('php://input'),true);		
		if(empty($data['id'])){
			$row = $this->Categorie_model->data();
        }
        
        $now = get_now();

		$row['id'] = !empty($data['id']) ? $data['id'] : null;
		$row['name'] = $data['name'];
        $row['detail'] = $data['detail'];
        $row['updated_at'] = $now;
		$row['status'] = isset($data['status']) ? $data['status'] : 0;

		if(empty($data['id'])){
            $row['created_at'] = $now;
			$this->Categorie_model->save($row);
		}else{			
			$this->Categorie_model->update($row);
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

		$results = $this->Categorie_model->get_with_page($param);

		$data['draw'] = $param['draw'];
		$data['recordsTotal'] = $results['count'];
		$data['recordsFiltered'] = $results['count_condition'];
		$data['data'] = $results['data'];
		$data['error'] = $results['error_message'] ;

		json_output($data);
    }
}
