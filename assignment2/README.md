
## 📂 Assignment 2: Backend Web Application (60%)
**📅 Deadline:** 1st April 2025  
**📌 Technologies Used:** PHP, MySQL, HTML, CSS, JavaScript  

**🌐 URL:** https://vesta.uclan.ac.uk/~fcobiwundu/assignment2 
**👤Test User Credentials:** 
- Email = testuser@gmail.com 
- Password = Testuser&12345

**1 Description:**
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
<?php if (isset($_SESSION["user_name"])): ?>
    <h2>Welcome back, <?php echo htmlspecialchars($_SESSION["user_name"]); ?> to the 
        official Student Union Shop!</h2>
<?php else: ?>
    <h2>Welcome to the official Student Union Shop!</h2>
<?php endif; ?>
// Logout button only shown when user is logged in:

<?php if (isset($_SESSION["user_id"])): ?>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
<?php endif; ?>
```

**📚 Resources Used:**
1. SQL LIKE operator – https://www.w3schools.com/sql/sql_like.asp
I used the LIKE operator to implement filtering logic for products based on their type (e.g., Hoodie, Jumper, Tshirt).
It allowed write dynamic WHERE clauses that match product types partially using % wildcards.

2. PHP implode function – https://www.w3schools.com/PHP/func_string_implode.asp
The implode() function was used to convert arrays into readable strings

3. PHP MySQL prepared statements – https://www.w3schools.com/php/php_mysql_prepared_statements.asp
I used prepared statements throughout the project to securely interact with the database and prevent SQL injection binding parameters with bindParam()

4. PHP intval() – https://www.w3schools.com/php/func_var_intval.asp
The intval() function was used to sanitize incoming GET and POST data, ensuring that IDs and other numerical values were cast properly.

5. SQL ORDER BY ASC – https://www.w3schools.com/sql/sql_ref_asc.asp
ORDER BY ASC in review and product queries to ensure the display was organized oldest  alphabetically.