<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_shortcode('sidreport_form', 'sidreport_frontend_form');
function sidreport_frontend_form() {
    ob_start();
    ?>
    <div id="sidreport-form">
        <input type="text" id="sidreport-account" placeholder="Masukkan nomor rekening/akun">
        <button id="sidreport-search">Cari</button>
        <div id="sidreport-result"></div>
        <button id="sidreport-open-modal-main">Buat Laporan Baru</button>
    </div>

    <!-- Modal for Report Form -->
    <div id="sidreport-modal" style="display:none;">
        <div class="sidreport-modal-content">
            <span class="sidreport-close-modal">&times;</span> <!-- Tombol close -->
            <h2>Buat Laporan Baru</h2>
            <form id="sidreport-report-form" enctype="multipart/form-data">
                <label for="account">Account:</label>
                <input type="text" id="account" name="account" required><br>

                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required><br>

                <label for="jenis_account">Jenis Account:</label>
                <select id="jenis_account" name="jenis_account" required>
                    <option value="BCA">BCA</option>
                    <option value="BNI">BNI</option>
                    <option value="BRI">BRI</option>
                    <option value="MANDIRI">MANDIRI</option>
                    <option value="DANA">DANA</option>
                    <option value="OVO">OVO</option>
                    <option value="GOPAY">GOPAY</option>
                    <option value="other">Lainnya</option>
                </select>
                <input type="text" id="jenis_account_other" name="jenis_account_other" style="display:none;" placeholder="Masukkan jenis account"><br>

                <label for="tanggal_dilaporkan">Tanggal Dilaporkan:</label>
                <input type="date" id="tanggal_dilaporkan" name="tanggal_dilaporkan" value="<?php echo date('Y-m-d'); ?>" required><br>

                <label for="jenis_laporan">Jenis Laporan:</label>
                <select id="jenis_laporan" name="jenis_laporan" required>
                    <option value="Penipuan">Penipuan</option>
                    <option value="Produk Palsu">Produk Palsu</option>
                    <option value="Spam">Spam</option>
                    <option value="Hoax">Hoax</option>
                    <option value="other">Lainnya</option>
                </select>
                <input type="text" id="jenis_laporan_other" name="jenis_laporan_other" style="display:none;" placeholder="Masukkan jenis laporan"><br>

                <input type="hidden" id="status_laporan" name="status_laporan" value="Diperiksa">

                <label for="keterangan">Keterangan:</label>
                <textarea id="keterangan" name="keterangan" required></textarea><br>

                <label for="gambar">Lampirkan Gambar (Maksimal 3):</label>
                <input type="file" id="gambar" name="gambar[]" multiple accept="image/*" required><br>

                <label for="nama_pelapor">Nama Pelapor:</label>
                <input type="text" id="nama_pelapor" name="nama_pelapor" required><br>

                <label for="kontak_pelapor">Kontak Pelapor:</label>
                <input type="text" id="kontak_pelapor" name="kontak_pelapor" required><br>

                <button type="submit">Kirim Laporan</button>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="sidreport-success-modal" style="display:none;">
        <div class="sidreport-modal-content">
            <span class="sidreport-close-modal">&times;</span> <!-- Tombol close -->
            <h2>Terima Kasih</h2>
            <p>Terima kasih sudah mengirimkan laporan, data Anda akan segera kami proses.</p>
            <button id="sidreport-close-success-btn">Tutup</button>
        </div>
    </div>

 <script>
    jQuery(document).ready(function($) {
        // Fungsi Pencarian
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
                    
                    // Event delegation untuk link laporan baru
                    $(document).on('click', '.sidreport-open-modal', function(e) {
                        e.preventDefault();
                        $('#sidreport-modal').fadeIn();
                    });
                }
            });
        });

    // Buka modal dari tombol utama
    $('#sidreport-open-modal-main').click(function() {
        $('#sidreport-modal').fadeIn();
    });

    // Tutup modal dengan tombol close (class selector)
    $(document).on('click', '.sidreport-close-modal', function() {
        $('#sidreport-modal, #sidreport-success-modal').fadeOut();
    });

    // Tutup modal success dengan tombol "Tutup"
    $('#sidreport-close-success-btn').click(function() {
        $('#sidreport-success-modal').fadeOut();
    });

    // Tutup modal saat mengklik di luar modal
    $(window).click(function(e) {
        if ($(e.target).is('#sidreport-modal, #sidreport-success-modal')) {
            $('#sidreport-modal, #sidreport-success-modal').fadeOut();
        }
    });

        // Handle "Other" option for Jenis Account
        $('#jenis_account').change(function() {
            if ($(this).val() === 'other') {
                $('#jenis_account_other').show();
            } else {
                $('#jenis_account_other').hide();
            }
        });

        // Handle "Other" option for Jenis Laporan
        $('#jenis_laporan').change(function() {
            if ($(this).val() === 'other') {
                $('#jenis_laporan_other').show();
            } else {
                $('#jenis_laporan_other').hide();
            }
        });

        // Submit Report Form via AJAX
$('#sidreport-report-form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    // Tambahkan action ke FormData
    formData.append('action', 'sidreport_submit_report');

    $.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: formData,
        processData: false, // Penting: jangan proses data
        contentType: false, // Penting: jangan set content type
        success: function(response) {
            $('#sidreport-modal').fadeOut();
            $('#sidreport-success-modal').fadeIn();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim laporan.');
        }
    });
});


    });
    </script>
    <?php
    return ob_get_clean();
}