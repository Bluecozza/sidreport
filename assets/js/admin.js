jQuery(document).ready(function ($) {
    $('.sidreport-edit-btn').on('click', function () {
        let reportId = $(this).data('id');

        $.ajax({
            url: sidreport_ajax.ajax_url,
            type: 'POST',
            data: { action: 'sidreport_get_report', id: reportId },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.error) {
                    alert(data.error);
                    return;
                }

                $('#edit-id').val(data.id);
                $('#edit-account').val(data.account);
                $('#edit-nama').val(data.nama);
                $('#edit-jenis-laporan').val(data.jenis_laporan);
                $('#edit-status').val(data.status_laporan);

                $('#sidreport-edit-modal').fadeIn();
            }
        });
    });

    $('.sidreport-close').on('click', function () {
        $('#sidreport-edit-modal').fadeOut();
    });

    $('#sidreport-edit-form').on('submit', function (e) {
        e.preventDefault();

        let formData = {
            action: 'sidreport_update_report',
            id: $('#edit-id').val(),
            account: $('#edit-account').val(),
            nama: $('#edit-nama').val(),
            jenis_laporan: $('#edit-jenis-laporan').val(),
            status: $('#edit-status').val()
        };

        $.ajax({
            url: sidreport_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);
                if (data.success) {
                    alert('Laporan berhasil diperbarui!');
                    location.reload();
                } else {
                    alert('Gagal memperbarui laporan.');
                }
            }
        });
    });
});
