<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'users';
        $this->delete_db = true;
        $this->delete_tbref = array('documents');
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'username' => null,
            'password' => null,
            'name' => null,
            'email' => null,
            'token' => null,
            'token_date' => null,
            'status' => true,
        );
        return $data;
    }

    public function get_with_page($param)
    {
        $keyword = $param['keyword'];
        $this->db->select('*');

        $condition = "1=1";
        if (!empty($keyword)) {
            $condition .= " and (username like '%{$keyword}%' or name like '%{$keyword}%' or email like '%{$keyword}%')";
        }

        $this->db->where($condition);
        $this->db->limit($param['page_size'], $param['start']);
        $this->db->order_by($param['column'], $param['dir']);

        $query = $this->db->get($this->_table);
        $data = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                unset($row['password']);
                unset($row['token']);
                unset($row['token_date']);
                $data[] = $row;
            }
        }

        $count_condition = $this->db->from($this->_table)->where($condition)->count_all_results();
        $count = $this->db->from($this->_table)->count_all_results();
        $result = array('count' => $count, 'count_condition' => $count_condition, 'data' => $data, 'error_message' => '');
        return $result;
    }

    public function get_username($username)
    {
        $query = $this->db->where('username', $username)->get($this->_table);
        return $query->row_array();
	}
	
	public function get_email($email)
    {
        $query = $this->db->where('email', $email)->get($this->_table);
        return $query->row_array();
    }

    public function login($username, $password)
    {
		$query = $this->db->select('*')
		->from($this->_table)
		->where(array('username'=>$username, 'password'=>$password, 'status'=>true))
		->get();
		return $query->row_array();
	}
}
