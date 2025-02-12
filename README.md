Langkah 5: Mengaktifkan Plugin
Aktifkan Plugin: Masuk ke dashboard WordPress, navigasi ke Plugins > Installed Plugins, dan aktifkan plugin SIDReport.

Gunakan Shortcode: Tambahkan shortcode [sidreport_form] ke halaman atau post di mana Anda ingin form pencarian muncul.

Langkah 6: Fitur Selanjutnya
Untuk fitur selanjutnya, Anda dapat menambahkan fungsionalitas seperti:

Formulir Pelaporan: Tambahkan formulir untuk pengunjung yang ingin melaporkan akun baru.

Edit Status Laporan: Tambahkan fungsionalitas untuk mengedit status laporan dari admin dashboard.

Paginasi dan Filter: Tambahkan paginasi dan filter untuk daftar laporan di admin dashboard.

Commands 
apt update 
apt upgrade -y
apt install curl -y
curl -fsSL https://ollama.com/install.sh | sh
ollama pull deepseek-r1:8b
ollama run deepseek-r1:8b

Deepseek: https://www.deepseek.com
Ollama: https://ollama.com
Open WebUI: https://openwebui.com

Command lines for Linux:
1. Install ollama: curl -fsSL https://ollama.com/install.sh | sh
2. Run ollama models: ollama run deepseek-r1:1.5b
3. Pull ollama models: ollama pull deepseek-r1:8b
4. Install uv: curl -LsSf https://astral.sh/uv/install.sh | sh
5. Install Open WebUI: DATA_DIR=~/.open-webui uvx --python 3.11 open-webui@latest serve
6. Open WebUI: http://localhost:8080




HALO ,buatkan plugin wordpress bernama: sidreport. Fungsi utama plugin ini adalah mengijinkan user/pengunjung untuk mengecek no rekening / account online apakah terdaftar sebagai penipuan, scam, dan lain lain. query pencarian bisa berupa huruf dan angka. 
A. tampilan frontend berupa satu buah input text untuk mencari data , lalu sebuah tombol cari, dan sebuah link untuk membuat data baru bernama Buat Laporan. JIKA data yang dicari tidak ditemukan atau belum ada, plugin menawarkan kepada user untuk membuat laporan baru. JIKA data yang dicari memiliki hasil lebih dari 1, maka akan ditampilkan berupa list/tabel berupa Account, Nama, Tanggal dilaporkan, dan tombol DETAIL yang ketika diklik maka akan muncul popup modal baru berisi detail laporan (READ ONLY). Jika hasil pencarian data hanya memiliki 1 hasil, maka akan muncul popup modal baru berisi detail laporan (READ ONLY).

B. untuk membuat laporan baru berupa shortcode sehingga memudahkan untuk ditampilkan pada wordpress. isi FORM BUAT LAPORANnya adalah 
	- input account, berupa huruf dan angka 
	- input jenis account, berupa dropdown menu dengan opsi yang telah tersimpan di database. user juga memiliki pilihan untuk menambahkan opsi baru jika belum tersedia pada database.
	- input nama, berupa huruf dan angka
	- input tanggal dilaporkan, user bisa memilih tanggal hari ini atau tanggal lainnya
	- input jenis laporan, berupa dropdown menu dengan opsi yang telah tersimpan di database. user juga memiliki pilihan untuk menambahkan opsi baru jika belum tersedia pada database.
	- input status laporan, bersifat hidden dengan default valuenya adalah: Diperiksa
	- input keterangan, berupa text area agar user dapat membuat informasi yang cukup panjang
	- input Nama Pelapor, berupa huruf dan angka
	- input Kontak Pelapor, Berupa text untuk memasukkan nomor telepon ataupun email
	- input Gambar, berupa field untuk melampirkan file berupa gambar. maksimal 5


data yang tersimpan memiliki struktur: account, jenis account, nama, tanggal dilaporkan, jenis laporan, status laporan, keterangan, nama pelapor, kontak pelapor, gambar. Bisa juga ditambahkan lainnya jika diperlukan. 

C. memiliki admin dashboard untuk melihat seluruh daftar laporan yang masuk dan ada menu edit untuk menentukan status laporan. Ketika di klik Edit, maka akan muncul jendela popup/modal untuk melakukan editing data dengan form yang telah berisi nilai sesuai database. FORMnya berupa:
	- input account, berupa huruf dan angka 
	- input jenis account, berupa dropdown menu dengan opsi yang telah tersimpan di database. admin juga memiliki pilihan untuk menambahkan opsi baru jika belum tersedia pada database.
	- input nama, berupa huruf dan angka
	- input tanggal dilaporkan, admin bisa memilih tanggal hari ini atau tanggal lainnya
	- input jenis laporan, berupa dropdown menu dengan opsi yang telah tersimpan di database. admin juga memiliki pilihan untuk menambahkan opsi baru jika belum tersedia pada database.
	- input status laporan, berupa dropdown menu dengan opsi yang telah tersimpan di database. admin juga memiliki pilihan untuk menambahkan opsi baru jika belum tersedia pada database.
	- input keterangan, berupa text area agar admin dapat membuat informasi yang cukup panjang
	- input Nama Pelapor, berupa huruf dan angka
	- input Kontak Pelapor, Berupa text untuk memasukkan nomor telepon ataupun email


Harap diperhatikan bahwa Plugin harus bersifat modular, sehingga untuk perubahan, penambahan, dan pengurangan fitur, cukup menuliskan code baru pada file baru tanpa mempengaruhi kode utama pada plugin. karena kemungkinan akan ditambahkan modul baru seperti print laporan, analytic laporan, dll.

Kode harus ditulis secara rapi dan lengkap dengan keterangan yang mudah dipahami.

