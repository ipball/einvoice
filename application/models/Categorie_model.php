<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Categorie_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'categories';
        $this->delete_db = true;
        $this->delete_tbref = array('products');
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'name' => null,
            'created_at' => null,
            'updated_at' => null,
            'detail' => null,
            'status' => true
        );
        return $data;
    }

    public function get_with_page($param)
    {
        $keyword = $param['keyword'];
        $this->db->select('*');

        $condition = "1=1";
        if (!empty($keyword)) {
            $condition .= " and (name like '%{$keyword}%')";
        }

        $this->db->where($condition);
        $this->db->limit($param['page_size'], $param['start']);
        $this->db->order_by($param['column'], $param['dir']);

        $query = $this->db->get($this->_table);                
        $data = ($query->num_rows() > 0) ? $query->result_array() : [];

        $count_condition = $this->db->from($this->_table)->where($condition)->count_all_results();
        $count = $this->db->from($this->_table)->count_all_results();
        $result = array('count' => $count, 'count_condition' => $count_condition, 'data' => $data, 'error_message' => '');
        return $result;
    }
}
