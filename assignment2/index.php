<?php
session_start();
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Union Shop - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Example: Greeting at top -->
<div class="greeting">
    <?php if (isset($_SESSION["user_name"])): ?>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</p>
    <?php else: ?>
        <p>Hello, Guest.</p>
    <?php endif; ?>
</div>

<header>
    <img src="resources/images/logos/logo.svg" alt="Student Union Logo">
    <h1>Welcome to the Student Union Shop</h1>

    <!-- Burger Menu for Mobile -->
    <div class="burger-menu" id="burger-menu" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Navigation Links -->
    <nav id="nav-links" class="nav-links">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart</a>

        <?php if (isset($_SESSION["user_name"])): ?>
            <!-- If the user or session does store logged in, show Logout -->
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <!-- If thr user or session does not store logged in, show Login -->
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>

<!-- Hero section -->
<div class="container">
    <h2>Welcome to the official Student Union Shop!</h2>
    <p>Explore our exclusive range of hoodies, jumpers, and t-shirts designed for students.</p>
</div>

<!-- Special Offers Section -->
<div class="offers-container">
    <h2>Current Offers</h2>
    <ul>
        <?php
        // Fetch offers from the database
        $query = $conn->query("SELECT offer_title, offer_dec FROM tbl_offers");

        while ($row = $query->fetch()) {
            echo "<li><strong>" . htmlspecialchars($row['offer_title']) . "</strong>: " . htmlspecialchars($row['offer_dec']) . "</li>";
        }
        ?>
    </ul>
</div>

<!-- iframe and mp4 container -->
<div class="video-iframe-container">
    <div class="video-container">
        <video src="resources/video/video.mp4" title="Student Union Video" controls></video>
    </div>
    <div class="iframe-container">
        <iframe src="https://www.youtube.com/embed/EI_lco-qdw8" title="Student Union Video" allowfullscreen></iframe>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="footer">
        <div class="info">
            <h3>Links</h3>
            <p><a href="">Students' Union</a></p>
        </div>
        <div class="info">
            <h3>Contact</h3>
            <p>Email: <a href="mailto:suinformation@uclan.ac.uk">suinformation@uclan.ac.uk</a></p>
            <p>Phone: 01772 89 3000</p>
        </div>
        <div class="info">
            <h3>Location</h3>
            <p>University of Central Lancashire Students' Union.<br>Fylde Road, Preston. PR1 7BY<br>Registered in England<br>Company Number: 7623917<br>Registered Charity Number: 11426616</p>
        </div>
    </div>
    <span> &copy 2024; Student Union Shop. All rights reserved.</span>
</footer>
<script src=js/script.js></script>
</body>
</html>
