<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_documents_table extends CI_Migration
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
            'doc_no' => array(
                'type' => 'varchar',
                'constraint' => '100',
            ),
            'ref_doc' => array(
                'type' => 'varchar',
                'constraint' => '100',
                'null' => true,
            ),
            'doc_date' => array(
                'type' => 'date',                
                'null' => true,
            ),
            'due_date' => array(
                'type' => 'date',
                'null' => true,
            ),
            'payment_type' => array(
                'type' => 'int',
                'constraint' => 11,
                'comment' => '1=เงินสด, 2=เงินเชื่อ, 3=เงินโอน ,4=เช็ค ,5=บัตรเครดิต',
            ),
            'credit_day' => array(
                'type' => 'int',
                'constraint' => 11,
                'comment' => 'เครดิต(วัน)',
            ),
            'contact_name' => array(
                'type' => 'text',
                'null' => true,
            ),
            'contact_address' => array(
                'type' => 'text',
                'null' => true,
            ),
            'contact_email' => array(
                'type' => 'varchar',
                'constraint' => '100',
                'null' => true,
            ),
            'contact_tel' => array(
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ),
            'contact_fax' => array(
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ),
            'contact_tax_no' => array(
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ),
            'contact_branch_name' => array(
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
            'created_by' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'updated_by' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'remark' => array(
                'type' => 'text',
                'null' => true,
            ),
            'vat_type' => array(
                'type' => 'int',
                'constraint' => 11,
                'comment' => '1=exclude, 2=include, 3=novat',
            ),
            'vat' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'discount' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'total' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'grand_total' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'pay_total' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'balance' => array(
                'type' => 'decimal',
                'constraint' => '10, 2',                
            ),
            'type' => array(
                'type' => 'int',
                'constraint' => 11,
                'comment' => '1=ใบแจ้งหนี้(invoice)',
            ),
            'status' => array(
                'type' => 'int',
                'constraint' => 11,                
                'comment' => '1=รอดำเนินการ, 2=รอเก็บเงิน, 3=เก็บเงินแล้ว',
            ),
            'contact_id' => array(
                'type' => 'int',
                'constraint' => 11,                
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('documents');
    }

    public function down()
    {
        $this->dbforge->drop_table('documents');
    }
}
