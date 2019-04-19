<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Setting_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'settings';
        $this->delete_db = false;
        $this->delete_tbref = array();
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'name' => null,
            'value' => null,
        );
        return $data;
    }

    public function get_by_name($name)
    {
		$query = $this->db->select('*')
		->from($this->_table)
		->where('name', $name)
		->get();
		return $query->row_array();
    }
}
