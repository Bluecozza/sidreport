<?php
if (!defined('ABSPATH')) exit;

class SIDReport_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_action('wp_ajax_sidreport_get_report', [$this, 'get_report']);
        add_action('wp_ajax_sidreport_update_report', [$this, 'update_report']);
    }

    // Menambahkan menu ke dashboard admin
    public function add_admin_menu() {
        add_menu_page(
            'SIDReport',
            'SIDReport',
            'manage_options',
            'sidreport',
            [$this, 'render_admin_page'],
            'dashicons-warning',
            25
        );
    }

    // Menampilkan halaman admin SIDReport
    public function render_admin_page() {
        global $wpdb;
        $table = $wpdb->prefix . 'sidreport_reports';
        $reports = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");

        ?>
        <div class="wrap">
            <h1>Daftar Laporan SIDReport</h1>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Account</th>
                        <th>Nama</th>
                        <th>Jenis Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?php echo esc_html($report->id); ?></td>
                            <td><?php echo esc_html($report->account); ?></td>
                            <td><?php echo esc_html($report->nama); ?></td>
                            <td><?php echo esc_html($report->jenis_laporan); ?></td>
                            <td><?php echo esc_html($report->status_laporan); ?></td>
                            <td>
                                <button class="sidreport-edit-btn" data-id="<?php echo esc_attr($report->id); ?>">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal untuk edit laporan -->
        <div id="sidreport-edit-modal" class="sidreport-modal">
            <div class="sidreport-modal-content">
                <span class="sidreport-close">&times;</span>
                <h2>Edit Laporan</h2>
                <form id="sidreport-edit-form">
                    <input type="hidden" id="edit-id">
                    <label>Account:</label>
                    <input type="text" id="edit-account" required>
                    <label>Nama:</label>
                    <input type="text" id="edit-nama" required>
                    <label>Jenis Laporan:</label>
                    <input type="text" id="edit-jenis-laporan" required>
                    <label>Status:</label>
                    <select id="edit-status">
                        <option value="Diperiksa">Diperiksa</option>
                        <option value="Valid">Valid</option>
                        <option value="Palsu">Palsu</option>
                    </select>
                    <button type="submit">Simpan</button>
                </form>
            </div>
        </div>
        <?php
    }

    // Load script dan style untuk dashboard admin
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_sidreport') return;

        wp_enqueue_style('sidreport-admin-style', plugins_url('../assets/css/admin.css', __FILE__));
        wp_enqueue_script('sidreport-admin-script', plugins_url('../assets/js/admin.js', __FILE__), ['jquery'], null, true);

        wp_localize_script('sidreport-admin-script', 'sidreport_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    // Mengambil data laporan berdasarkan ID (untuk edit)
    public function get_report() {
        global $wpdb;
        $table = $wpdb->prefix . 'sidreport_reports';
        $id = intval($_POST['id']);

        $report = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));

        if ($report) {
            echo json_encode($report);
        } else {
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }

        wp_die();
    }

    // Mengupdate laporan
    public function update_report() {
        global $wpdb;
        $table = $wpdb->prefix . 'sidreport_reports';

        $id = intval($_POST['id']);
        $account = sanitize_text_field($_POST['account']);
        $nama = sanitize_text_field($_POST['nama']);
        $jenis_laporan = sanitize_text_field($_POST['jenis_laporan']);
        $status = sanitize_text_field($_POST['status']);

        $update = $wpdb->update(
            $table,
            [
                'account' => $account,
                'nama' => $nama,
                'jenis_laporan' => $jenis_laporan,
                'status_laporan' => $status
            ],
            ['id' => $id]
        );

        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Gagal mengupdate laporan']);
        }

        wp_die();
    }
}

new SIDReport_Admin();
