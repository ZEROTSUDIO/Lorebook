<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_timeline extends CI_Migration {

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
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
            ),
            'era' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'event_date' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'sort_order' => array(
                'type' => 'BIGINT',
                'default' => 0,
            ),
            'summary' => array(
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
        $this->dbforge->add_key('entry_id');
        $this->dbforge->add_key(array('world_id', 'sort_order'));
        $this->dbforge->create_table('timeline_events', TRUE, array('ENGINE' => 'InnoDB'));

        $this->db->query('ALTER TABLE `timeline_events` ADD CONSTRAINT `fk_timeline_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `timeline_events` ADD CONSTRAINT `fk_timeline_entry` FOREIGN KEY (`entry_id`) REFERENCES `entries`(`id`) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->dbforge->drop_table('timeline_events', TRUE);
    }
}
