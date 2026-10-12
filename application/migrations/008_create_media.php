<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_media extends CI_Migration {

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
            'entry_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'original_filename' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'stored_filename' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'file_path' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'mime_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'file_size' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'caption' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('world_id');
        $this->dbforge->add_key('entry_id');
        $this->dbforge->create_table('media_attachments', TRUE, array('ENGINE' => 'InnoDB'));

        $this->db->query('ALTER TABLE `media_attachments` ADD CONSTRAINT `fk_media_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `media_attachments` ADD CONSTRAINT `fk_media_entry` FOREIGN KEY (`entry_id`) REFERENCES `entries`(`id`) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->dbforge->drop_table('media_attachments', TRUE);
    }
}
