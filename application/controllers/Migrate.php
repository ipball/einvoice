<?php defined("BASEPATH") or exit("No direct script access allowed");

class Migrate extends CI_Controller
{

    public function index()
    {
        $this->load->library("migration");
        if ($this->migration->current()) {
            echo 'migrate success.';
        } else {
            show_error($this->migration->error_string());
        }
    }

    public function seeder()
    {
        $this->load->model('User_model');
        $this->load->model('Setting_model');

        // user section
        $users = array(
            'username' => 'admin',
            'password' => '81dc9bdb52d04dc20036dbd8313ed055',
            'name' => 'Tawatsak Tangeaim',
            'email' => 'itoffside@hotmail.com',
            'status' => true,
        );
        $this->User_model->save($users);

        // company section
        $setting = array(
            'id' => 1,
            'name' => 'company_name',            
            'value' => 'Bahtsoft จำกัด',
        );
        $this->Setting_model->save($setting);

        // address section
        $setting = array(
            'id' => 2,
            'name' => 'address',            
            'value' => '123/456 ต.ฟ้าคราม อ.เชียง จ.อภินิหารใจ',
        );
        $this->Setting_model->save($setting);

        // tax no section
        $setting = array(
            'id' => 3,
            'name' => 'tax_no',            
            'value' => '1234567890123',
        );
        $this->Setting_model->save($setting);

        // branch section
        $setting = array(
            'id' => 4,
            'name' => 'branch',            
            'value' => 'สำนักงานใหญ่',
        );
        $this->Setting_model->save($setting);

        // tel section
        $setting = array(
            'id' => 5,
            'name' => 'tel',            
            'value' => '0811448167',
        );
        $this->Setting_model->save($setting);

        // fax section
        $setting = array(
            'id' => 6,
            'name' => 'fax',            
            'value' => '0521345679',
        );
        $this->Setting_model->save($setting);

        // website section
        $setting = array(
            'id' => 7,
            'name' => 'website',            
            'value' => 'https://www.bahtsoft.com',
        );
        $this->Setting_model->save($setting);

        // logo company section
        $setting = array(
            'id' => 8,
            'name' => 'logo',            
            'value' => '',
        );
        $this->Setting_model->save($setting);

        // vat section
        $setting = array(
            'id' => 9,
            'name' => 'vat',
            'value' => '7',
        );
        $this->Setting_model->save($setting);

        echo 'seeder success.';
    }
}
