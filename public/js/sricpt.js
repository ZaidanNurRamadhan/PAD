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

// Fungsi untuk menampilkan data ke dalam tabel
function renderTable(data) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';

    data.forEach(item => {
        const row = `<tr>
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.created_at}</td>
                     </tr>`;
        tableBody.innerHTML += row;
    });
}
