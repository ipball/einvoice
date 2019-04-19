<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_categories_table extends CI_Migration
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
                'constraint' => '200',                
            ),                                 
            'created_at' => array(
                'type' => 'datetime',
                'null' => true,
            ),
            'updated_at' => array(
                'type' => 'datetime',                
                'null' => true,
            ),
            'detail' => array(
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
        $this->dbforge->create_table('categories');
    }

    public function down()
    {
        $this->dbforge->drop_table('categories');
    }
}
