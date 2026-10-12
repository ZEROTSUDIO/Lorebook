<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_worlds extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'public_id' => array(
                'type' => 'CHAR',
                'constraint' => '36',
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '180',
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('public_id');
        $this->dbforge->add_key('slug');
        $this->dbforge->create_table('worlds', TRUE, array('ENGINE' => 'InnoDB'));
    }

    public function down()
    {
        $this->dbforge->drop_table('worlds', TRUE);
    }
}
