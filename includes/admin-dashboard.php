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
    echo '<thead><tr><th>ID</th><th>Account</th><th>Nama</th><th>Jenis Account</th><th>Tanggal Dilaporkan</th><th>Jenis Laporan</th><th>Status Laporan</th><th>Keterangan</th><th>Nama Pelapor</th><th>Kontak Pelapor</th><th>Gambar</th><th>Aksi</th></tr></thead>';
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
        echo '<td>' . esc_html($report->gambar) . '</td>';
        echo '<td><a href="#" class="sidreport-edit" data-id="' . esc_attr($report->id) . '">Edit</a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    // Modal Edit
    echo '
    <div id="sidreport-edit-modal" style="display:none;">
        <div class="sidreport-modal-content">
            <span class="sidreport-close-modal">&times;</span>
            <h2>Edit Laporan</h2>
            <form id="sidreport-edit-form">
                <input type="hidden" id="edit-id" name="id">
                <label for="edit-account">Account:</label>
                <input type="text" id="edit-account" name="account" required><br>
                <label for="edit-nama">Nama:</label>
                <input type="text" id="edit-nama" name="nama" required><br>
                <label for="edit-jenis_account">Jenis Account:</label>
                <select id="edit-jenis_account" name="jenis_account" required>
                    <option value="BCA">BCA</option>
                    <option value="BNI">BNI</option>
                    <option value="BRI">BRI</option>
                    <option value="MANDIRI">MANDIRI</option>
                    <option value="DANA">DANA</option>
                    <option value="OVO">OVO</option>
                    <option value="GOPAY">GOPAY</option>
                    <option value="other">Lainnya</option>
                </select>
                <input type="text" id="edit-jenis_account_other" name="jenis_account_other" style="display:none;" placeholder="Masukkan jenis account"><br>
                <label for="edit-tanggal_dilaporkan">Tanggal Dilaporkan:</label>
                <input type="date" id="edit-tanggal_dilaporkan" name="tanggal_dilaporkan" required><br>
                <label for="edit-jenis_laporan">Jenis Laporan:</label>
                <select id="edit-jenis_laporan" name="jenis_laporan" required>
                    <option value="Penipuan">Penipuan</option>
                    <option value="Produk Palsu">Produk Palsu</option>
                    <option value="Spam">Spam</option>
                    <option value="Hoax">Hoax</option>
                    <option value="other">Lainnya</option>
                </select>
                <input type="text" id="edit-jenis_laporan_other" name="jenis_laporan_other" style="display:none;" placeholder="Masukkan jenis laporan"><br>
                <label for="edit-status_laporan">Status Laporan:</label>
                <select id="edit-status_laporan" name="status_laporan" required>
                    <option value="Diperiksa">Diperiksa</option>
                    <option value="Valid">Valid</option>
                    <option value="Tidak Valid">Tidak Valid</option>
                </select><br>
                <label for="edit-keterangan">Keterangan:</label>
                <textarea id="edit-keterangan" name="keterangan" required></textarea><br>
                <label for="edit-nama_pelapor">Nama Pelapor:</label>
                <input type="text" id="edit-nama_pelapor" name="nama_pelapor" required><br>
                <label for="edit-kontak_pelapor">Kontak Pelapor:</label>
                <input type="text" id="edit-kontak_pelapor" name="kontak_pelapor" required><br>
                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>';
}

