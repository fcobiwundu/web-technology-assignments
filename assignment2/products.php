<?php
session_start();
include 'connect.php';

$message = "";
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    // If usre is not logged in, redirect to login.php
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }
    
    $product_id = intval($_GET['id']);
    
    // Retrieve product title to display in confirmation message
    $stmtProduct = $conn->prepare("SELECT product_title FROM tbl_products WHERE product_id = :id");
    $stmtProduct->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmtProduct->execute();
    $prod = $stmtProduct->fetch(PDO::FETCH_ASSOC);
    
    if ($prod) {
        // Initialize cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
          // add or increment the product quantity in the session cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
        $message = htmlspecialchars($prod['product_title']) . " has been added to your cart.";
    } else {
        $message = "Product not found.";
    }
}

// Read filter/search from GET
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM tbl_products";
$where = [];

// Filter logic
if ($filter === 'hoodie') {
    $where[] = "product_type LIKE '%Hoodie%'";
} elseif ($filter === 'jumper') {
    $where[] = "product_type LIKE '%Jumper%'";
} elseif ($filter === 'tshirt') {
    $where[] = "product_type LIKE '%Tshirt%'";
}

// Search logic
if (!empty($search)) {
    $where[] = "(product_title LIKE :search OR product_desc LIKE :search)";
}

// Combine WHERE  if any
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// Order by product_id
$sql .= " ORDER BY product_id ASC";

$stmt = $conn->prepare($sql);

// Bind search parameter if used
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
            <img src="resources/images/logos/logo.svg" alt="Student Union Logo">
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
    <!-- Display confirmation message if a product was added -->
    <?php if ($message): ?>
        <p style="text-align: center; color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <h2 style="text-align: center;">Our Collection</h2>

    <!-- Filter + Search Container -->
    <div style="text-align: center; margin: 1rem 0;">
        <a href="products.php?filter=all" class="filter-btn">All</a>
        <a href="products.php?filter=tshirt" class="filter-btn">T-Shirts</a>
        <a href="products.php?filter=jumper" class="filter-btn">Jumpers</a>
        <a href="products.php?filter=hoodie" class="filter-btn">Hoodies</a>
        <form method="GET" action="products.php" style="margin-top: 1rem;">
            <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
            <input type="text" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="products-container">
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='product-card'>";
        
        // Product Image
        echo "<img src='" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_title']) . "'>";
        
        // Product Title
        echo "<h3>" . htmlspecialchars($row['product_title']) . "</h3>";     
        
        // Product Price
        echo "<p>Price: £" . htmlspecialchars($row['product_price']) . "</p>";
        
        // Product Type
       
        
        // Action Buttons
        echo "<div class='product-buttons'>";
        echo "<a href='item.php?id=" . urlencode($row['product_id']) . "' class='btn'>Read More</a>";
        // "Add to Basket" always points to products.php with action=add so the page reloads and shows a message
        echo "<a href='products.php?action=add&id=" . urlencode($row['product_id']) . "' class='btn'>Add to Basket</a>";
        echo "<a href='cart.php' class='btn'>View Cart</a>";
        echo "</div>";
        
        echo "</div>"; // End product-card
    }
    ?>
    </div>
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
            <p>University of Central Lancashire Students' Union.<br>
               Fylde Road, Preston. PR1 7BY<br>
               Registered in England<br>
               Company Number: 7623917<br>
               Registered Charity Number: 11426616</p>
        </div>
    </div>
    <span>&copy; 2024; Student Union Shop. All rights reserved.</span>
</footer>

<script src="js/script.js"></script>
</body>
</html>
