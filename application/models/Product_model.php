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
            'name' => 0,
            'unit' => null,
            'created_at' => null,
            'updated_at' => null,
            'detail' => null,
            'buy_price' => null,
            'sell_price' => null,
            'type' => null,
            'quantity' => null,
            'status' => null,
            'categorie_id' => null
        );
        return $data;
    }
}
