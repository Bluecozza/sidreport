<?php
/*
Plugin Name: SIDReport
Description: Plugin untuk mengecek nomor rekening/akun online apakah terdaftar sebagai penipuan, scam, dan lain lain.
Version: 0.1.0
Author: Nur Muhammad Daim @satui.ID
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin-dashboard.php';
require_once plugin_dir_path(__FILE__) . 'includes/frontend-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handler.php';

// Activation hook
register_activation_hook(__FILE__, 'sidreport_create_table');
function sidreport_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidreport';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        account varchar(255) NOT NULL,
        nama varchar(255) NOT NULL,
        jenis_account varchar(255) NOT NULL,
        tanggal_dilaporkan date NOT NULL,
        jenis_laporan varchar(255) NOT NULL,
        status_laporan varchar(255) NOT NULL,
        keterangan text NOT NULL,
        nama_pelapor varchar(255) NOT NULL,
        kontak_pelapor varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}