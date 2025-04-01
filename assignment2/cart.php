<?php
session_start();
include 'connect.php';

// Process actions from GET
if (isset($_GET['action'])) {

    // Epmty cart 
    if ($_GET['action'] === 'empty') {
        $_SESSION['cart'] = [];
        $_SESSION['cart_message'] = "Your cart has been emptied.";
        header("Location: cart.php");
        exit();
    }
    // checkout create an order record in database
    elseif ($_GET['action'] === 'checkout') {
        // If user is not logged in redirect to login.php
        if (!isset($_SESSION["user_id"])) {
            header("Location: login.php");
            exit();
        }
        $product_ids = json_encode($_SESSION['cart']);
        
        // Insert order into database
        $stmtOrder = $conn->prepare("INSERT INTO tbl_orders (user_id, product_ids) VALUES (:user_id, :product_ids)");
        $stmtOrder->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmtOrder->bindParam(':product_ids', $product_ids);
        
        if ($stmtOrder->execute()) {
            $_SESSION['cart_message'] = "Your order has been placed successfully.";
            $_SESSION['cart'] = []; // Clear cart
        } else {
            $_SESSION['cart_message'] = "There was an error processing your order.";
        }
        header("Location: cart.php");
        exit();
    }
}

// ensure  cart in session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Union Shop - Cart</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        .link a{
            text-align: center;
            color: #34516C;
            text-decoration: none;
        }
        .link a:hover{
            text-decoration: underline;
        }
        .cart-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .cart-item {
            border: 1px solid #919CAD;
            padding: 1rem;
            border-radius: 5px;
            background: #A4D3F2;
            text-align: center;
        }
        .cart-item img {
            width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }
        .cart-item p {
            margin: 0.5rem 0;
        }
        .grand-total {
            text-align: center;
            font-weight: bold;
            margin-top: 1rem;
        }
        .cart-actions {
            text-align: center;
            margin-top: 1rem;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 5px;
            border: 2px solid #34516C;
            border-radius: 25px;
            color: #34516C;
            text-decoration: none;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #34516C;
            color: #fff;
        }
    </style>
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
    <h2 style="text-align: center;">Your Cart</h2>
    
    <?php
    // Display message if exists
    if (isset($_SESSION['cart_message'])) {
        echo "<p style='text-align: center; color: green;'>" . $_SESSION['cart_message'] . "</p>";
        unset($_SESSION['cart_message']);
    }
    
    // Check if cart is empty
    if (empty($_SESSION['cart'])) {
        echo "<p style='text-align: center;'>Your cart is empty.</p>";
    } else {
        echo "<div class='cart-container'>";
        $grandTotal = 0;
        
        // Loop over each product in the cart
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $stmt = $conn->prepare("SELECT * FROM tbl_products WHERE product_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $price = $product['product_price'];
                $lineTotal = $price * $quantity;
                $grandTotal += $lineTotal;
                
                echo "<div class='cart-item'>";
                echo "<img src='" . htmlspecialchars($product['product_image']) . "' alt='" . htmlspecialchars($product['product_title']) . "'>";
                echo "<h3>" . htmlspecialchars($product['product_title']) . "</h3>";
                echo "<p>" . htmlspecialchars($product['product_desc']) . "</p>";
                echo "<p>Type: " . htmlspecialchars($product['product_type']) . "</p>";
                echo "<p>Price: £" . htmlspecialchars($price) . "</p>";
                echo "<p>Quantity: " . $quantity . "</p>";
                echo "<p>Total: £" . number_format($lineTotal, 2) . "</p>";
                echo "</div>";
            }
        }
        echo "</div>"; // end cart-container
        
        echo "<p class='grand-total'>Grand Total: £" . number_format($grandTotal, 2) . "</p>";
    }
    ?>
    
    <div class="cart-actions">

    <?php if (isset($_SESSION["user_name"])): ?>
        <a href="products.php" class="btn">Continue Shopping</a>
        <a href="cart.php?action=checkout" class="btn">Proceed to Checkout</a>
        <a href="cart.php?action=empty" class="btn">Empty Cart</a>
   <?php else: ?>
        <p class="link">Please <a href="login.php">Login</a> or <a href="register.php">Sign Up</a> to view your cart.</p>
    <?php endif; ?>
        
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
