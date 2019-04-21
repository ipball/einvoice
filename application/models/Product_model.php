<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Product_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'products';
        $this->delete_db = true;
        $this->delete_tbref = array('document_details');
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'sku' => null,
            'barcode' => null,
            'profile_picture' => null,
            'name' => null,
            'unit' => null,
            'created_at' => null,
            'updated_at' => null,
            'detail' => null,
            'buy_price' => null,
            'sell_price' => null,
            'type' => null,
            'quantity' => null,
            'status' => true,
            'categorie_id' => null
        );
        return $data;
    }

    public function get_with_page($param)
    {
        $keyword = $param['keyword'];
        $this->db->select('p.*, c.name as categorie_name');

        $condition = "1=1";        
        $condition .= !empty($keyword) ? " and (p.sku like '%{$keyword}%' or p.barcode like '%{$keyword}%' or p.name like '%{$keyword}%')" : "";
        $condition .= !empty($param['categorie_id']) ? " and c.id='{$param['categorie_id']}'" : "";

        $this->db->where($condition);
        $this->db->limit($param['page_size'], $param['start']);
        $this->db->order_by($param['column'], $param['dir']);
        $this->db->from($this->_table.' p');
        $this->db->join('categories c', 'p.categorie_id=c.id');

        $query = $this->db->get();
        $data = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['image_url'] = !empty($row['profile_picture']) ?
                    base_url('uploads/img/'.fullimage($row['profile_picture'], '_sm', 'show')) :
                    base_url('assets/img/image.jpg');
                $data[] = $row;
            }
        }

        $count_condition = $this->db->from($this->_table . ' p')->join('categories c', 'p.categorie_id=c.id')->where($condition)->count_all_results();
        $count = $this->db->from($this->_table)->count_all_results();
        $result = array('count' => $count, 'count_condition' => $count_condition, 'data' => $data, 'error_message' => '');
        return $result;
    }

    public function get_sku($sku)
    {
        $query = $this->db->where('sku', $sku)->get($this->_table);
        return $query->row_array();
	}
}
