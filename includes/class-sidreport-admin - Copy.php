<?php
if (!defined('ABSPATH')) {
    exit;
}

class SIDReport_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_action('wp_ajax_sidreport_get_report', [$this, 'get_report']);
        add_action('wp_ajax_sidreport_update_report', [$this, 'update_report']);
    }

    // Tambah menu di dashboard admin
    public function add_admin_menu() {
        add_menu_page(
            'SIDReport - Laporan',
            'SIDReport',
            'manage_options',
            'sidreport',
            [$this, 'admin_dashboard'],
            'dashicons-warning',
            20
        );
    }

    // Load CSS & JS untuk admin
    public function enqueue_admin_scripts() {
        wp_enqueue_style('sidreport-admin-style', SIDREPORT_URL . 'assets/css/admin.css');
        wp_enqueue_script('sidreport-admin-script', SIDREPORT_URL . 'assets/js/admin.js', ['jquery'], null, true);
        wp_localize_script('sidreport-admin-script', 'sidreport_ajax', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    // Tampilan utama dashboard admin
    public function admin_dashboard() {
        global $wpdb;
        $table = $wpdb->prefix . 'sidreport_reports';
        $reports = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
        
        ?>
        <div class="wrap">
            <h1>Daftar Laporan</h1>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Nama</th>
                        <th>Tanggal Dilaporkan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <td><?php echo esc_html($report->account); ?></td>
                            <td><?php echo esc_html($report->nama); ?></td>
                            <td><?php echo esc_html($report->tanggal_dilaporkan); ?></td>
                            <td><?php echo esc_html($report->status_laporan); ?></td>
                            <td>
                                <button class="sidreport-edit-btn" data-id="<?php echo $report->id; ?>">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="sidreport-edit-modal" class="sidreport-modal">
            <div class="sidreport-modal-content">
                <span class="sidreport-close">&times;</span>
                <h2>Edit Laporan</h2>
                <form id="sidreport-edit-form">
                    <input type="hidden" name="id" id="edit_id">
                    <label>Status Laporan:</label>
                    <select name="status_laporan" id="edit_status_laporan">
                        <option value="Diperiksa">Diperiksa</option>
                        <option value="Valid">Valid</option>
                        <option value="Tidak Valid">Tidak Valid</option>
                    </select>
                    <button type="submit">Simpan</button>
                </form>
                <div id="sidreport-edit-response"></div>
            </div>
        </div>
        <?php
    }

    // Ambil data laporan berdasarkan ID
    public function get_report() {
        global $wpdb;
        $table = $wpdb->prefix . 'sidreport_reports';
        $id = intval($_POST['id']);
        $report = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
        echo json_encode($report);
        wp_die();
    }

    // Update status laporan
    public function update_report() {
        global $wpdb;
        $table = $wpdb->prefix . 'sidreport_reports';
        $id = intval($_POST['id']);
        $status = sanitize_text_field($_POST['status_laporan']);

        $wpdb->update(
            $table,
            ['status_laporan' => $status],
            ['id' => $id]
        );

        echo 'Laporan berhasil diperbarui.';
        wp_die();
    }
}
