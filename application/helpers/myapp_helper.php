<?php
defined('BASEPATH') or exit('No direct script access allowed');

function template($content, $data = array(), $value = array())
{
    $CI = &get_instance();
    $temp['title'] = !empty($value['title']) ? $value['title'] : 'ระบบลางานออนไลน์';
    $temp['script'] = !empty($value['script']) ? $value['script'] : null;
    $temp['content'] = $CI->load->view($content, $data, true);
    $CI->load->view('layout/master', $temp);
}

function json_output($value)
{
    $CI = &get_instance();
    return $CI->output->set_content_type('application/json')->set_output(json_encode($value));
}

function app_session()
{
    return 'leaveSyS';
}


function form_number($data = '', $value = '', $extra = '')
{
    $defaults = array(
        'type' => 'number',
        'name' => is_array($data) ? '' : $data,
        'value' => $value
    );

    return '<input '._parse_form_attributes($data, $defaults)._attributes_to_string($extra)." />\n";
}

function db_date($value)
{
    if (!empty($value)) {
        $arr = explode('/', $value);
        $db_date = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
    } else {
        $db_date = null;
    }
    return $db_date;
}

function str_date($value)
{
    if (!empty($value) && $value != '0000-00-00') {
        $arr = explode('-', $value);
        $str_date = $arr[2] . '/' . $arr[1] . '/' . $arr[0];
    } else {
        $str_date = null;
    }

    return $str_date;
}

function upload_img($file_upload = 'file_upload', $prefix = '')
{
    $ci = &get_instance();

    /* ตรวจสอบว่าภาพมีการอัพไหม? ถ้าไม่มีให้ใช้ชื่อเดิมหรือชื่อ default */
    if ($_FILES[$file_upload]['name'] != '') {
        $file_name = uniqid($prefix); /* change here ----------------------------*/
    } else {
        $file_name = ($ci->input->post('post_image') != '') ? $ci->input->post('post_image') : 'image.jpg';
    }

    /* กำหนดการอัพโหลดไฟล์ */
    $config['upload_path'] = './uploads/img/';
    $config['allowed_types'] = 'jpg|png|gif';
    $config['max_size'] = 1024 * 5;
    $config['overwrite'] = true;
    $config['file_name'] = $file_name;
    /*อัพโหลดไฟล์ */
    $ci->load->library('upload', $config);

    /*ตรวจสอบว่าอัพโหลดหรือไม่? ถ้าใช่ให้ปรับลดรูปภาพด้วย */
    if ($ci->upload->do_upload($file_upload) && $_FILES[$file_upload]['name'] != '') {
        $source_image = $ci->upload->upload_path . $ci->upload->file_name;
        list($width, $height, $type, $attr) = getimagesize($source_image);
        if ($ci->upload->file_name != 'image.jpg') {
            $ci->load->library('image_lib');
            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_image;

            /*resize*/
            /*new source image by crop*/
            $config['source_image'] = $source_image;

            $config['maintain_ratio'] = true;
            $config['width'] = 160;
            $config['height'] = 160;
            $config['new_image'] = fullimage($ci->upload->file_name, '_sm');
            $ci->image_lib->initialize($config);
            $ci->image_lib->resize();
            $ci->image_lib->clear();

            $config['maintain_ratio'] = true;
            $config['width'] = 400;
            $config['height'] = 400;
            $config['new_image'] = fullimage($ci->upload->file_name, '_thumb');
            $ci->image_lib->initialize($config);
            $ci->image_lib->resize();
            $ci->image_lib->clear();

            $config['width'] = 800;
            $config['height'] = 800;
            $config['maintain_ratio'] = true;
            $config['new_image'] = fullimage($ci->upload->file_name, '_extra');
            $ci->image_lib->initialize($config);
            $ci->image_lib->resize();
            $ci->image_lib->clear();

            @unlink($ci->upload->upload_path . $ci->upload->file_name);
        }
    }

    /* ชื่อไฟล์ */
    if ($_FILES[$file_upload]['name'] != '') {
        $data = $ci->upload->data();
        $datafile = $data['file_name'];
    } else {
        $datafile = $file_name;
    }

    return $datafile;
}

function fullimage($fileimage, $prefix, $type = 'remove')
{
    if ($fileimage == '' && $type != 'remove') {
        $fullimage = 'image.jpg';
    } else {
        $fullimage = strstr($fileimage, '.', true) . $prefix . strrchr($fileimage, '.');
    }

    return $fullimage;
}

function delete_image($path_name, $file_name)
{    
    @unlink($path_name . fullimage($file_name, '_sm'));
    @unlink($path_name . fullimage($file_name, '_thumb'));
    @unlink($path_name . fullimage($file_name, '_extra'));
}

function upload_file($file_upload = 'file_upload', $prefix = '')
{
    $ci = &get_instance();

    /* ตรวจสอบว่าภาพมีการอัพไหม? ถ้าไม่มีให้ใช้ชื่อเดิมหรือชื่อ default */
    if ($_FILES[$file_upload]['name'] != '') {
        $file_name = uniqid($prefix);
    } else {
        return false;
    }

    /* กำหนดการอัพโหลดไฟล์ */
    $config['upload_path'] = './uploads/file/';
    $config['allowed_types'] = 'jpg|png|gif|jpeg|pdf|doc';
    $config['max_size'] = 1024 * 5;
    $config['overwrite'] = true;
    $config['file_name'] = $file_name;
    /*อัพโหลดไฟล์ */
    $ci->load->library('upload', $config);

    $ci->upload->do_upload($file_upload);

    /* ชื่อไฟล์ */
    if ($_FILES[$file_upload]['name'] != '') {
        $data = $ci->upload->data();
        $datafile = $data['file_name'];
    } else {
        $datafile = $file_name;
    }

    return $datafile;
}

function get_type_text($type_id)
{
    $result = null;
    switch ($type_id) {
        case 1:
            $result = 'ลาเต็มวัน';
            break;
        case 2:
            $result = 'ลาครึ่งเช้า';
            break;
        case 3:
            $result = 'ลาครึ่งบ่าย';
            break;
        default:
            $result = null;
            break;
    }
    return $result;
}

function get_img($profile_picture, $size, $default = null)
{
    $img = empty($default) ? 'assets/img/image.jpg' : $default;
    $result = !empty($profile_picture) ? base_url('uploads/img/'.fullimage($profile_picture, $size, 'show')) : base_url($img);
    return $result;
}

function find_float($number)
{
    $result = $number;
    $float = substr($number, strpos($number, '.')+1);
    if($float == 0){
        $result = number_format($number);
    }
    return $result;
}

function get_status_text($status_id)
{
    $result = null;
    switch ($status_id) {
        case 1:
            $result = 'รออนุมัติ';
            break;
        case 2:
            $result = 'อนุมัติแล้ว';
            break;
        case 3:
            $result = 'ไม่อนุมัติ';
            break;
        case 4:
            $result = 'ยกเลิก';
            break;            
        default:
            $result = null;
            break;
    }
    return $result;
}

function get_status_badge($status_id)
{
    $result = null;
    switch ($status_id) {
        case 1:
            $result = 'badge-info';
            break;
        case 2:
            $result = 'badge-success';
            break;
        case 3:
            $result = 'badge-danger';
            break;
        case 4:
            $result = 'badge-default';
            break;            
        default:
            $result = null;
            break;
    }
    return $result;
}