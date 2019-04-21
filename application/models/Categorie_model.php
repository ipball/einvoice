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
            'detail' => 0,
            'status' => null
        );
        return $data;
    }
}
