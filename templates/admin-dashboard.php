<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap">
    <h1>Daftar Laporan SIDReport</h1>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>Account</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jenis Laporan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'sidreport_reports';
            $reports = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

            if ($reports) :
                foreach ($reports as $report) : ?>
                    <tr>
                        <td><?php echo esc_html($report->account); ?></td>
                        <td><?php echo esc_html($report->nama); ?></td>
                        <td><?php echo esc_html($report->tanggal_dilaporkan); ?></td>
                        <td><?php echo esc_html($report->jenis_laporan); ?></td>
                        <td><?php echo esc_html($report->status_laporan); ?></td>
                        <td>
                            <button class="edit-report" data-id="<?php echo $report->id; ?>">Edit</button>
                        </td>
                    </tr>
                <?php endforeach;
            else : ?>
                <tr><td colspan="6">Belum ada laporan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
