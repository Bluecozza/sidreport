<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'sidreport_admin_menu');
function sidreport_admin_menu() {
    add_menu_page(
        'SIDReport',
        'SIDReport',
        'manage_options',
        'sidreport',
        'sidreport_admin_page',
        'dashicons-shield',
        6
    );
}

function sidreport_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidreport';
    $reports = $wpdb->get_results("SELECT * FROM $table_name");
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Laporan SIDReport</h1>
        
        <!-- Reports Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Account</th>
                    <th>Nama</th>
                    <th>Jenis Account</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reports as $report): ?>
                <tr>
                    <td><?php echo esc_html($report->id); ?></td>
                    <td><?php echo esc_html($report->account); ?></td>
                    <td><?php echo esc_html($report->nama); ?></td>
                    <td><?php echo esc_html($report->jenis_account); ?></td>
                    <td><?php echo esc_html($report->status_laporan); ?></td>
                    <td>
                        <button class="button button-primary sidreport-edit" 
                                data-id="<?php echo esc_attr($report->id); ?>">
                            Edit
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <div id="sidreport-edit-modal" class="sidreport-modal">
            <div class="sidreport-modal-content">
                <span class="sidreport-close">&times;</span>
                <div id="sidreport-edit-form"></div>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Edit Report
        $('.sidreport-edit').click(function() {
            const reportId = $(this).data('id');
            $('#sidreport-edit-modal').fadeIn();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'sidreport_get_report',
                    id: reportId
                },
                success: function(response) {
                    if(response.success) {
                        $('#sidreport-edit-form').html(response.data.form);
                    }
                }
            });
        });

        // Close Modal
        $('.sidreport-close').click(function() {
            $('.sidreport-modal').fadeOut();
        });
    });
    </script>
    <?php
}