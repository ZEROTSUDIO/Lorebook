<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_relationships extends CI_Migration {

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
            'source_entry_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'target_entry_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'relationship_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
            ),
            'inverse_label' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => TRUE,
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
        $this->dbforge->add_key('world_id');
        $this->dbforge->add_key('source_entry_id');
        $this->dbforge->add_key('target_entry_id');
        $this->dbforge->add_key(array('source_entry_id', 'target_entry_id', 'relationship_type'));
        $this->dbforge->create_table('entry_relationships', TRUE, array('ENGINE' => 'InnoDB'));

        $this->db->query('ALTER TABLE `entry_relationships` ADD CONSTRAINT `fk_rel_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `entry_relationships` ADD CONSTRAINT `fk_rel_source` FOREIGN KEY (`source_entry_id`) REFERENCES `entries`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `entry_relationships` ADD CONSTRAINT `fk_rel_target` FOREIGN KEY (`target_entry_id`) REFERENCES `entries`(`id`) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('entry_relationships', TRUE);
    }
}
