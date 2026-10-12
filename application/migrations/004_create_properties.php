<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_properties extends CI_Migration {

    public function up()
    {
        // 1. property_definitions
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'entry_type_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'field_key' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'label' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
            ),
            'field_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
            ),
            'is_required' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
            ),
            'options' => array(
                'type' => 'LONGTEXT',
                'null' => TRUE,
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
        $this->dbforge->add_key('entry_type_id');
        $this->dbforge->add_key(array('entry_type_id', 'field_key'));
        $this->dbforge->create_table('property_definitions', TRUE, array('ENGINE' => 'InnoDB'));
        $this->db->query('ALTER TABLE `property_definitions` ADD CONSTRAINT `fk_prop_def_type` FOREIGN KEY (`entry_type_id`) REFERENCES `entry_types`(`id`) ON DELETE CASCADE');

        // 2. property_values
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'entry_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'property_definition_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'value_text' => array(
                'type' => 'LONGTEXT',
                'null' => TRUE,
            ),
            'value_number' => array(
                'type' => 'DECIMAL',
                'constraint' => '15,4',
                'null' => TRUE,
            ),
            'value_boolean' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'value_date' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'referenced_entry_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
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
        $this->dbforge->add_key('entry_id');
        $this->dbforge->add_key('property_definition_id');
        $this->dbforge->add_key(array('entry_id', 'property_definition_id'));
        $this->dbforge->create_table('property_values', TRUE, array('ENGINE' => 'InnoDB'));
        $this->db->query('ALTER TABLE `property_values` ADD CONSTRAINT `fk_prop_val_entry` FOREIGN KEY (`entry_id`) REFERENCES `entries`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `property_values` ADD CONSTRAINT `fk_prop_val_def` FOREIGN KEY (`property_definition_id`) REFERENCES `property_definitions`(`id`) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('property_values', TRUE);
        $this->dbforge->drop_table('property_definitions', TRUE);
    }
}
