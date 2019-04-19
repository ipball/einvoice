<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Authen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');        
    }

    public function index()
    {
        $this->load->view('authen/index');
    }

    public function check_user()
    {
        $post = $this->input->post();
        $result = $this->User_model->login($post['username'], md5($post['password']));
        if (!empty($result)) {
            $data = array(
                'id' => $result['id'],
                'username' => $result['username'],
                'name' => $result['name'],
                'email' => $result['email'],
                'tel' => null,
                'address' => null,
                'profile_picture' => get_img(null, '_sm', 'assets/img/admin-avatar.png'),
                'role' => 'Administrator',
            );
            $this->session->set_userdata(app_session(), $data);
            redirect(site_url('/'), 'refresh');
        } else {
            $this->session->set_flashdata('err_login_wrong', 'Username หรือ Password ผิด!');
            redirect(site_url('authen'));
        }
    }

    public function logout()
    {        
        $this->session->unset_userdata(app_session());
        redirect(site_url('authen'), 'refresh');
    }
}
