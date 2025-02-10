<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add shortcode
add_shortcode('sidreport_form', 'sidreport_frontend_form');
function sidreport_frontend_form() {
    ob_start();
    ?>
    <div id="sidreport-form">
        <input type="text" id="sidreport-account" placeholder="Masukkan nomor rekening/akun">
        <button id="sidreport-search">Cari</button>
        <div id="sidreport-result"></div>
    </div>
    <script>
    jQuery(document).ready(function($) {
        $('#sidreport-search').click(function() {
            var account = $('#sidreport-account').val();
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'sidreport_search',
                    account: account
                },
                success: function(response) {
                    $('#sidreport-result').html(response);
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}