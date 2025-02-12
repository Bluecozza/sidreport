jQuery(document).ready(function($) {
    console.log("sidreport-frontend.js loaded");
	loadDropdownOptions();	
	   // Handle form submit
		$('#sidreport-form').submit(function(e) {
        e.preventDefault(); // Mencegah reload halaman
        console.log("Form submitted");

        let formData = new FormData(this);
        formData.append('action', 'sidreport_submit_report');

        console.log("Jenis Account:", formData.get('jenis_account'));
        console.log("Jenis Laporan:", formData.get('jenis_laporan'));

        $('.sidreport-loading').show(); // Tampilkan animasi loading

        $.ajax({
            url: sidreport_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("AJAX Response:", response);
                let data = JSON.parse(response);
                if (data.success) {
                    $('#sidreport-response').html('<p>Laporan berhasil dikirim!</p>').css('color', 'green');
                    $('#sidreport-form')[0].reset(); // Reset form
                } else {
                    $('#sidreport-response').html('<p>Gagal mengirim laporan.</p>').css('color', 'red');
                }
                $('.sidreport-loading').hide(); // Sembunyikan loading
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $('#sidreport-response').html('<p>Terjadi kesalahan. Coba lagi.</p>').css('color', 'red');
                $('.sidreport-loading').hide(); // Sembunyikan loading
            }
        });
    });

    // Menggunakan event delegation agar bisa menangkap event dari elemen yang dimuat dinamis
    $(document).on('click', '.sidreport-detail-btn', function() {
        let reportId = $(this).data('id');
        console.log("Tombol detail diklik, ID:", reportId);

        $('#sidreport-modal').html('<p>Loading...</p>').show();

        $.ajax({
            url: sidreport_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'sidreport_get_report_detail',
                id: reportId
            },
            success: function(response) {
                console.log("AJAX response:", response);
                let data = JSON.parse(response);
                if (data.success) {
                    $('#sidreport-modal').html(`
                        <div class="sidreport-modal-content">
                            <span class="sidreport-close">&times;</span>
                            <h2>Detail Laporan</h2>
                            <p><strong>Account:</strong> ${data.report.account}</p>
                            <p><strong>Nama:</strong> ${data.report.nama}</p>
                            <p><strong>Jenis Laporan:</strong> ${data.report.jenis_laporan}</p>
                            <p><strong>Status:</strong> ${data.report.status_laporan}</p>
                            <p><strong>Keterangan:</strong> ${data.report.keterangan}</p>
                            <p><strong>Tanggal Dilaporkan:</strong> ${data.report.tanggal_dilaporkan}</p>
                            <button class="sidreport-close-btn">Tutup</button>
                        </div>
                    `);
                } else {
                    $('#sidreport-modal').html('<p>Data tidak ditemukan.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $('#sidreport-modal').html('<p>Terjadi kesalahan. Coba lagi.</p>');
            }
        });
    });

    $(document).on('click', '.sidreport-close-btn, .sidreport-close', function() {
        $('#sidreport-modal').hide();
    });
	

    // Load opsi dropdown dari database
    function loadDropdownOptions() {
        $.ajax({
            url: sidreport_ajax.ajax_url,
            type: "POST",
            data: { action: "sidreport_get_dropdowns" },
            success: function(response) {
                console.log("Dropdown data:", response);
                let data = JSON.parse(response);

                let jenisAccountSelect = $("#jenis_account");
                let jenisLaporanSelect = $("#jenis_laporan");

                jenisAccountSelect.html('<option value="">Pilih Jenis Account</option>');
                jenisLaporanSelect.html('<option value="">Pilih Jenis Laporan</option>');

                data.jenis_account.forEach(function(item) {
                    jenisAccountSelect.append(`<option value="${item}">${item}</option>`);
                });

                data.jenis_laporan.forEach(function(item) {
                    jenisLaporanSelect.append(`<option value="${item}">${item}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    // Panggil fungsi saat halaman dimuat///////////////
    //loadDropdownOptions();	
	
$(document).on("blur", "#jenis_account_baru", function() {
    let newOption = $(this).val().trim();
    if (newOption !== "") {
        $("#jenis_account").append(`<option value="${newOption}" selected>${newOption}</option>`);
    }
});

$(document).on("blur", "#jenis_laporan_baru", function() {
    let newOption = $(this).val().trim();
    if (newOption !== "") {
        $("#jenis_laporan").append(`<option value="${newOption}" selected>${newOption}</option>`);
    }
});
	
});

