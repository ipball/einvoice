<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Documentdetail_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'document_details';
        $this->delete_db = true;
        $this->delete_tbref = array('documents');
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'line_no' => null,
            'product_name' => null,
            'quantity' => 0,
            'price' => 0,
            'cost_price' => 0,
            'total' => null,
            'unit' => null,
            'product_id' => null,
            'document_id' => null,
        );
        return $data;
    }

    public function delete_by_document($id)
    {
        $this->db->where('document_id', $id);
        $this->db->delete($this->_table);
    }

    public function get_by_document($id)
    {
        $query = $this->db->select('p.sku, p.id, p.type, d.product_name as name, d.quantity as amount, d.price as sell_price, d.cost_price as buy_price, d.unit, p.profile_picture')
            ->from($this->_table . ' d')
            ->join('products p', 'd.product_id=p.id', 'inner')
            ->where('d.document_id', $id)
            ->get();
        return $query->result_array();
    }
}
