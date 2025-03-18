<?php
session_start();
include 'connect.php';
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = htmlspecialchars(trim($_POST["email"] ?? ""));
    $password = trim($_POST["password"] ?? "");

    if (!empty($email) && !empty($password)) {
        // prepare statement will get  record
        $stmt = $conn->prepare("SELECT user_id, user_full_name, user_pass FROM tbl_users WHERE user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // will compare the typed password with hashed password from the database
            if (password_verify($password, $user["user_pass"])) {
                $_SESSION["user_id"]   = $user["user_id"];
                $_SESSION["user_name"] = $user["user_full_name"];

                // Redirect to homepage
                header("Location: index.php");
                exit();
            } else {
                $errorMsg = "Invalid email or password.";
            }
        } else {
            $errorMsg = "Invalid email or password.";
        }
    } else {
        $errorMsg = "Please fill in both fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Student Union Shop</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>Login to Your Account</h2>

    <?php if ($errorMsg): ?>
        <p class="error"><?php echo $errorMsg; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <button type="submit" class="auth-btn">Login</button>
    </form>
    <p>New user? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
