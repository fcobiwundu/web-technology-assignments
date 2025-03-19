<?php
session_start();
include 'connect.php';

// Reead filter/search from GET
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM tbl_products";
$whereClauses = [];


if ($filter === 'hoodie') {
    $whereClauses[] = "product_type LIKE '%Hoodie%'";
} elseif ($filter === 'jumper') {
    $whereClauses[] = "product_type LIKE '%Jumper%'";
} elseif ($filter === 'tshirt') {
    $whereClauses[] = "product_type LIKE '%Tshirt%'";
}

//  Search logic
if (!empty($search)) {
    $whereClauses[] = "(product_title LIKE :search OR product_desc LIKE :search)";
}

//  Combine any WHERE clauses
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

//  Order by product_id
$sql .= " ORDER BY product_id ASC";

$stmt = $conn->prepare($sql);

// Bind the search param if used
if (!empty($search)) {
    $searchTerm = '%' . $search . '%';
    $stmt->bindParam(':search', $searchTerm);
}
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Union Shop - Products</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo-title">
            <img src="resources/images/logos/logo.svg" alt="Student Union Logo" />
            <h1>Student Union Shop</h1>
        </div>

        <nav class="nav-links" id="nav-links">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
            <?php if (isset($_SESSION["user_name"])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="register.php">Sign Up</a>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>

        <div class="burger-menu" id="burger-menu" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>

<main>
    <h2 style="text-align: center;">Our Collection</h2>

    <!-- Filter + Search Container -->
    <div style="text-align: center; margin: 1rem 0;">
        <a href="products.php?filter=all"    class="filter-btn">All</a>
        <a href="products.php?filter=tshirt" class="filter-btn">T-Shirts</a>
        <a href="products.php?filter=jumper" class="filter-btn">Jumpers</a>
        <a href="products.php?filter=hoodie" class="filter-btn">Hoodies</a>

        <form method="GET" action="products.php" style="margin-top: 1rem;">
            <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
            <input type="text" name="search" placeholder="Search product..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="products-container">
    <?php

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='product-card'>";

        // Image
        echo "<img src='" . htmlspecialchars($row['product_image']) . "' alt='" 
             . htmlspecialchars($row['product_title']) . "'>";

        // Title
        echo "<h3>" . htmlspecialchars($row['product_title']) . "</h3>";

        // Description
        echo "<p>" . htmlspecialchars($row['product_desc']) . "</p>";

        // Price
        echo "<p>Price: £" . htmlspecialchars($row['product_price']) . "</p>";

        // Type
        echo "<p>Type: " . htmlspecialchars($row['product_type']) . "</p>";

        // Buttons
        echo "<div class='product-buttons'>";
        echo "<a href='item.php?id=" . urlencode($row['product_id']) . "' class='btn'>View Item</a>";
        echo "<a href='cart.php?action=add&id=" . urlencode($row['product_id']) . "' class='btn'>Add to Cart</a>";
        echo "<a href='cart.php' class='btn'>View Cart</a>";
        echo "</div>";

        echo "</div>"; // end product-card
    }
    ?>
    </div> <!-- end products-container -->
</main>

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
            <p>University of Central Lancashire Students' Union.<br>Fylde Road, Preston. PR1 7BY<br>
               Registered in England<br>Company Number: 7623917<br>Registered Charity Number: 11426616</p>
        </div>
    </div>
    <span> &copy; 2024; Student Union Shop. All rights reserved.</span>
</footer>

<script src="js/script.js"></script>
</body>
</html>
