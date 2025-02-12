<?php
if (!defined('ABSPATH')) {
    exit;
}

class SIDReport_AJAX {
    public function __construct() {
        add_action('wp_ajax_sidreport_search', [$this, 'search_reports']);
        add_action('wp_ajax_nopriv_sidreport_search', [$this, 'search_reports']);
        add_action('wp_ajax_sidreport_submit_report', [$this, 'submit_report']);
        add_action('wp_ajax_nopriv_sidreport_submit_report', [$this, 'submit_report']);
add_action('wp_ajax_sidreport_get_report_detail', [$this, 'get_report_detail']);
add_action('wp_ajax_nopriv_sidreport_get_report_detail', [$this, 'get_report_detail']);
// Tambahkan AJAX action.. untuk dropdown
add_action('wp_ajax_sidreport_get_dropdowns', [$this, 'get_dropdown_options']);
add_action('wp_ajax_nopriv_sidreport_get_dropdowns', [$this, 'get_dropdown_options']);

    }

    public function search_reports() {
        global $wpdb;
        $table = $wpdb->prefix . 'sidreport_reports';
        $query = sanitize_text_field($_POST['query']);

        $results = $wpdb->get_results("SELECT * FROM $table WHERE account LIKE '%$query%'");

        include SIDREPORT_PLUGIN_DIR . 'templates/search-results.php';
        wp_die();
    }
	
public function get_report_detail() {
    global $wpdb;
    $table = $wpdb->prefix . 'sidreport_reports';
    $id = intval($_POST['id']);

    $report = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));

    if ($report) {
        echo json_encode([
            'success' => true,
            'report' => $report
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Laporan tidak ditemukan']);
    }

    wp_die();
}

public function submit_report() {
    global $wpdb;
    $table = $wpdb->prefix . 'sidreport_reports';

    $jenis_account = !empty($_POST['jenis_account_baru']) ? sanitize_text_field($_POST['jenis_account_baru']) : sanitize_text_field($_POST['jenis_account']);
    $jenis_laporan = !empty($_POST['jenis_laporan_baru']) ? sanitize_text_field($_POST['jenis_laporan_baru']) : sanitize_text_field($_POST['jenis_laporan']);

    $data = [
        'account' => sanitize_text_field($_POST['account']),
        'jenis_account' => $jenis_account,
        'nama' => sanitize_text_field($_POST['nama']),
        'tanggal_dilaporkan' => sanitize_text_field($_POST['tanggal_dilaporkan']),
        'jenis_laporan' => $jenis_laporan,
        'status_laporan' => 'Diperiksa',
        'keterangan' => sanitize_textarea_field($_POST['keterangan']),
        'nama_pelapor' => sanitize_text_field($_POST['nama_pelapor']),
        'kontak_pelapor' => sanitize_text_field($_POST['kontak_pelapor']),
        'gambar' => '',
    ];

    $insert = $wpdb->insert($table, $data);
    echo json_encode(['success' => (bool) $insert]);
    wp_die();
}

public function get_dropdown_options() {
    global $wpdb;
    $table = $wpdb->prefix . 'sidreport_reports';

    // Ambil opsi unik dari database
    $jenis_account = $wpdb->get_col("SELECT DISTINCT jenis_account FROM $table WHERE jenis_account IS NOT NULL AND jenis_account != '' ORDER BY jenis_account ASC");
    $jenis_laporan = $wpdb->get_col("SELECT DISTINCT jenis_laporan FROM $table WHERE jenis_laporan IS NOT NULL AND jenis_laporan != '' ORDER BY jenis_laporan ASC");

    // Kirim sebagai JSON
    echo json_encode([
        'jenis_account' => $jenis_account,
        'jenis_laporan' => $jenis_laporan
    ]);
    wp_die();
}




}

new SIDReport_AJAX();


