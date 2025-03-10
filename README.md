# Web Technology Assignments

## 📌 Overview
This repository contains two web technology assignments developed for the **Student Union Shop at UCLan**. The assignments focus on **front-end** and **back-end** web development, implementing modern design principles, interactivity, and database management.

---

## 📂 Assignment 1: Frontend Web Application (40%)
**📅 Deadline:** 17th December 2024  
**📌 Technologies Used:** HTML, CSS, JavaScript  

**🌐 Description:**
- A fully responsive **front-end web application** for an online shop.
- Implements **interactive product displays** and a **shopping cart**.
- Uses **localStorage** to manage cart functionality.
- Pages included:
  - `index.html` → Homepage with a welcome message and embedded video.
  - `products.html` → Displays all available products.
  - `item.html` → Shows detailed information about a selected product.
  - `cart.html` → Displays the shopping cart (no checkout required).
- **No frameworks** (like Bootstrap) are used.

📌 **Features:**
✔️ Navigation menu for seamless browsing.  
✔️ Valid HTML & CSS following best practices.  
✔️ Session-based product selection (via JavaScript).  
✔️ Shopping cart with add/remove functionality.  
✔️ Mobile-friendly with CSS media queries.  
✔️ README file with detailed documentation.  
✔️ Video demo showcasing project functionality.  

---

## 📂 Assignment 2: Backend Web Application (60%)
**📅 Deadline:** 1st April 2025  
**📌 Technologies Used:** PHP, MySQL, HTML, CSS, JavaScript  
**🌐 Description:**
- Extends **Assignment 1** by integrating a **server-side backend** using PHP and MySQL.
- Enables **user authentication** and **database-driven content**.
- Implements a **login system** and a **product management system**.
- Uses PHP **sessions** for user authentication.

📌 **Features:**
✔️ MySQL database for storing users, products, and orders.  
✔️ User login system with secure password hashing (bcrypt).  
✔️ Dynamic product pages pulling data from the database.  
✔️ Shopping cart linked to **database sessions**.  
✔️ Secure user authentication and session management.  
✔️ Filtering and searching for products using SQL queries.  
✔️ Hosted on **Vesta server (vesta.uclan.ac.uk)**.  

---

## 🔧 Changes to Schema

1. Created connect.php 
**Added `connect.php` for Database Connection** 
 - Purpose: Centralized database connection using PDO for security and reusability.
 - Implementation: Created connect.php to handle database connectivity.
 - Uses prepared statements for security.
**Example snippet:**
```php
    <?php
    // Database configuration
    $host = "localhost"; 
    $dbname = "your_database_name";
    $username = "your_database_username";
    $password = "your_database_password";

    try {
        // Connect to MySQL using PDO
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username,  $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database Connection Failed: " . $e->getMessage());
    }
    ?>
```

2. Created index.php as the Homepage
 - Purpose: Displays a dynamic homepage with:
 - Greeting message based on session state.
 - Special offers fetched from tbl_offers in the database.
 - Navigation bar with Login/Logout visibility based on authentication.
**Key Additions:**
 - Session-based personalized greeting:
**Snippet:**
```php
<?php
session_start();
if (isset($_SESSION["user_name"])) {
    echo "Welcome back, " . htmlspecialchars($_SESSION["user_name"]) . "!";
} else {
    echo "Hello, Guest. <a href='login.php'>Login</a>";
}
?>
// Logout button only shown when user is logged in:

<?php if (isset($_SESSION["user_id"])): ?>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
<?php endif; ?>
```
