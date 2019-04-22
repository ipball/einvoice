<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_runs_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'varchar',
                'constraint' => 20,
            ),
            'val' => array(
                'type' => 'int',
                'constraint' => 11,
            )            
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('runs');
    }

    public function down()
    {
        $this->dbforge->drop_table('runs');
    }
}
