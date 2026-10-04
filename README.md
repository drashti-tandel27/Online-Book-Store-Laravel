# Online Book Store

Online Book Store is a web application developed using Laravel and MySQL. The project provides an online platform for users to browse books, view book details, add books to cart and wishlist, and place orders.

## Project Description

The Online Book Store allows users to explore available books and purchase them online. An admin panel is also provided to manage books, categories, users, orders, and reviews.

## Features

### User Features

* User Registration and Login
* Browse Books
* View Book Details
* Add Books to Cart
* Wishlist
* Checkout
* Place Orders
* Review Books
* Manage User Profile

### Admin Features

* Admin Login
* Admin Dashboard
* Manage Books
* Manage Categories
* Manage Users
* Manage Orders
* Manage Reviews

## Technologies Used

* Laravel
* PHP
* MySQL
* Blade
* HTML
* CSS
* JavaScript
* Tailwind CSS
* Vite

## Project Structure

* `app/` - Controllers, Models and application logic
* `bootstrap/` - Application bootstrapping files
* `config/` - Configuration files
* `database/` - Migrations, factories and seeders
* `public/` - Public files and images
* `resources/` - Blade views, CSS and JavaScript
* `routes/` - Application routes
* `storage/` - Application storage
* `tests/` - Application tests

## How to Run

### 1. Clone the Repository

```bash
git clone https://github.com/drashti-tandel27/Online-Book-Store-Laravel.git
```

### 2. Go to the Project Folder

```bash
cd Online-Book-Store-Laravel
```

### 3. Install PHP Dependencies

```bash
composer install
```

### 4. Create the Environment File

Windows:

```bash
copy .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Configure the Database

Open the `.env` file and configure your MySQL database details.

### 7. Run Database Migrations

```bash
php artisan migrate
```

### 8. Install Frontend Dependencies

```bash
npm install
```

### 9. Start the Frontend

```bash
npm run dev
```

### 10. Start the Laravel Server

Open another terminal and run:

```bash
php artisan serve
```

Open the application in your browser:

```text
http://127.0.0.1:8000
```

## Security

The `.env` file is not included in this repository because it may contain private configuration and database information. Use `.env.example` to create your local `.env` file.

## Author

**Tandel Drashti**
