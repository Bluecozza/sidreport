<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// AJAX handler for search
add_action('wp_ajax_sidreport_search', 'sidreport_search_handler');
add_action('wp_ajax_nopriv_sidreport_search', 'sidreport_search_handler');
function sidreport_search_handler() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidreport';
    $account = sanitize_text_field($_POST['account']);

    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE account = %s",
        $account
    ));

    if (empty($results)) {
        echo '<p>No results found. <a href="#">Report this account</a></p>';
    } else {
        echo '<ul>';
        foreach ($results as $result) {
            echo '<li>';
            echo 'Account: ' . esc_html($result->account) . '<br>';
            echo 'Nama: ' . esc_html($result->nama) . '<br>';
            echo 'Jenis Account: ' . esc_html($result->jenis_account) . '<br>';
            echo 'Tanggal Dilaporkan: ' . esc_html($result->tanggal_dilaporkan) . '<br>';
            echo 'Jenis Laporan: ' . esc_html($result->jenis_laporan) . '<br>';
            echo 'Status Laporan: ' . esc_html($result->status_laporan) . '<br>';
            echo 'Keterangan: ' . esc_html($result->keterangan) . '<br>';
            echo 'Nama Pelapor: ' . esc_html($result->nama_pelapor) . '<br>';
            echo 'Kontak Pelapor: ' . esc_html($result->kontak_pelapor) . '<br>';
            echo '</li>';
        }
        echo '</ul>';
    }
    wp_die();
}