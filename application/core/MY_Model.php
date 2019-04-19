<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model {
	/**
	* Variables
	**/
	protected $_table;
	protected $primary_key = 'id';

	protected $delete_db = FALSE;
	protected $delete_tbref = array();

	public function __construct(){
		parent::__construct();
	}

	// set fkey
	public function get_fk($var)
	{
		return substr($var, 0, strlen($var)-1);
	}

	/**
	* CRUD Interface
	**/
	public function get_all(){
		$query = $this->db->select('*')
		->from($this->_table)		
		->get();
		return $query->result_array();
	}

	public function count_all_refid($id, $table_ref){
		$query = $this->db->select('*')
		->from($table_ref)
		->where($this->get_fk($this->_table) . '_id', $id);
		return $query->count_all_results();	
	}

	public function get_by_id($id){
		$query = $this->db->select('*')
		->from($this->_table)
		->where(array($this->primary_key => $id))
		->get();
		return $query->row_array();
	}

	public function get_all_active(){
		$query = $this->db->select('*')
		->from($this->_table)
		->where(array('status' => TRUE))
		->get();
		return $query->result_array();
	}

	public function get_by_id_active($id){
		$query = $this->db->select('*')
		->from($this->_table)
		->where(array('status'=>TRUE, $this->primary_key => $id))	
		->get();
		return $query->row_array();
	}

	public function save($data = NULL) {
		$this->db->insert($this->_table, $data);
	}

	public function update($data) {
		$this->db->where(array($this->primary_key => $data['id']));
		$this->db->update($this->_table, $data);
	}

	public function delete($id) {		
		if($this->delete_db){
			if(!empty($this->delete_tbref)){
				foreach($this->delete_tbref as $item){
					$count = $this->count_all_refid($id, $item);
					if($count == 0){
						$this->db->where($this->primary_key, $id);
						$this->db->delete($this->_table);
						return TRUE;
					}
					return FALSE;
				}				
			}
			return FALSE;	
		}else{
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->_table);	
			return TRUE;
		}
		
	}

}