<?php
defined('BASEPATH') or exit('No direct script access allowed');

function get_department($default = "เลือกแผนก")
{
    $CI = &get_instance();
    $CI->load->model('Department_model');
    $results = $CI->Department_model->get_all_active();
    array_unshift($results, array('id' => '', 'name' => $default));
    return array_column($results, 'name', 'id');
}

function get_product_type($default = "เลือกประเภทสินค้า")
{    
    $results = array(
        '' => $default,
        '1' => 'สินค้านับสต็อก',
        '2' => 'สินค้าไม่นับสต็อก',
        '3' => 'สินค้าบริการ'        
    );
    return $results;
}

function get_categorie($default = "เลือกประเภท")
{        
    $CI = &get_instance();
    $CI->load->model('Categorie_model');
    $results = $CI->Categorie_model->get_all_active();
    array_unshift($results, array('id' => '', 'name' => $default));
    return array_column($results, 'name', 'id');
}

function get_status($default = "เลือกสถานะ")
{
    // 1=Full-time, 2=Part-time, 3=Temporary, 4=Outsource        
    $results = array(
        '' => $default,
        '1' => 'รอตรวจสอบ',
        '2' => 'อนุมัติ',
        '3' => 'ไม่อนุมัติ'
    );
    return $results;
}