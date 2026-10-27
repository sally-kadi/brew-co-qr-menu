# Brew Co. — Digital Coffee Menu

A database-driven digital menu and administration dashboard built for a coffee shop. The project allows customers to explore menu items while administrators manage categories, products, prices, images, and availability.

## Project Overview

Coffee shops need a convenient way to display their menus and keep product information up to date. Brew Co. provides a digital menu connected to a MySQL database, together with an admin dashboard for managing menu content without manually editing the website for every change.

## Features

### Customer Menu
- Display menu items organized by categories.
- Show product names, descriptions, prices, and images.
- Retrieve menu content dynamically from the database.

### Admin Dashboard
- View dashboard statistics.
- Add, edit, and delete menu items.
- Create and manage menu categories.
- Activate and deactivate menu items.
- Manage product information through PHP forms.

### Database
- MySQL database integration.
- Separate tables for categories, menu items, and admin users.
- Category relationships for organizing menu products.

## Technologies Used

- **Backend:** PHP
- **Database:** MySQL, phpMyAdmin
- **Frontend:** HTML5, CSS3
- **Local Development:** XAMPP, Apache
- **Database Operations:** SQL, CRUD

## My Contribution

I developed the customer-facing digital menu and the administrative functionality. My work included connecting PHP pages to MySQL, implementing CRUD operations, displaying menu items by category, handling product images, and troubleshooting database relationship and image-path issues.

## Project Structure

```text
QR-Menu/
├── admin/
│   ├── index.php
│   ├── categories.php
│   └── menu-items.php
├── images/
├── index.php
└── brew_co_db.sql
```

*Note: The structure above highlights the main project components. Additional PHP files and assets may be present in the repository.*

## Installation and Setup

### Prerequisites
- A local PHP development environment using XAMPP.
- Apache and MySQL services.
- phpMyAdmin.

### Steps

1. Clone or download this repository.
2. Copy the project folder into your XAMPP `htdocs` directory.
3. Start Apache and MySQL from the XAMPP Control Panel.
4. Open phpMyAdmin in your browser.
5. Create a database named `brew_co_db`.
6. Import the `brew_co_db.sql` file into the database.
7. Open the customer menu:

   `http://localhost/QR-Menu/QR-Menu/index.php`

8. Open the admin dashboard:

   `http://localhost/QR-Menu/QR-Menu/admin/index.php`

> The local URLs above assume your project folder is located at `htdocs/QR-Menu/QR-Menu`. Adjust the paths if your folder structure is different.

## Screenshots

Screenshots of the customer menu and admin dashboard can be added here to demonstrate the user interface and key functionality.

<!-- Add screenshots from the repository's images folder when available. -->

## What I Learned

- Connecting PHP applications to a MySQL database.
- Implementing create, read, update, and delete operations.
- Organizing menu data using related database tables.
- Handling uploaded images and file paths.
- Troubleshooting database constraints and SQL errors.
- Building administrative interfaces for managing dynamic content.

## Developer

**Sally Kadi**

Junior PHP Full-Stack Developer

- [GitHub Profile](https://github.com/sally-kadi)
- [LinkedIn Profile](https://www.linkedin.com/in/sally-kadi/)

---

This project was developed as part of my web development experience at Violet Programming.
