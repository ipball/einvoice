<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Authen
{
    public function __construct()
    {
        $this->CI = &get_instance();
    }
    public function permission()
    {
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        
        $exclude_class = array('authen', 'migrate');

        if (!in_array($class, $exclude_class)) {
            if (empty($this->CI->session->userdata(app_session()))) {
                $this->CI->session->set_flashdata('err_login_wrong', 'เซสซั่นของคุณหมดอายุ กรุณาเข้าระบบใหม่!');
                redirect('authen', 'refresh');
                exit();
            }
        }
    }

}