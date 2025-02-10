<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu
add_action('admin_menu', 'sidreport_admin_menu');
function sidreport_admin_menu() {
    add_menu_page(
        'SIDReport',
        'SIDReport',
        'manage_options',
        'sidreport',
        'sidreport_admin_page',
        'dashicons-warning',
        6
    );
}

// Admin page content
function sidreport_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidreport';
    $reports = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap">';
    echo '<h1>SIDReport - Daftar Laporan</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Account</th><th>Nama</th><th>Jenis Account</th><th>Tanggal Dilaporkan</th><th>Jenis Laporan</th><th>Status Laporan</th><th>Keterangan</th><th>Nama Pelapor</th><th>Kontak Pelapor</th><th>Aksi</th></tr></thead>';
    echo '<tbody>';
    foreach ($reports as $report) {
        echo '<tr>';
        echo '<td>' . esc_html($report->id) . '</td>';
        echo '<td>' . esc_html($report->account) . '</td>';
        echo '<td>' . esc_html($report->nama) . '</td>';
        echo '<td>' . esc_html($report->jenis_account) . '</td>';
        echo '<td>' . esc_html($report->tanggal_dilaporkan) . '</td>';
        echo '<td>' . esc_html($report->jenis_laporan) . '</td>';
        echo '<td>' . esc_html($report->status_laporan) . '</td>';
        echo '<td>' . esc_html($report->keterangan) . '</td>';
        echo '<td>' . esc_html($report->nama_pelapor) . '</td>';
        echo '<td>' . esc_html($report->kontak_pelapor) . '</td>';
        echo '<td><a href="' . admin_url('admin.php?page=sidreport&action=edit&id=' . $report->id) . '">Edit</a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}