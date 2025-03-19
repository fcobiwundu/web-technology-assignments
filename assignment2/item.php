<?php
session_start();
include 'connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM tbl_products WHERE product_id = :id");
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['product_title']); ?> - Student Union Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <div class="item-container" style="max-width: 800px; margin: 0 auto; text-align: center;">
        <h2><?php echo htmlspecialchars($product['product_title']); ?></h2>
        <img src="<?php echo htmlspecialchars($product['product_image']); ?>" 
             alt="<?php echo htmlspecialchars($product['product_title']); ?>" style="width:100%; max-width:400px;">
        <p><?php echo htmlspecialchars($product['product_desc']); ?></p>
        <p>Price: £<?php echo htmlspecialchars($product['product_price']); ?></p>
        <p>Type: <?php echo htmlspecialchars($product['product_type']); ?></p>

        <div class="product-buttons" style="margin-top: 1rem;">
            <a href="products.php" class="btn">Back to Products</a>
            <a href="cart.php?action=add&id=<?php echo urlencode($product['product_id']); ?>" class="btn">Add to Cart</a>
            <a href="cart.php" class="btn">View Cart</a>
        </div>
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
            <p>University of Central Lancashire Students' Union.<br>Fylde Road, Preston. PR1 7BY<br>
            Registered in England<br>Company Number: 7623917<br>Registered Charity Number: 11426616</p>
        </div>
    </div>
    <span>&copy; 2024; Student Union Shop. All rights reserved.</span>
</footer>

<script src="js/script.js"></script>
</body>
</html>
