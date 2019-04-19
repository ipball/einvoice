<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_products_table extends CI_Migration
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
            'sku' => array(
                'type' => 'varchar',
                'constraint' => '100',
            ),
            'barcode' => array(
                'type' => 'varchar',
                'constraint' => '100',
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
            'unit' => array(
                'type' => 'varchar',
                'constraint' => '200',
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
            'detail' => array(
                'type' => 'text',
                'null' => true,
            ),
            'buy_price' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'sell_price' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'type' => array(
                'type' => 'int',
                'constraint' => 11,
                'comment' => '1=สินค้านับสต๊อก, 2=สินค้าไม่นับสต๊อก, 3=สินค้าบริการ',
            ),
            'quantity' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',
            ),
            'status' => array(
                'type' => 'tinyint',
                'constraint' => 4,                
                'comment' => '0=inactive, 1=active',
            ),
            'categorie_id' => array(
                'type' => 'int',
                'constraint' => 11,                
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('products');
    }

    public function down()
    {
        $this->dbforge->drop_table('products');
    }
}
