<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users_and_members extends CI_Migration {

    public function up()
    {
        // 1. Create `users` table
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
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
            ),
            'password_hash' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'display_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'avatar' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'user',
            ),
            'is_active' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 1,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('public_id', FALSE);
        $this->dbforge->add_key('username', FALSE);
        $this->dbforge->add_key('email', FALSE);
        $this->dbforge->create_table('users', TRUE, array('ENGINE' => 'InnoDB'));

        // 2. Create `world_members` table
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
            'user_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
            ),
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'editor', // 'owner', 'editor', 'viewer'
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('world_id');
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key(array('world_id', 'user_id'));
        $this->dbforge->create_table('world_members', TRUE, array('ENGINE' => 'InnoDB'));

        // Foreign keys for world_members
        $this->db->query('ALTER TABLE `world_members` ADD CONSTRAINT `fk_wm_world` FOREIGN KEY (`world_id`) REFERENCES `worlds`(`id`) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE `world_members` ADD CONSTRAINT `fk_wm_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE');

        // 3. Alter `worlds` table: add owner_id and visibility
        $world_fields = array(
            'owner_id' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'null' => TRUE,
                'after' => 'public_id'
            ),
            'visibility' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'private', // 'private', 'unlisted', 'public'
                'after' => 'slug'
            ),
        );
        $this->dbforge->add_column('worlds', $world_fields);
        $this->db->query('ALTER TABLE `worlds` ADD CONSTRAINT `fk_worlds_owner` FOREIGN KEY (`owner_id`) REFERENCES `users`(`id`) ON DELETE SET NULL');

        // 4. Alter `entries` table: add created_by and updated_by audit columns
        $entry_fields = array(
            'created_by' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'null' => TRUE,
                'after' => 'is_archived'
            ),
            'updated_by' => array(
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'null' => TRUE,
                'after' => 'created_by'
            ),
        );
        $this->dbforge->add_column('entries', $entry_fields);
        $this->db->query('ALTER TABLE `entries` ADD CONSTRAINT `fk_entries_created_by` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL');
        $this->db->query('ALTER TABLE `entries` ADD CONSTRAINT `fk_entries_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL');
    }

    public function down()
    {
        // 1. Revert entries audit fields
        $this->db->query('ALTER TABLE `entries` DROP FOREIGN KEY `fk_entries_created_by`');
        $this->db->query('ALTER TABLE `entries` DROP FOREIGN KEY `fk_entries_updated_by`');
        $this->dbforge->drop_column('entries', 'created_by');
        $this->dbforge->drop_column('entries', 'updated_by');

        // 2. Revert worlds owner/visibility fields
        $this->db->query('ALTER TABLE `worlds` DROP FOREIGN KEY `fk_worlds_owner`');
        $this->dbforge->drop_column('worlds', 'owner_id');
        $this->dbforge->drop_column('worlds', 'visibility');

        // 3. Drop tables
        $this->dbforge->drop_table('world_members', TRUE);
        $this->dbforge->drop_table('users', TRUE);
    }
}
