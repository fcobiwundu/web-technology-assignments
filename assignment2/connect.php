<?php
$host = "localhost"; // Sometimes "127.0.0.1" or "vesta.uclan.ac.uk" if required
$dbname = "your_database_name"; // Replace with your actual database name
$username = "your_database_username"; // Replace with your MySQL username
$password = "your_database_password"; // Replace with your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database Connection Successful!";
} catch (PDOException $e) {
    echo "❌ Database Connection Failed: " . $e->getMessage();
}
?>
