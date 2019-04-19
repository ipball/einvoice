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

function get_employee_type($default = "เลือกประเภทพนักงาน")
{
    // 1=Full-time, 2=Part-time, 3=Temporary, 4=Outsource        
    $results = array(
        '' => $default,
        '1' => 'พนักงานประจำ',
        '2' => 'พนักงาน Part-time',
        '3' => 'พนักงานชั่วคราว',
        '4' => 'Outsource'
    );
    return $results;
}

function get_leave_type($default = "เลือกประเภท")
{        
    $CI = &get_instance();
    $CI->load->model('Leavetype_model');
    $results = $CI->Leavetype_model->get_all_active();
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