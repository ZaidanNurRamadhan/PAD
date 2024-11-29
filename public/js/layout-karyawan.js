document.addEventListener("DOMContentLoaded", function() {
    const appElement = document.getElementById('app');
    const routes = JSON.parse(appElement.getAttribute('data-routes'));

    // Logout event menggunakan route login dari routes
    document.getElementById('confirmLogout').addEventListener('click', function () {
        window.location.href = routes.login; // Gunakan URL dari data routes
    });

    function toggleMobileNavbar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('active');
    }

    const currentUrl = window.location.href;

    // Daftar elemen link beserta URL-nya
    const links = [
        { element: document.getElementById('gudangLink'), url: routes.gudang },
        { element: document.getElementById('transaksiLink'), url: routes.transaksi }
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

