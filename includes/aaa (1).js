jQuery(document).ready(function($) {
    // Buka modal edit saat tombol "Edit" diklik
    $(document).on('click', '.sidreport-edit', function(e) {
        e.preventDefault();
        var reportId = $(this).data('id');

        // Ambil data dari server
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'sidreport_get_report',
                id: reportId
            },
            success: function(response) {
                if (response.success) {
                    var report = response.data;

                    // Isi form dengan data yang diterima
                    $('#edit-id').val(report.id);
                    $('#edit-account').val(report.account);
                    $('#edit-nama').val(report.nama);
                    $('#edit-jenis_account').val(report.jenis_account);
                    $('#edit-tanggal_dilaporkan').val(report.tanggal_dilaporkan);
                    $('#edit-jenis_laporan').val(report.jenis_laporan);
                    $('#edit-status_laporan').val(report.status_laporan);
                    $('#edit-keterangan').val(report.keterangan);
                    $('#edit-nama_pelapor').val(report.nama_pelapor);
                    $('#edit-kontak_pelapor').val(report.kontak_pelapor);

                    // Tampilkan modal
                    $('#sidreport-edit-modal').fadeIn();
                } else {
                    alert('Gagal mengambil data laporan.');
                }
            }
        });
    });

    // Tutup modal edit
    $(document).on('click', '.sidreport-close-modal', function() {
        $('#sidreport-edit-modal').fadeOut();
    });

    // Submit form edit
    $('#sidreport-edit-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData + '&action=sidreport_update_report',
            success: function(response) {
                if (response.success) {
                    alert('Data berhasil diperbarui.');
                    location.reload(); // Reload halaman untuk memperbarui tabel
                } else {
                    alert('Gagal memperbarui data.');
                }
            }
        });
    });
});