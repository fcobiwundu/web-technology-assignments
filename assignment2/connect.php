<?php
$host = "localhost"; 
$dbname = " fcobiwundu";
$username = "fcobiwundu";
$password = "gbsCeUepSS";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database Connection Successful!";
} catch (PDOException $e) {
    echo "Database Connection Failed: " . $e->getMessage();
}
?>
