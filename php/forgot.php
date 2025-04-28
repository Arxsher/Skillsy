<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("mydb.php");

if (!isset($_GET['token'])) {
    $forgotMessage = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $forgotMessage = "Invalid email format.";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

                $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
                $stmt->execute([$token, $expires, $email]);

                $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/forgot.php?token=$token";
                $forgotMessage = "Your reset password link is ready. Reset link: <a href='$resetLink'>$resetLink</a>";

                $_SESSION['debug_email'] = $email;
            } else {
                $forgotMessage = "No account found with that email address.";
            }
        }
        // Set feedback and redirect to index.php to show modal and message
        $_SESSION['forgotMessage'] = $forgotMessage;
        header('Location: /hackathon/index.php?showForgot=1');
        exit();
    }
    // No HTML output here; logic only
    return;
} else {
    $token = $_GET['token'];
    $message = '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $message = "<p class='error'>Invalid or expired token. Please request a new password reset link.</p>";
        header("refresh:5;url=" . $_SERVER['PHP_SELF']);
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if (strlen($password) < 8) {
                $message = "<p class='error'>Password must be at least 8 characters long.</p>";
            } elseif ($password !== $confirmPassword) {
                $message = "<p class='error'>Passwords do not match.</p>";
            } else {
                $newPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("UPDATE users SET pswrd = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
                $stmt->execute([$newPassword, $user['id']]);

                $message = "<p class='success'>✅ Password has been reset successfully! <a href='login.php'>Login with your new password</a></p>";

                unset($_SESSION['debug_email']);
            }
        }
    }
    // Keep the reset password HTML for token-based reset
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Set New Password</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
            h1 { text-align: center; color: #333; }
            form { display: flex; flex-direction: column; }
            input { padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; }
            button { padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background-color: #45a049; }
            .password-requirements { font-size: 0.8em; color: #666; margin-bottom: 15px; }
            .success { padding: 10px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; margin-bottom: 20px; }
            .error { padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24; margin-bottom: 20px; }
        </style>
    </head>
    <body>
        <h1>Set New Password</h1>
        <?php echo $message; ?>
        <?php if ($user): ?>
            <form method="post">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <div class="password-requirements">Password must be at least 8 characters long</div>
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
        <?php if (!$user): ?>
            <p style="text-align: center; margin-top: 20px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Request a new reset link</a></p>
        <?php endif; ?>
    </body>
    </html>
<?php } ?>