<?php
if (!defined('ABSPATH')) exit;

class SIDReport_DB {
    public static function install() {
        global $wpdb;
        $table_reports = $wpdb->prefix . 'sidreport_reports';
        $table_options = $wpdb->prefix . 'sidreport_options';
        $charset_collate = $wpdb->get_charset_collate();

        $sql1 = "CREATE TABLE IF NOT EXISTS $table_reports (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            account VARCHAR(255) NOT NULL,
            jenis_account VARCHAR(255) NOT NULL,
            nama VARCHAR(255) NOT NULL,
            tanggal_dilaporkan DATE NOT NULL,
            jenis_laporan VARCHAR(255) NOT NULL,
            status_laporan VARCHAR(50) DEFAULT 'Diperiksa',
            keterangan TEXT NOT NULL,
            nama_pelapor VARCHAR(255) NOT NULL,
            kontak_pelapor VARCHAR(255) NOT NULL,
            gambar TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate;";

        $sql2 = "CREATE TABLE IF NOT EXISTS $table_options (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50) NOT NULL,
            value VARCHAR(255) NOT NULL
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql1);
        dbDelta($sql2);
    }
}


