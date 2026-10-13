<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Align_chatgpt_and_calendar extends CI_Migration {

    public function up()
    {
        // 1. Upgrade `timeline_events` for the 3-Layer Fictional Calendar
        $timeline_fields = array(
            'sort_year' => array(
                'type' => 'INT',
                'null' => TRUE,
                'after' => 'event_date'
            ),
            'end_year' => array(
                'type' => 'INT',
                'null' => TRUE,
                'after' => 'sort_year'
            ),
            'is_approximate' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
                'after' => 'end_year'
            ),
        );
        $this->dbforge->add_column('timeline_events', $timeline_fields);
        $this->db->query('ALTER TABLE `timeline_events` ADD INDEX `idx_timeline_chronology` (`world_id`, `sort_year`, `sort_order`)');

        // 2. Align `entries` with ChatGPT Media & Soft-Delete Spec
        $entry_fields = array(
            'cover_media_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'null' => TRUE,
                'after' => 'cover_image'
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
                'after' => 'updated_at'
            ),
        );
        $this->dbforge->add_column('entries', $entry_fields);
        $this->db->query('ALTER TABLE `entries` ADD CONSTRAINT `fk_entries_cover_media` FOREIGN KEY (`cover_media_id`) REFERENCES `media_attachments`(`id`) ON DELETE SET NULL');

        // 3. Enforce True SQL UNIQUE & Foreign Key Constraints (ChatGPT Section 4)
        $this->db->query('ALTER TABLE `worlds` ADD UNIQUE INDEX `uq_worlds_public_id` (`public_id`)');
        $this->db->query('ALTER TABLE `worlds` ADD UNIQUE INDEX `uq_worlds_slug` (`slug`)');
        $this->db->query('ALTER TABLE `entry_types` ADD UNIQUE INDEX `uq_entry_types_world_slug` (`world_id`, `slug`)');
        $this->db->query('ALTER TABLE `entries` ADD UNIQUE INDEX `uq_entries_public_id` (`public_id`)');
        $this->db->query('ALTER TABLE `entries` ADD UNIQUE INDEX `uq_entries_world_slug` (`world_id`, `slug`)');
        $this->db->query('ALTER TABLE `property_definitions` ADD UNIQUE INDEX `uq_prop_def_type_key` (`entry_type_id`, `field_key`)');
        $this->db->query('ALTER TABLE `property_values` ADD UNIQUE INDEX `uq_prop_val_entry_def` (`entry_id`, `property_definition_id`)');
        $this->db->query('ALTER TABLE `property_values` ADD CONSTRAINT `fk_prop_val_ref_entry` FOREIGN KEY (`referenced_entry_id`) REFERENCES `entries`(`id`) ON DELETE SET NULL');
        $this->db->query('ALTER TABLE `tags` ADD UNIQUE INDEX `uq_tags_world_slug` (`world_id`, `slug`)');

        // 4. Create `app_settings` table for global & world-scoped preferences (e.g. default calendar era)
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'world_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'setting_key' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'setting_value' => array(
                'type' => 'LONGTEXT',
                'null' => TRUE,
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('world_id');
        $this->dbforge->create_table('app_settings', TRUE, array('ENGINE' => 'InnoDB'));

        $this->db->query('ALTER TABLE `app_settings` ADD UNIQUE INDEX `uq_app_settings_world_key` (`world_id`, `setting_key`)');
        $this->db->query('ALTER TABLE `app_settings` ADD CONSTRAINT `fk_app_settings_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');
    }

    public function down()
    {
        // 1. Drop `app_settings`
        $this->dbforge->drop_table('app_settings', TRUE);

        // 2. Drop UNIQUE and FK constraints
        $this->db->query('ALTER TABLE `tags` DROP INDEX `uq_tags_world_slug`');
        $this->db->query('ALTER TABLE `property_values` DROP FOREIGN KEY `fk_prop_val_ref_entry`');
        $this->db->query('ALTER TABLE `property_values` DROP INDEX `uq_prop_val_entry_def`');
        $this->db->query('ALTER TABLE `property_definitions` DROP INDEX `uq_prop_def_type_key`');
        $this->db->query('ALTER TABLE `entries` DROP INDEX `uq_entries_world_slug`');
        $this->db->query('ALTER TABLE `entries` DROP INDEX `uq_entries_public_id`');
        $this->db->query('ALTER TABLE `entry_types` DROP INDEX `uq_entry_types_world_slug`');
        $this->db->query('ALTER TABLE `worlds` DROP INDEX `uq_worlds_slug`');
        $this->db->query('ALTER TABLE `worlds` DROP INDEX `uq_worlds_public_id`');

        // 3. Revert `entries` columns
        $this->db->query('ALTER TABLE `entries` DROP FOREIGN KEY `fk_entries_cover_media`');
        $this->dbforge->drop_column('entries', 'deleted_at');
        $this->dbforge->drop_column('entries', 'cover_media_id');

        // 4. Revert `timeline_events` columns
        $this->db->query('ALTER TABLE `timeline_events` DROP INDEX `idx_timeline_chronology`');
        $this->dbforge->drop_column('timeline_events', 'is_approximate');
        $this->dbforge->drop_column('timeline_events', 'end_year');
        $this->dbforge->drop_column('timeline_events', 'sort_year');
    }
}
