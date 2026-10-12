<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_tags extends CI_Migration {

    public function up()
    {
        // 1. tags
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
        $this->dbforge->create_table('tags', TRUE, array('ENGINE' => 'InnoDB'));
        $this->db->query('ALTER TABLE `tags` ADD CONSTRAINT `fk_tags_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');

        // 2. entry_tags
        $this->dbforge->add_field(array(
            'entry_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'tag_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
        ));
        $this->dbforge->add_key(array('entry_id', 'tag_id'), TRUE);
        $this->dbforge->create_table('entry_tags', TRUE, array('ENGINE' => 'InnoDB'));
        $this->db->query('ALTER TABLE `entry_tags` ADD CONSTRAINT `fk_entry_tags_entry` FOREIGN KEY (`entry_id`) REFERENCES `entries`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `entry_tags` ADD CONSTRAINT `fk_entry_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('entry_tags', TRUE);
        $this->dbforge->drop_table('tags', TRUE);
    }
}
