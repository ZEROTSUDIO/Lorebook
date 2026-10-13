<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function index()
    {
        // 1. Ensure MySQL database exists before CI DB connection
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $dbname = 'lorekeeper';

        try {
            $mysqli = @new mysqli($host, $user, $pass);
            if (!$mysqli->connect_errno) {
                $mysqli->query("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $mysqli->close();
            }
        } catch (Exception $e) {
            // Log or ignore if cannot connect raw
        }

        // 2. Load database and migrations library
        $this->load->database();
        $this->load->library('migration');

        echo '<!doctype html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Lorekeeper — Schema Migrations</title>
            <style>
                body { background: #151419; color: #ECE7DD; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, monospace; padding: 40px; }
                .card { max-width: 600px; margin: 0 auto; background: #1E1D24; border: 2px solid #3D382F; padding: 28px; box-shadow: 4px 4px 0 #08070A; }
                h1 { color: #C5A869; margin-top: 0; font-size: 22px; letter-spacing: 2px; text-transform: uppercase; }
                .success { color: #85E89D; border-left: 3px solid #85E89D; padding-left: 12px; margin: 16px 0; }
                .error { color: #F97583; border-left: 3px solid #F97583; padding-left: 12px; margin: 16px 0; }
                a { color: #C5A869; text-decoration: none; border-bottom: 1px solid #C5A869; }
            </style>
        </head>
        <body>
        <div class="card">';

        echo '<h1>[CODEX // MIGRATION RUNNER]</h1>';

        if ($this->migration->current() === FALSE) {
            echo '<div class="error"><p><strong>Migration Error:</strong> ' . $this->migration->error_string() . '</p></div>';
        } else {
            echo '<div class="success"><p><strong>Success:</strong> Database <code>lorekeeper</code> has been updated to migration version ' . $this->config->item('migration_version', 'migration') . '!</p></div>';
            echo '<p>Tables present:</p><ul>
                <li><code>users</code> &amp; <code>world_members</code></li>
                <li><code>worlds</code></li>
                <li><code>entry_types</code></li>
                <li><code>entries</code></li>
                <li><code>property_definitions</code> &amp; <code>property_values</code></li>
                <li><code>entry_relationships</code></li>
                <li><code>tags</code> &amp; <code>entry_tags</code></li>
                <li><code>timeline_events</code> (with Fictional Calendar <code>sort_year</code> / <code>end_year</code>)</li>
                <li><code>media_attachments</code></li>
                <li><code>app_settings</code></li>
            </ul>';
            echo '<p><a href="' . base_url() . '">&larr; Return to Application</a></p>';
        }

        echo '</div></body></html>';
    }
}
