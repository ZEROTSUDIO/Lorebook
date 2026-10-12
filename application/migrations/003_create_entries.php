<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_entries extends CI_Migration {

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
            'world_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'entry_type_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '220',
            ),
            'summary' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'content_markdown' => array(
                'type' => 'LONGTEXT',
                'null' => TRUE,
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'draft',
            ),
            'is_archived' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
            ),
            'cover_image' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
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
        $this->dbforge->add_key('world_id');
        $this->dbforge->add_key(array('world_id', 'slug'));
        $this->dbforge->add_key(array('world_id', 'entry_type_id'));
        $this->dbforge->add_key(array('world_id', 'status'));
        $this->dbforge->create_table('entries', TRUE, array('ENGINE' => 'InnoDB'));

        // Add foreign key constraints
        $this->db->query('ALTER TABLE `entries` ADD CONSTRAINT `fk_entries_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `entries` ADD CONSTRAINT `fk_entries_type` FOREIGN KEY (`entry_type_id`) REFERENCES `entry_types`(`id`) ON DELETE RESTRICT');
    }

    public function down()
    {
        $this->dbforge->drop_table('entries', TRUE);
    }
}
