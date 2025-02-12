<?php if (!defined('ABSPATH')) exit; ?>

<?php if ($results) : ?>
    <table>
        <tr>
            <th>Account</th>
            <th>Nama</th>
            <th>Tanggal Dilaporkan</th>
            <th>Detail</th>
        </tr>
        <?php foreach ($results as $row) : ?>
            <tr>
                <td><?php echo esc_html($row->account); ?></td>
                <td><?php echo esc_html($row->nama); ?></td>
                <td><?php echo esc_html($row->tanggal_dilaporkan); ?></td>
                <td><button class="sidreport-detail-btn" data-id="<?php echo $row->id; ?>">Detail</button></td>
            </tr>
        <?php endforeach; ?>
    </table>
	<div id="sidreport-modal" style="display: none;">
    <div id="sidreport-modal-content">
        <p>Memuat data...</p>
    </div>
</div>

<?php else : ?>
    <p>Data tidak ditemukan. <a href="<?php echo site_url('/buat-laporan'); ?>">Buat Laporan?</a></p>
<?php endif; ?>

