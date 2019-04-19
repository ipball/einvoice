<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_contacts_table extends CI_Migration
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
            'code' => array(
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ),
            'tax_no' => array(
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ),
            'profile_picture' => array(
                'type' => 'varchar',
                'constraint' => '100',
                'null' => true,
            ),
            'name' => array(
                'type' => 'varchar',
                'constraint' => '200',
            ),            
            'contact_name' => array(
                'type' => 'varchar',
                'constraint' => '200',
                'null' => true,
            ),
            'email' => array(
                'type' => 'varchar',
                'constraint' => '100',
                'null' => true,
            ),
            'tel' => array(
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ),
            'fax' => array(
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ),
            'website' => array(
                'type' => 'varchar',
                'constraint' => '100',
                'null' => true,
            ),
            'created_at' => array(
                'type' => 'datetime',
                'null' => true,
            ),
            'updated_at' => array(
                'type' => 'datetime',                
                'null' => true,
            ),
            'address' => array(
                'type' => 'text',
                'null' => true,
            ),
            'credit_day' => array(
                'type' => 'int',
                'constraint' => 11,
                'comment' => 'เครดิต(วัน)',
            ),
            'type' => array(
                'type' => 'int',
                'constraint' => 11,
                'comment' => '1=ลูกค้า, 2=ผู้จัดจำหน่าย',
            ),
            'branch_no' => array(
                'type' => 'varchar',
                'constraint' => 50,
                'comment' => 'รหัสสาขา',
                'null' => true,
            ),
            'branch_name' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'comment' => 'ชื่อรหัส',
                'null' => true,
            ),
            'note' => array(
                'type' => 'text',
                'null' => true,
            ),
            'status' => array(
                'type' => 'tinyint',
                'constraint' => 4,                
                'comment' => '0=inactive, 1=active',
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('contacts');
    }

    public function down()
    {
        $this->dbforge->drop_table('contacts');
    }
}
