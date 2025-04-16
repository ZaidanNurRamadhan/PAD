function toggleDropdown(element) {
    const dropdownOptions = element.nextElementSibling;
    dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
}

function selectOption(element, value) {
    const dropdown = element.closest('.dropdown');
    const selectedText = dropdown.querySelector('.selected-text');
    selectedText.textContent = value;

    // Tutup dropdown setelah memilih
    const dropdownOptions = dropdown.querySelector('.dropdown-options');
    dropdownOptions.style.display = 'none';

    // Lakukan AJAX request ke server untuk mendapatkan data berdasarkan periode
    fetch(`/data/${value}`)
        .then(response => response.json())
        .then(data => {
            // Render data ke dalam tabel
            renderTable(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

    //bagian pemasok
    function editPemasok(id) {
        // Ambil data pemasok dari server
        fetch(`/pemasok/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                // Isi form di modal dengan data pemasok
                document.getElementById('pemasok-name').value = data.name;
                document.getElementById('pemasok-produk').value = data.produkDisediakan;
                document.getElementById('pemasok-kontak').value = data.nomorTelepon;
                document.getElementById('pemasok-email').value = data.email;

                // Ubah action form sesuai dengan ID pemasok
                document.getElementById('edit-form').action = `/pemasok/${id}`;
                // Tampilkan modal
                new bootstrap.Modal(document.getElementById('Editpemasok')).show();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function editTransaksi(id) {
        // Ambil data transaksi dengan AJAX
        fetch(`/transaksi/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                let transactionDate = new Date(data.transactionDate).toISOString().split('T')[0];
                // Isi data ke dalam form
                document.getElementById('toko_id').value = data.toko_id;
                document.getElementById('produk_id').value = data.produk_id;
                document.getElementById('transactionDate').value = transactionDate;
                document.getElementById('jumlahDibeli').value = data.jumlahDibeli;
                document.getElementById('harga').value = data.harga;
                document.getElementById('terjual').value = data.terjual;
                document.getElementById('tanggal_retur').value = data.returDate || '';
                document.getElementById('editTransaksiForm').action = `/transaksi/${data.id}`;

                // Tampilkan modal
                console.log(data)
                new bootstrap.Modal(document.getElementById('Edittransaksi')).show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data transaksi!');
            });
        }


    // bagian gudang
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const hbeli = this.dataset.hbeli;
            const hjual = this.dataset.hjual;
            const jstok = this.dataset.jstok;
            const astok = this.dataset.astok;

            document.querySelector('#editForm').action = `/gudang/update/${id}`;
            document.querySelector('#editName').value = name;
            document.querySelector('#editHargaBeli').value = hbeli;
            document.querySelector('#editHargaJual').value = hjual;
            document.querySelector('#editJumlahStok').value = jstok;
            document.querySelector('#editAmbangKritis').value = astok;
        });
    });

    // Hapus Produk
    const deleteProduk = document.querySelectorAll('.deleteProduk');
    deleteProduk.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.querySelector('#deleteProdukForm').action = `/gudang/destroy/${id}`;
        });
    });
    const deletePemasok = document.querySelectorAll('.deletePemasok');
    deletePemasok.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.querySelector('#deletePemasokForm').action = `/pemasok/destroy/${id}`;
        });
    });
    const deleteToko = document.querySelectorAll('.deleteToko');
    deleteToko.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.querySelector('#deleteTokoForm').action = `/toko/destroy/${id}`;
        });
    });
    const deleteKaryawan = document.querySelectorAll('.deleteKaryawan');
    deleteKaryawan.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.querySelector('#deleteKaryawanForm').action = `/karyawan/destroy/${id}`;
        });
    });
