document.addEventListener("DOMContentLoaded", function() {
    const currentUrl = window.location.href;

    // Daftar elemen link beserta URL-nya
    const links = [

        { element: document.getElementById('gudangLink'), url: "{{ route('gudang-karyawan') }}" },
        { element: document.getElementById('transaksiLink'), url: "{{ route('transaksi-karyawan') }}" }
    ];

    // Menetapkan kelas 'active' ke link yang sesuai dengan URL saat ini
    links.forEach(link => {
        if (currentUrl.includes(link.url)) {
            link.element.classList.add('active');
        } else {
            link.element.classList.remove('active');
        }
    });
});
document.getElementById('confirmLogout').addEventListener('click', function () {
    window.location.href = "{{ route('login') }}"; // Mengarahkan ke halaman login
});
