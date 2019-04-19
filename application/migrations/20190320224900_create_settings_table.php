<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_settings_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,      
            ),
            'name' => array(
                'type' => 'varchar',
                'constraint' => '100',
                'comment' => 'ชื่อ',
            ),
            'value' => array(
                'type' => 'longtext',
                'comment' => 'ค่าข้อมูล'                               
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('settings');
    }

    public function down()
    {
        $this->dbforge->drop_table('settings');
    }
}
