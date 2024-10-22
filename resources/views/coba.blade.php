<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Dropdown</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="dropdown">
        <div class="dropdown-selected" onclick="toggleDropdown(this)">
            <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
            <span class="selected-text">Harian</span>
            <span class="arrow">▼</span>
        </div>
        <div class="dropdown-options">
            <div class="dropdown-option" onclick="selectOption(this,'Harian')">Harian</div>
            <div class="dropdown-option" onclick="selectOption(this,'Bulanan')">Bulanan</div>
            <div class="dropdown-option" onclick="selectOption(this,'Tahunan')">Tahunan</div>
        </div>
    </div>

    <div class="dropdown">
        <div class="dropdown-selected" onclick="toggleDropdown(this)">
            <img src="{{ asset('assets/img/kalender.png') }}" alt="Calendar Icon" class="icon">
            <span class="selected-text">Harian</span>
            <span class="arrow">▼</span>
        </div>
        <div class="dropdown-options">
            <div class="dropdown-option" onclick="selectOption(this,'Harian')">Harian</div>
            <div class="dropdown-option" onclick="selectOption(this,'Bulanan')">Bulanan</div>
            <div class="dropdown-option" onclick="selectOption(this,'Tahunan')">Tahunan</div>
        </div>
    </div>
<script src="{{ asset('js/sricpt.js') }}"></script>
</body>
</html>
