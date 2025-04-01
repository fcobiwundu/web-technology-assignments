<?php
session_start();
include 'connect.php';

// checks if product id is provide if not redirect to products.php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['id']);

// Process add to basket action
if (isset($_GET['action']) && $_GET['action'] === 'add') {
    // checks the user is not logged in if noy redirect them to login.php
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    $stmtProduct = $conn->prepare("SELECT product_title FROM tbl_products WHERE product_id = :id");
    $stmtProduct->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmtProduct->execute();
    $prod = $stmtProduct->fetch(PDO::FETCH_ASSOC);

    if ($prod) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // increment the product quantity in the session cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }

        // added to cart message 
        $_SESSION['cart_message'] = htmlspecialchars($prod['product_title']) . " has been added to your basket.";

        // not to hav avoid duplicate additions on refresh
        header("Location: item.php?id=" . $product_id);
        exit();
    } else {
        $_SESSION['cart_message'] = "Product not found.";
        header("Location: item.php?id=" . $product_id);
        exit();
    }
}

// review submission
$reviewMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_title'], $_POST['review_desc'], $_POST['review_rating']) && isset($_SESSION['user_id'])) {
    $review_title = trim($_POST['review_title']);
    $review_desc = trim($_POST['review_desc']);
    $review_rating = intval($_POST['review_rating']);
    $user_id = $_SESSION['user_id'];

    $stmtInsert = $conn->prepare("INSERT INTO tbl_reviews (user_id, product_id, review_title, review_desc, review_rating) VALUES (:uid, :pid, :title, :desc, :rating)");
    $stmtInsert->execute([
        ':uid' => $user_id,
        ':pid' => $product_id,
        ':title' => $review_title,
        ':desc' => $review_desc,
        ':rating' => $review_rating
    ]);

    $reviewMessage = "Your review has been submitted.";
}

// claer the added to cart message
$cartMessage = "";
if (isset($_SESSION['cart_message'])) {
    $cartMessage = $_SESSION['cart_message'];
    unset($_SESSION['cart_message']);
}

$stmt = $conn->prepare("SELECT * FROM tbl_products WHERE product_id = :id");
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// If product not found, display n error and exit
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
    <style>
        .link{
            text-align: center;
        }
        .link a{
            color: #34516C;
            text-decoration: none;
        }
        .link a:hover{
            text-decoration: underline;
        }
        .item-container{
            max-width: 800px; 
            margin: 0 auto; 
            text-align: center;
        }
        .review-section{
            max-width: 800px; 
            margin: 2rem auto; 
            text-align: left;
        }
       .rewiew-form .btn {
        border: 2px solid #34516C;
        padding: 6px 12px;
        border-radius: 25px;
        color: #34516C;
        text-decoration: none;
        font-weight: bold;
        }
    
        .rewiew-form .btn:hover {
            background-color: #34516C;
            color: #fff;
        }
    </style>
</head>
<body>

<!-- Header Section -->
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
    <div class="item-container">
        <?php if (!empty($cartMessage)): ?>
            <p style="color: green;"><?php echo $cartMessage; ?></p>
        <?php endif; ?>

        <h2><?php echo htmlspecialchars($product['product_title']); ?></h2>
        <img src="<?php echo htmlspecialchars($product['product_image']); ?>" 
             alt="<?php echo htmlspecialchars($product['product_title']); ?>" style="width:100%; max-width:400px;">
        <p><?php echo htmlspecialchars($product['product_desc']); ?></p>
        <p>Price: £<?php echo htmlspecialchars($product['product_price']); ?></p>
        <p>Type: <?php echo htmlspecialchars($product['product_type']); ?></p>

        <div class="product-buttons" style="margin-top: 1rem;">
            <a href="products.php" class="btn">Back to Products</a>
            <a href="item.php?id=<?php echo urlencode($product['product_id']); ?>&action=add" class="btn">Add to Basket</a>
            <a href="cart.php" class="btn">View Cart</a>
        </div>
    </div>

    <!-- item reviews -->
    <div class="review-section">
        <h3>Product Reviews</h3>

        <?php if (!empty($reviewMessage)): ?>
            <p style="color: green;"><strong><?php echo $reviewMessage; ?></strong></p>
        <?php endif; ?>

        <?php
        $stmt = $conn->prepare("SELECT review_rating FROM tbl_reviews WHERE product_id = :pid");
        $stmt->bindParam(':pid', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $ratings = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($ratings) {
            $avgRating = array_sum($ratings) / count($ratings);
            echo "<p>Average Rating: " . number_format($avgRating, 1) . " / 5</p>";
            echo "<div style='color: gold; font-size: 1.5rem;'>" . str_repeat("★", round($avgRating)) . str_repeat("☆", 5 - round($avgRating)) . "</div><br>";
        } else {
            echo "<p>No reviews yet for this product.</p>";
        }

        $stmt = $conn->prepare("SELECT * FROM tbl_reviews WHERE product_id = :pid ORDER BY review_timestamp DESC");
        $stmt->bindParam(':pid', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($reviews as $rev) {
            echo "<div style='border-top:1px solid #ccc; padding:10px 0;'>";
            echo "<strong>" . htmlspecialchars($rev['review_title']) . "</strong><br>";
            echo "<small>Rating: " . $rev['review_rating'] . " / 5</small>";
            echo "<p>" . htmlspecialchars($rev['review_desc']) . "</p>";
            echo "</div>";
        }
        ?>
    </div>

    <?php if (isset($_SESSION["user_id"])): ?>
    <div class="review-form" style="max-width: 800px; margin: 2rem auto;">
        <h3>Post a Review</h3>
        <form method="POST">
            <label>Review Title:</label><br>
            <input type="text" name="review_title" required style="width:100%;"><br><br>
            <label>Description:</label><br>
            <textarea name="review_desc" required style="width:100%; height:100px;"></textarea><br><br>
            <label>Rating (1 to 5):</label><br>
            <select name="review_rating" required>
                <option value="">Select</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select><br><br>
            <button type="submit" class="btn">Submit Review</button>
        </form>
    </div>
    <?php else: ?>
        <p class="link">Please <a href="login.php">login</a> to post a review.</p>
    <?php endif; ?>
</main>

<!-- Footer Section -->
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
            <p>
                University of Central Lancashire Students' Union.<br>
                Fylde Road, Preston. PR1 7BY<br>
                Registered in England<br>
                Company Number: 7623917<br>
                Registered Charity Number: 11426616
            </p>
        </div>
    </div>
    <span>&copy; 2024; Student Union Shop. All rights reserved.</span>
</footer>

<script src="js/script.js"></script>
</body>
</html>
