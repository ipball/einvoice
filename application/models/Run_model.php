<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Run_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'runs';
        $this->delete_db = false;
        $this->delete_tbref = array();
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'val' => null,
        );
        return $data;
    }

    public function add_number($id) {
		$this->db->set('val', 'val+1', FALSE);
		$this->db->where('id', $id);
		$this->db->update($this->_table);
	}
}
