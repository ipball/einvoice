<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_users_table extends CI_Migration
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
            'username' => array(
                'type' => 'varchar',
                'constraint' => '50',
            ),
            'password' => array(
                'type' => 'varchar',
                'constraint' => '100',
            ),
            'name' => array(
                'type' => 'varchar',
                'constraint' => '200',
            ),
            'email' => array(
                'type' => 'varchar',
                'constraint' => '100',
            ),
            'token' => array(
                'type' => 'varchar',
                'constraint' => '100',
                'null' => true,
            ),
            'token_date' => array(
                'type' => 'datetime',                
                'null' => true,
            ),
            'status' => array(
                'type' => 'tinyint',
                'constraint' => 4,
                'comment' => '0=inactive, 1=active',
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('users');
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}
