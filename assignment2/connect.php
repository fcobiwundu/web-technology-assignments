<?php
$host = "localhost"; 
$dbname = "fcobiwundu";
$username = "fcobiwundu";
$password = "gbsCeUepSS";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
}
?>
