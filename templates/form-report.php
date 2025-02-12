<?php if (!defined('ABSPATH')) exit; ?>
<?php
global $wpdb;

// Ambil data jenis account dari database
$jenis_accounts = $wpdb->get_results("SELECT nama FROM {$wpdb->prefix}sidreport_jenis_account");

// Ambil data jenis laporan dari database
$jenis_laporans = $wpdb->get_results("SELECT nama FROM {$wpdb->prefix}sidreport_jenis_laporan");
?>

<form id="sidreport-form" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('sidreport_submit_report', 'sidreport_nonce'); ?>

    <label for="account">Account:</label>
    <input type="text" id="account" name="account" required>

<label for="jenis_account">Jenis Account:</label>
<select id="jenis_account" name="jenis_account">
    <option value="">Pilih Jenis Account</option>
    <?php foreach ($jenis_accounts as $item): ?>
        <option value="<?php echo esc_attr($item->nama); ?>"><?php echo esc_html($item->nama); ?></option>
    <?php endforeach; ?>
</select>
<input type="text" id="jenis_account_baru" name="jenis_account_baru" placeholder="Tambah jenis baru (opsional)">

    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" required>

    <label for="tanggal_dilaporkan">Tanggal Dilaporkan:</label>
    <input type="date" id="tanggal_dilaporkan" name="tanggal_dilaporkan" required>


<label for="jenis_laporan">Jenis Laporan:</label>
<select id="jenis_laporan" name="jenis_laporan">
    <option value="">Pilih Jenis Laporan</option>
    <?php foreach ($jenis_laporans as $item): ?>
        <option value="<?php echo esc_attr($item->nama); ?>"><?php echo esc_html($item->nama); ?></option>
    <?php endforeach; ?>
</select>
<input type="text" id="jenis_laporan_baru" name="jenis_laporan_baru" placeholder="Tambah jenis baru (opsional)">

    <label for="keterangan">Keterangan:</label>
    <textarea id="keterangan" name="keterangan" required></textarea>

    <label for="nama_pelapor">Nama Pelapor:</label>
    <input type="text" id="nama_pelapor" name="nama_pelapor" required>

    <label for="kontak_pelapor">Kontak Pelapor:</label>
    <input type="text" id="kontak_pelapor" name="kontak_pelapor" required>

    <label for="gambar">Upload Gambar (Maks 5):</label>
    <input type="file" id="gambar" name="gambar[]" multiple>

    <button type="submit">Kirim Laporan</button>
    <div class="sidreport-loading" style="display: none;">
        <img src="<?php echo SIDREPORT_PLUGIN_URL . 'assets/images/loading.gif'; ?>" alt="Loading">
    </div>
</form>

<div id="sidreport-response"></div>
