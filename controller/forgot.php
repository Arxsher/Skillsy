<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['token'])) {
    header('Location: ../view/index.php?showForgot=1');
    exit();
}

// require
require_once __DIR__ . '/../model/mydb.php';

if (!isset($_GET['token'])) {
    $forgotMessage = '';

    // forgot logic
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // validate email
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $forgotMessage = "Invalid email format.";
        } else {
            // query user
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // generate token
                $token = bin2hex(random_bytes(32));
                $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

                // store token
                $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
                $stmt->execute([$token, $expires, $email]);

                // send email
                $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/forgot.php?token=$token";
                $forgotMessage = "Your reset password link is ready. Reset link: <a href='$resetLink'>$resetLink</a>";

                $_SESSION['debug_email'] = $email;
            } else {
                // error
                $forgotMessage = "No account found with that email address.";
            }
        }
        $_SESSION['forgotMessage'] = $forgotMessage;
        header('Location: ../view/index.php?showForgot=1');
        exit();
    }
    return;
} else {
    $token = $_GET['token'];
    $message = '';

    // validate token
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        // error
        $message = "<p class='error'>Invalid or expired token. Please request a new password reset link.</p>";
        header("refresh:5;url=" . $_SERVER['PHP_SELF']);
    } else {
        // reset password logic
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if (strlen($password) < 8) {
                // error
                $message = "<p class='error'>Password must be at least 8 characters long.</p>";
            } elseif ($password !== $confirmPassword) {
                // error
                $message = "<p class='error'>Passwords do not match.</p>";
            } else {
                // update password
                $newPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("UPDATE users SET pswrd = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
                $stmt->execute([$newPassword, $user['id']]);

                // success
                $message = "<p class='success'>✅ Password has been reset successfully! <a href='login.php'>Login with your new password</a></p>";

                unset($_SESSION['debug_email']);
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Set New Password</title>
      <link rel="stylesheet" href="../home.css">
      <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#161618] flex items-center justify-center min-h-screen">
      <div class="w-full max-w-md bg-[#23232a] rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Set New Password</h2>
        <?php echo $message; ?>
        <?php if ($user && strpos($message, 'successfully') === false): ?>
          <form method="post" class="space-y-4">
            <div>
              <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">New Password</label>
              <input type="password" id="password" name="password" required class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
            </div>
            <div>
              <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-1.5">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" required class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
            </div>
            <div class="text-xs text-gray-400 mb-2">Password must be at least 8 characters long</div>
            <button type="submit" class="w-full bg-[#FF8A00] hover:bg-yellow-500 text-black font-semibold py-2.5 px-4 rounded-lg transition-all duration-200">Reset Password</button>
          </form>
        <?php elseif (strpos($message, 'successfully') !== false): ?>
          <a href="../view/index.php" class="block w-full mt-6 bg-[#FF8A00] hover:bg-yellow-500 text-black text-center font-semibold py-2.5 px-4 rounded-lg transition-all duration-200">Back to Login</a>
        <?php endif; ?>
        <?php if (!$user): ?>
          <p class="text-center mt-6"><a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="text-[#FF8A00] hover:underline">Request a new reset link</a></p>
        <?php endif; ?>
      </div>
    </body>
    </html>
<?php } ?>