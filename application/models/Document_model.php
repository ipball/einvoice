<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Document_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'documents';
        $this->delete_db = false;
        $this->delete_tbref = array();
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'doc_no' => null,
            'doc_date' => null,
            'due_date' => null,
            'ref_doc' => null,
            'payment_type' => null,
            'credit_day' => null,
            'contact_name' => null,
            'contact_address' => null,
            'contact_email' => null,
            'contact_tel' => null,
            'contact_fax' => null,
            'contact_tax_no' => null,
            'contact_branch_name' => null,
            'remark' => null,
            'vat_type' => null,
            'vat' => 0,
            'discount' => 0,
            'total' => 0,
            'grand_total' => 0,
            'type' => null,
            'updated_at' => null,
            'updated_by' => null,
            'balance' => 0,
            'pay_total' => 0,
            'status' => null,
            'created_at' => null,
            'created_by' => null,
            'contact_id' => null,
        );
        return $data;
    }

    public function get_with_page($param)
    {
        $keyword = $param['keyword'];
        $this->db->select('d.*, c.name');

        $condition = "d.doc_date between '{$param['start_doc_date']}' and '{$param['end_doc_date']}'";
        $condition .= !empty($keyword) ? " and (d.doc_no like '%{$keyword}%')" : "";
        $condition .= !empty($param['status']) ? " and d.status='{$param['status']}'" : "";

        $this->db->from('documents d');
        $this->db->join('contacts c', 'd.contact_id=c.id', 'inner');
        $this->db->where($condition);
        $this->db->limit($param['page_size'], $param['start']);
        $this->db->order_by($param['column'], $param['dir']);

        $query = $this->db->get();
        $data = ($query->num_rows() > 0) ? $query->result_array() : [];

        $count_condition = $this->db->from('documents d')
            ->join('contacts c', 'd.contact_id=c.id', 'inner')
            ->where($condition)
            ->count_all_results();
        $count = $this->db->from($this->_table)->count_all_results();
        $result = array('count' => $count, 'count_condition' => $count_condition, 'data' => $data, 'error_message' => '');
        return $result;
    }

    public function get_by_id($id)
    {
        $query = $this->db->select('d.*, c.code as contact_code, c.name as company_name')
        ->from('documents d')
        ->join('contacts c', 'd.contact_id=c.id', 'inner')
        ->where('d.id', $id)
        ->get();        
        return $query->row_array();
    }
}
