<p align="center">
  <img src="https://raw.githubusercontent.com/zaidannurramadhan/pad/main/public/assets/img/Logo.png" alt="KONEK Logo" width="400">
</p>

# KONEK - Stock Management Application

KONEK is a web-based stock management application built with the Laravel framework, designed to provide an intuitive and efficient solution for managing product inventory, transactions, suppliers, and store data. It offers different access levels for owners and employees, ensuring streamlined operations and clear oversight of business activities.

## Features

**For Owners:**
* **Dashboard**: Get an overview of product distribution, sales, returns, best-selling products, and critical stock levels.
* **Transaction Management**: View, add, edit, and delete sales and return transactions.
* **Warehouse Management**: Manage product inventory, including adding new products, editing existing ones, and deleting records. Keep track of product stock, purchase prices, selling prices, and critical stock thresholds.
* **Reporting**: Generate daily and monthly reports for transactions in PDF and Excel formats.
* **Supplier Management**: Maintain a list of suppliers, including their names, provided products, contact numbers, and emails.
* **Store Management**: Manage information about your stores, such as store name, owner's name, address, and phone number.
* **Employee Management**: Add, edit, and remove employee accounts with specific roles.

**For Employees:**
* **Transaction Management**: Record new sales and returns.
* **Warehouse Viewing**: View current product stock and critical levels.

## Technologies Used

* **Laravel**: The web application framework providing the backend structure and API endpoints.
* **Composer**: Dependency manager for PHP.
* **MySQL**: Database management system for storing application data.
* **Bootstrap**: Frontend framework for responsive and modern UI components.
* **JavaScript (Fetch API, jQuery)**: For dynamic content loading and interaction with API endpoints.
* **Chart.js**: For rendering interactive data visualizations on the dashboard.
* **Maatwebsite/Excel**: For exporting transaction data to Excel.
* **Mpdf/Mpdf**: For generating PDF reports.

## Installation and Setup

To get a copy of KONEK up and running on your local machine for development and testing purposes, follow these steps:

### Prerequisites

* PHP >= 8.2
* Composer
* Node.js & npm (or Yarn)
* MySQL (or another database supported by Laravel)

### Steps

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/zaidannurramadhan/pad.git](https://github.com/zaidannurramadhan/pad.git)
    cd pad
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```
    * **Note**: If `dedoc/scramble` is causing issues, you might need to run `composer update --no-dev` or manually remove it from `composer.json` for production, although it's a dev dependency.

3.  **Install JavaScript dependencies:**
    ```bash
    npm install
    # OR
    yarn install
    ```

4.  **Create and configure your `.env` file:**
    ```bash
    cp .env.example .env
    ```
    Open `.env` and configure your database connection and other environment variables.
    ```
    APP_NAME="KONEK"
    APP_ENV=local
    APP_KEY=
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=konek_db # Replace with your database name
    DB_USERNAME=root     # Replace with your database username
    DB_PASSWORD=         # Replace with your database password
    ```

5.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

6.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate
    php artisan db:seed # This will run all seeders, including initial user accounts, products, transactions, and suppliers.
    ```
    * **Note:** The `LoginSeeder.php` creates two default users:
        * **Owner:** `email: isdeaths7@gmail.com`, `password: 12345678`
        * **Employee:** `email: zaidan@gmail.com`, `password: 12345678`

7.  **Link storage (for publicly accessible files):**
    ```bash
    php artisan storage:link
    ```

8.  **Compile frontend assets:**
    ```bash
    npm run dev
    # OR
    yarn dev
    ```
    For production:
    ```bash
    npm run build
    # OR
    yarn build
    ```

9.  **Serve the application:**
    ```bash
    php artisan serve
    ```
    The application will typically be available at `http://localhost:8000`.

## API Documentation

This project uses `dedoc/scramble` for API documentation.
You can view the API documentation by navigating to `/docs/api` after running the application.

**Access Control for API Docs:**
* In a `local` environment, API documentation is always accessible.
* In `production` (VPS) environments, only logged-in users with specific email addresses (defined in `App\Providers\AuthServiceProvider.php`) can view the documentation. You should change `'admin@example.com'` to your actual admin email.

## Project Structure Highlights

* `app/Http/Controllers`: Contains the application's logic, separated into `Api` and web controllers.
    * `Api/DashboardController.php`: Handles dashboard data, including sales, returns, critical stock, and bestsellers.
    * `Api/GudangController.php`: Manages product (gudang) data via API.
    * `Api/LaporanController.php`: Provides API endpoints for reports and PDF exports.
    * `Api/MonitoringController.php`: Handles monitoring data, specifically for "open" transactions.
    * `Api/PemasokController.php`: Manages supplier (pemasok) data via API.
    * `Api/SettingController.php`: Manages employee (karyawan) user accounts via API.
    * `Api/TokoController.php`: Manages store (toko) data via API.
    * `Api/TransaksiController.php`: Manages transaction data via API for both owners and employees.
* `app/Models`: Eloquent models for database interaction (e.g., `Produk`, `Pemasok`, `Toko`, `Transaksi`, `User`).
* `database/migrations`: Defines the database schema. Key tables include `users`, `produk`, `toko`, `transaksi`, and `pemasok`.
* `database/seeders`: Populates the database with initial data (e.g., `LoginSeeder`, `ProdukSeeder`, `PemasokSeeder`, `TokoSeeder`, `TransaksiSeeder`).
* `resources/views`: Blade templates for the user interface.
    * `layout/owner.blade.php`: Main layout for owner users, including navigation and search functionality.
    * `layout/karyawan.blade.php`: Main layout for employee users.
    * `login.blade.php`: User login page.
    * `dashboard.blade.php`: Owner dashboard displaying various statistics and charts.
    * `gudang-owner.blade.php`: Warehouse management interface for owners.
    * `transaksi-owner.blade.php`: Transaction management interface for owners.
    * `laporan.blade.php`: Reporting interface for owners.
    * `pemasok.blade.php`: Supplier management interface.
    * `manajemen-toko.blade.php`: Store management interface.
    * `settings.blade.php`: Employee management interface.
* `public/css` and `public/js`: Custom CSS and JavaScript files for styling and client-side logic.
    * `public/js/script.js`: Contains common JavaScript functions for modals, search, and API interactions.
* `routes/api.php`: Defines API routes for different modules, protected by Sanctum and role-based middleware.
* `routes/web.php`: Defines web routes for page navigation and authentication.

## Important Notes

* **Authentication**: The application uses Laravel Sanctum for API token-based authentication. When logging in via the web, a token is stored in local storage for subsequent API requests.
* **Error Handling**: Custom error handling is implemented to return JSON responses for API requests.
* **Password Reset**: Functionality for "Forgot Password" and "Reset Password" is implemented, sending email tokens for verification.
* **Environment**: The application distinguishes between `local` and `production` environments, affecting features like API documentation access.

## Contributing

Contributions are welcome! Please feel free to open issues or submit pull requests.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
