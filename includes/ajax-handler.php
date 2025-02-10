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
        echo '<p>Tidak ditemukan hasil. ';
        echo '<a href="#" class="sidreport-open-modal">Laporkan akun ini</a></p>';
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

// AJAX handler for submitting report
add_action('wp_ajax_sidreport_submit_report', 'sidreport_submit_report_handler');
add_action('wp_ajax_nopriv_sidreport_submit_report', 'sidreport_submit_report_handler');
function sidreport_submit_report_handler() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidreport';

    // Validasi data yang dikirim
    if (empty($_POST['account']) || empty($_POST['nama']) || empty($_FILES['gambar'])) {
        wp_send_json_error('Data tidak lengkap.', 400);
    }

    // Sanitize dan validasi input
    $account = sanitize_text_field($_POST['account']);
    $nama = sanitize_text_field($_POST['nama']);
    $jenis_account = sanitize_text_field($_POST['jenis_account']);
    $tanggal_dilaporkan = sanitize_text_field($_POST['tanggal_dilaporkan']);
    $jenis_laporan = sanitize_text_field($_POST['jenis_laporan']);
    $status_laporan = sanitize_text_field($_POST['status_laporan']);
    $keterangan = sanitize_textarea_field($_POST['keterangan']);
    $nama_pelapor = sanitize_text_field($_POST['nama_pelapor']);
    $kontak_pelapor = sanitize_text_field($_POST['kontak_pelapor']);

    // Handle "other" options
    if ($jenis_account === 'other') {
        $jenis_account = sanitize_text_field($_POST['jenis_account_other']);
    }
    if ($jenis_laporan === 'other') {
        $jenis_laporan = sanitize_text_field($_POST['jenis_laporan_other']);
    }

    // Handle file upload
    $uploaded_files = [];
    if (!empty($_FILES['gambar'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        foreach ($_FILES['gambar']['tmp_name'] as $key => $tmp_name) {
            $file = [
                'name'     => $_FILES['gambar']['name'][$key],
                'type'     => $_FILES['gambar']['type'][$key],
                'tmp_name' => $tmp_name,
                'error'    => $_FILES['gambar']['error'][$key],
                'size'     => $_FILES['gambar']['size'][$key]
            ];

            $upload_result = wp_handle_upload($file, ['test_form' => false]);
            if (isset($upload_result['file'])) {
                $uploaded_files[] = $upload_result['url'];
            }
        }
    }

    // Simpan data ke database
    $wpdb->insert(
        $table_name,
        [
            'account' => $account,
            'nama' => $nama,
            'jenis_account' => $jenis_account,
            'tanggal_dilaporkan' => $tanggal_dilaporkan,
            'jenis_laporan' => $jenis_laporan,
            'status_laporan' => $status_laporan,
            'keterangan' => $keterangan,
            'nama_pelapor' => $nama_pelapor,
            'kontak_pelapor' => $kontak_pelapor,
            'gambar' => maybe_serialize($uploaded_files) // Simpan URL gambar sebagai serialized array
        ]
    );

    wp_send_json_success('Laporan berhasil dikirim.');
}

add_action('wp_ajax_sidreport_get_report', 'sidreport_get_report_handler');
function sidreport_get_report_handler() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidreport';
    $reportId = intval($_POST['id']);

    $report = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $reportId));

    if ($report) {
        wp_send_json_success($report);
    } else {
        wp_send_json_error('Laporan tidak ditemukan.');
    }
}

add_action('wp_ajax_sidreport_update_report', 'sidreport_update_report_handler');
function sidreport_update_report_handler() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidreport';

    $data = [
        'account' => sanitize_text_field($_POST['account']),
        'nama' => sanitize_text_field($_POST['nama']),
        'jenis_account' => sanitize_text_field($_POST['jenis_account']),
        'tanggal_dilaporkan' => sanitize_text_field($_POST['tanggal_dilaporkan']),
        'jenis_laporan' => sanitize_text_field($_POST['jenis_laporan']),
        'status_laporan' => sanitize_text_field($_POST['status_laporan']),
        'keterangan' => sanitize_textarea_field($_POST['keterangan']),
        'nama_pelapor' => sanitize_text_field($_POST['nama_pelapor']),
        'kontak_pelapor' => sanitize_text_field($_POST['kontak_pelapor'])
    ];

    $where = ['id' => intval($_POST['id'])];

    $result = $wpdb->update($table_name, $data, $where);

    if ($result !== false) {
        wp_send_json_success('Data berhasil diperbarui.');
    } else {
        wp_send_json_error('Gagal memperbarui data.');
    }
}

