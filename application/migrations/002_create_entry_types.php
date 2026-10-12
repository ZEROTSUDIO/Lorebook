<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_entry_types extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'world_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '120',
            ),
            'icon' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'is_system' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
            ),
            'sort_order' => array(
                'type' => 'INT',
                'default' => 0,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('world_id');
        $this->dbforge->add_key(array('world_id', 'slug'));
        $this->dbforge->create_table('entry_types', TRUE, array('ENGINE' => 'InnoDB'));

        // Add foreign key constraint
        $this->db->query('ALTER TABLE `entry_types` ADD CONSTRAINT `fk_entry_types_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('entry_types', TRUE);
    }
}
