<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_document_details_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'line_no' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'product_name' => array(
                'type' => 'varchar',
                'constraint' => '200',
                'null' => true,
            ),
            'quantity' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'price' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'cost_price' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'total' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'unit' => array(
                'type' => 'varchar',
                'constraint' => '200',
                'null' => true,
            ),
            'product_id' => array(
                'type' => 'int',
                'constraint' => 11,
                'null' => true,
            ),
            'document_id' => array(
                'type' => 'int',
                'constraint' => 11,                
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('document_id', true);
        $this->dbforge->create_table('document_details');
    }

    public function down()
    {
        $this->dbforge->drop_table('document_details');
    }
}
