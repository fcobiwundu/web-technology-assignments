<?php
session_start();
include 'connect.php';

// Variables for messages 
$successMsg = "";
$errorMsg   = "";

// SERVER-SIDE VALIDATION (on form submission)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName    = htmlspecialchars(trim($_POST["full_name"] ?? ""));
    $email       = htmlspecialchars(trim($_POST["email"] ?? ""));
    $address     = htmlspecialchars(trim($_POST["address"] ?? ""));
    $pass        = trim($_POST["password"] ?? "");
    $passConfirm = trim($_POST["confirm_password"] ?? "");

    // Check required fields
    if (empty($fullName) || empty($email) || empty($address) || empty($pass) || empty($passConfirm)) {
        $errorMsg = "Please fill in all fields.";
    } else {
        // Confirm password match
        if ($pass !== $passConfirm) {
            $errorMsg = "Passwords do not match.";
        } else {
            // Check complexity: uppercase, lowercase, digit, special char
            $uppercase   = preg_match('@[A-Z]@', $pass);
            $lowercase   = preg_match('@[a-z]@', $pass);
            $digit       = preg_match('@[0-9]@', $pass);
            $specialChar = preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'"\\|,.<>\/?！＠＃＄％＾＆＊（）＿＋－＝［］｛｝；：‘’“”＼｜，．＜＞／？]/', $pass);
            //
            //@[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]+@

            if (strlen($pass) < 8 || !$uppercase || !$lowercase || !$digit || !$specialChar) {
                $errorMsg = "Password must be 8+ chars, and have uppercase, lowercase, digit, and special character.";
            } else {
                try {
                    // Check if email already exists
                    $checkStmt = $conn->prepare("SELECT user_id FROM tbl_users WHERE user_email = :email");
                    $checkStmt->bindParam(':email', $email);
                    $checkStmt->execute();

                    if ($checkStmt->rowCount() > 0) {
                        $errorMsg = "That email address is already registered.";
                    } else {
                        // Hash password
                        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

                        $insertStmt = $conn->prepare(
                            "INSERT INTO tbl_users (user_full_name, user_address, user_email, user_pass)
                             VALUES (:fname, :address, :email, :upass)"
                        );
                        $insertStmt->bindParam(':fname', $fullName);
                        $insertStmt->bindParam(':address', $address);
                        $insertStmt->bindParam(':email', $email);
                        $insertStmt->bindParam(':upass', $hashedPassword);
                        $insertStmt->execute();

                        $successMsg = "Registration successful! You can now log in.";
                    }
                } catch (PDOException $e) {
                    $errorMsg = "Error: " . $e->getMessage();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Student Union Shop</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>Register a New Account</h2>

    <!-- SERVER-SIDE MESSAGES -->
    <?php if ($errorMsg): ?>
        <p class="error"><?php echo $errorMsg; ?></p>
    <?php endif; ?>
    <?php if ($successMsg): ?>
        <p class="success"><?php echo $successMsg; ?></p>
    <?php endif; ?>

    <!-- Registration Form -->
    <form action="register.php" method="POST" id="regForm">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" placeholder="Enter your full name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label for="address">Address:</label>
        <input type="text" name="address" placeholder="Enter your address" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>

        <!--password requirements list -->
        <div class="requirements hidden" id="password-requirements">
            <ul>
                <li id="req-length">At least 8 characters</li>
                <li id="req-upper">At least 1 uppercase letter (A-Z)</li>
                <li id="req-lower">At least 1 lowercase letter (a-z)</li>
                <li id="req-digit">At least 1 digit (0-9)</li>
                <li id="req-special">At least 1 special symbol (!@#$%^&* etc.)</li>
            </ul>
        </div>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
        <p id="confirmMsg" class="hidden"></p>

        <button type="submit" class="auth-btn">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</div>
<script src="js/auth.js"></script>
</body>
</html>
