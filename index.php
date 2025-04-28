<?php
session_start();
include 'php/mydb.php';

$forgotMessage = '';
if (isset($_SESSION['forgotMessage'])) {
    $forgotMessage = $_SESSION['forgotMessage'];
    unset($_SESSION['forgotMessage']);
}
$forgotMessageClass = '';
if ($forgotMessage) {
    $forgotMessageClass = (stripos($forgotMessage, 'invalid') !== false || stripos($forgotMessage, 'no account') !== false) ? 'text-red-500' : 'text-green-500';
}

$isLoggedIn = isset($_SESSION['userName']);
$name = ($isLoggedIn && isset($_SESSION['name']) && !empty(trim($_SESSION['name']))) ? $_SESSION['name'] : '';
$userName = ($isLoggedIn && isset($_SESSION['userName']) && !empty(trim($_SESSION['userName']))) ? $_SESSION['userName'] : '';

$showLoginModal = false;
$showForgotSection = false;
if (isset($_SESSION['showLoginModal']) && $_SESSION['showLoginModal'] === true) {
    $showLoginModal = true;
    unset($_SESSION['showLoginModal']); 
}
if (isset($_GET['showForgot']) && !empty($forgotMessage)) {
    $showLoginModal = true;
    $showForgotSection = true;
}

$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$errorName = isset($_SESSION['errorName']) ? $_SESSION['errorName'] : '';
$errorUserName = isset($_SESSION['errorUserName']) ? $_SESSION['errorUserName'] : '';
$errorEmail = isset($_SESSION['errorEmail']) ? $_SESSION['errorEmail'] : '';
$errorPswrd = isset($_SESSION['errorPswrd']) ? $_SESSION['errorPswrd'] : '';

unset($_SESSION['error']);
unset($_SESSION['errorName']);
unset($_SESSION['errorUserName']);
unset($_SESSION['errorEmail']);
unset($_SESSION['errorPswrd']);

$activeModalSection = isset($_SESSION['activeModalSection']) ? $_SESSION['activeModalSection'] : 'signup';
unset($_SESSION['activeModalSection']);

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skillsy - Developer Community Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />
    <link rel="stylesheet" href="test.css" />
  </head>

  <body class="gradient-bg min-h-screen">
    <div class="fixed top-0 left-1/4 w-96 h-96 animated-gradient"></div>
    <div class="fixed bottom-0 right-1/4 w-96 h-96 animated-gradient"></div>

    <!-- modal -->
    <div
      id="login"
    class="fixed inset-0 z-50  flex items-center justify-center hidden">

      <div
        class="absolute inset-0 bg-black bg-opacity-70"
      id="modalOverlay"></div>
      <div
        class="relative bg-login bg-[#161618] rounded-2xl overflow-hidden w-[95%] max-w-6xl flex shadow-2xl"
      style="max-height: 85vh">
        <!-- Left side -->
        <div class="w-full md:w-1/2 p-6 md:p-10 overflow-y-auto">
          <div class="mb-4">
            <h2 class="text-3xl font-bold text-white">Join Skillsy's com.</h2>
            <p class="text-gray-400">Explore More. Experience Life.</p>
          </div>

          <div class="flex space-x-4 mb-6">
            <button
              id="signUpToggle"
            class="w-1/2 bg-black text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 active-tab">
              Sign Up
            </button>
            <button
              id="loginToggle"
            class="w-1/2 bg-transparent text-white border border-gray-700 font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 hover:bg-white/5">
              Log In
            </button>
          </div>

          <!-- Sign Up 1 -->
        <span><?php if (isset($inscription)) echo "<p style='color:green;'>$inscription</p>" ?></span>
        <span><?php if (isset($error)) echo "<p style='color:red;'>$error</p>" ?></span> <br>
        <span><?php if (isset($alert)) echo "<p style='color:red;'>$alert</p>" ?></span>
        <form action="<?php echo htmlspecialchars('php/signin.php', ENT_QUOTES, 'UTF-8') ?>" method="post" id="signupForm">
          <div id="signUpStep1" class="form-section hidden">
            <div class="mb-6">
              <h3 class="text-xl font-bold text-white mb-2">
                Begin Your Adventure
              </h3>
              <p class="text-gray-400 mb-4">Sign Up with Open account</p>

              <?php if (!empty($errorMessage)): ?>
                <p style="color:red;"><?php echo $errorMessage; ?></p>
              <?php endif; ?>

              <div class="flex space-x-4 mb-5">
                <button
                  class="flex-1 flex justify-center items-center py-2.5 border border-gray-700 rounded-lg bg-[#2a2a3a] hover:bg-[#2a2a3a]/80">
                  <svg
                    class="w-5 h-5"
                    viewBox="0 0 16 16"
                    fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.182 7.68c-.019-1.827 1.502-2.699 1.57-2.743-.852-1.245-2.18-1.415-2.654-1.437-1.133-.116-2.2.667-2.77.667-.577 0-1.463-.645-2.406-.628-1.24.02-2.38.72-3.013 1.825-1.283 2.229-.328 5.536.925 7.334.609.882 1.338 1.87 2.294 1.835.918-.037 1.268-.593 2.38-.593 1.113 0 1.424.593 2.4.575 1.01-.019 1.63-.91 2.24-1.796.704-1.03.996-2.022 1.033-2.07-.02-.01-1.985-.763-2.003-3.024l.004-.02z" />
                    <path
                      d="M9.5 4.573C10.008 3.958 10.343 3.098 10.232 2.22c-9.352.038-1.825.98-2.27 1.613.636.076 1.282-.49 1.884-.992.562-.476.998-1.185 1.115-1.885.38.884.067 1.751-.461 2.617z" />
                  </svg>
                </button>
                <button
                  class="flex-1 flex justify-center items-center py-2.5 border border-gray-700 rounded-lg bg-[#2a2a3a] hover:bg-[#2a2a3a]/80">
                  <svg
                    class="w-5 h-5"
                    viewBox="0 0 18 18"
                  xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill="#4285F4"
                      d="M17.64 9.2c0-.74-.06-1.28-.19-1.84H9v3.34h4.96c-.1.83-.64 2.08-1.84 2.92l2.84 2.2c1.7-1.57 2.68-3.88 2.68-6.62z" />
                    <path
                      fill="#FBBC05"
                      d="M3.88 10.78A5.54 5.54 0 001 9c0-.62.11-1.22.29-1.78L.96 4.96A9.008 9.008 0 00 0 9c0 1.45.35 2.82.96 4.04l2.92-2.26z" />
                    <path
                      fill="#34A853"
                      d="M9 18c2.43 0 4.47-.8 5.96-2.18l-2.84-2.2c-.76.53-1.78.9-3.12.9-2.38 0-4.4-1.57-5.12-3.74L.97 13.04C2.45 15.98 5.48 18 9 18z" />
                    <path
                      fill="#EA4335"
                      d="M9 3.48c1.69 0 2.83.73 3.48 1.34l2.54-2.48C13.46.89 11.43 0 9 0 5.48 0 2.44 2.02.96 4.96l2.91 2.26C4.6 5.05 6.62 3.48 9 3.48z" />
                  </svg>
                </button>
                <button
                  class="flex-1 flex justify-center items-center py-2.5 border border-gray-700 rounded-lg bg-[#2a2a3a] hover:bg-[#2a2a3a]/80">
                  <svg
                    class="w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                  fill="currentColor">
                    <path
                      d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932Z" />
                  </svg>
                </button>
              </div>

              <div class="flex items-center mb-5">
                <div class="flex-grow border-t border-gray-700"></div>
                <span class="px-4 text-sm text-gray-500">or</span>
                <div class="flex-grow border-t border-gray-700"></div>
              </div>
            </div>

            <div class="mb-4">
              <label
                for="username"
                class="block text-sm font-medium text-gray-300 mb-1.5">Username</label>
              <input
                type="text"
                id="username"
                name="userName"
                class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="@.Enter your username"
                value="<?php echo isset($userName) ? htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') : ''; ?>"
              />
              <span class="text-red-500 text-xs mt-1 block"><?php if (isset($errorUserName)) echo $errorUserName; ?></span>
            </div>

            <div class="mb-4">
              <label
                for="email"
                class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your email"
                value="<?php echo isset($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : ''; ?>"
              />
              <span class="text-red-500 text-xs mt-1 block"><?php if (isset($errorEmail)) echo $errorEmail; ?></span>
            </div>

            <div class="mb-5">
              <label
                for="password"
                class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
              <div class="relative">
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="••••••••"
                />
                <span class="text-red-500 text-xs mt-1 block"><?php if (isset($errorPswrd)) echo $errorPswrd; ?></span>
                <button
                  type="button"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 password-toggle-icon"
                data-target="password">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 hide-password"
                    viewBox="0 0 20 20"
                  fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path
                      fill-rule="evenodd"
                      d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                    clip-rule="evenodd" />
                  </svg>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 show-password"
                    viewBox="0 0 20 20"
                  fill="currentColor">
                    <path
                      fill-rule="evenodd"
                      d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                    clip-rule="evenodd" />
                    <path
                      d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                  </svg>
                </button>
              </div>
            </div>

            <div class="flex items-center mb-5">
              <input
                type="checkbox"
                id="remember"
                name="remember"
              style="display: none" />
              <label for="remember" class="check">
                <svg width="18px" height="18px" viewBox="0 0 18 18">
                  <path
                  d="M 1 9 L 1 9 c 0 -5 3 -8 8 -8 L 9 1 C 14 1 17 5 17 9 L 17 9 c 0 4 -4 8 -8 8 L 9 17 C 5 17 1 14 1 9 L 1 9 Z"></path>
                  <polyline points="1 9 7 14 15 4"></polyline>
                </svg>
              </label>
              <label
                for="remember"
              class="ml-2 text-sm text-gray-300 cursor-pointer">Remember me</label>
            </div>

            <button
              type="button"
              id="nextButton"
              class="w-full bg-[#FF8A00] text-black font-semibold py-2.5 px-4 rounded-lg hover:bg-[#FF8A00]/90 transition-all duration-200 mb-4">
              Next
            </button>
          </div>

          <!-- Sign Up 2 -->
          <div id="signUpStep2" class="form-section hidden">
            <div class="mb-6">
              <h3 class="text-xl font-bold text-white mb-2">
                Tell Us More About You
              </h3>
              <p class="text-gray-400 mb-4">
                Help us personalize your experience
              </p>
            </div>

            <div class="mb-4">
              <label
                for="name"
                class="block text-sm font-medium text-gray-300 mb-1.5">What should we call you?</label>
              <input
                type="text"
                id="name"
                name="name"
                class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your full name"
                value="<?php echo isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : ''; ?>"
              />
              <span class="text-red-500 text-xs mt-1 block"><?php if (isset($errorName)) echo $errorName; ?></span>
            </div>

            <div class="mb-4">
              <label
                for="major"
                class="block text-sm font-medium text-gray-300 mb-1.5">What's your major?</label>
              <select
                id="major"
                name="major"
                class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="" disabled selected>Select your major</option>
                <option value="travel">Travel & Tourism</option>
                <option value="photography">Travel Photography</option>
                <option value="food">Food & Culture</option>
                <option value="adventure">Adventure Sports</option>
                <option value="other">Other</option>
              </select>
            </div>

            <div class="mb-5">
              <label
                for="skills"
                class="block text-sm font-medium text-gray-300 mb-1.5">What are your skills?</label>
              <textarea
                id="skills"
                name="skills"
                rows="3"
                class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="e.g., Photography, Travel planning, Languages..."
              ><?php echo isset($skills) ? htmlspecialchars($skills, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
            </div>

            <div class="flex mb-5">
              <button
                type="button"
                id="backToStep1"
                class="w-1/3 bg-transparent border border-gray-700 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-white/5 transition-all duration-200 mr-3">
                Back
              </button>
              <button
                type="submit"
                name="signin"
                id="submitSignUp"
                class="w-2/3 bg-[#FF8A00] text-black font-semibold py-2.5 px-4 rounded-lg hover:bg-[#FF8A00]/90 transition-all duration-200">
                Let's Start
              </button>
            </div>
          </div>
        </form>

          <div id="loginForm" class="form-section hidden overflow-hidden">
            <div class="mb-6">
              <h3 class="text-xl font-bold text-white mb-2">Welcome Back</h3>
              <p class="text-gray-400 mb-4">Log in to continue your journey</p>
            </div>

          <?php if (!empty($errorMessage)): ?>
            <p style="color:red;"><?php echo $errorMessage; ?></p>
          <?php endif; ?>

          <form action="<?php echo htmlspecialchars('php/login.php', ENT_QUOTES, 'UTF-8') ?>" method="post">
              <div class="mb-4">
                <label
                  for="loginEmail"
                class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                <input
                  type="email"
                  id="loginEmail"
                name="email"
                  class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="your@email.com"
                  value="<?php echo isset($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : ''; ?>"
                />
                <span class="text-red-500 text-xs mt-1 block"><?php if (isset($errorEmail)) echo $errorEmail; ?></span>
              </div>

              <div class="mb-4">
                <div class="flex justify-between items-center mb-1.5">
                  <label
                    for="loginPassword"
                  class="block text-sm font-medium text-gray-300">Password</label>
                  <a href="#" id="showForgotPassword" class="text-xs text-[#FF8A00] hover:underline">Forgot password?</a>
                </div>
                <div class="relative">
                  <input
                    type="password"
                    id="loginPassword"
                  name="password"
                    class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="••••••••"
                  />
                  <span class="text-red-500 text-xs mt-1 block"><?php if (isset($errorPswrd)) echo $errorPswrd; ?></span>
                  <button
                    type="button"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 password-toggle-icon"
                  data-target="loginPassword">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 hide-password"
                      viewBox="0 0 20 20"
                    fill="currentColor">
                      <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                      <path
                        fill-rule="evenodd"
                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                      clip-rule="evenodd" />
                    </svg>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 show-password"
                      viewBox="0 0 20 20"
                    fill="currentColor">
                      <path
                        fill-rule="evenodd"
                        d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                      clip-rule="evenodd" />
                      <path
                        d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                    </svg>
                  </button>
                </div>
              </div>

              <div class="flex items-center mb-5">
                <input
                  type="checkbox"
                  id="rememberLogin"
                  name="rememberLogin"
                style="display: none" />
                <label for="rememberLogin" class="check">
                  <svg width="18px" height="18px" viewBox="0 0 18 18">
                    <path
                    d="M 1 9 L 1 9 c 0 -5 3 -8 8 -8 L 9 1 C 14 1 17 5 17 9 L 17 9 c 0 4 -4 8 -8 8 L 9 17 C 5 17 1 14 1 9 L 1 9 Z"></path>
                    <polyline points="1 9 7 14 15 4"></polyline>
                  </svg>
                </label>
                <label
                  for="rememberLogin"
                class="ml-2 text-sm text-gray-300 cursor-pointer">Remember me</label>
              </div>

              <button
                type="submit"
              name="send"
              class="w-full bg-[#FF8A00] text-black font-semibold py-2.5
               px-4 rounded-lg hover:bg-[#FF8A00]/90 transition-all duration-200 
               mb-4">
              Log In..
              </button>

              <div class="flex items-center my-5">
                <div class="flex-grow border-t border-gray-700"></div>
                <span class="px-4 text-xs text-gray-500">Or log in with</span>
                <div class="flex-grow border-t border-gray-700"></div>
              </div>

              <div class="flex space-x-3">
                <button
                class="flex-1 flex justify-center items-center py-2 border border-gray-700 rounded-lg bg-[#2a2a3a] hover:bg-[#2a2a3a]/80">
                  <svg
                    class="w-5 h-5"
                    viewBox="0 0 16 16"
                    fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                    d="M11.182 7.68c-.019-1.827 1.502-2.699 1.57-2.743-.852-1.245-2.18-1.415-2.654-1.437-1.133-.116-2.2.667-2.77.667-.577 0-1.463-.645-2.406-.628-1.24.02-2.38.72-3.013 1.825-1.283 2.229-.328 5.536.925 7.334.609.882 1.338 1.87 2.294 1.835.918-.037 1.268-.593 2.38-.593 1.113 0 1.424.593 2.4.575 1.01-.019 1.63-.91 2.24-1.796.704-1.03.996-2.022 1.033-2.07-.02-.01-1.985-.763-2.003-3.024l.004-.02z" />
                    <path
                    d="M9.5 4.573C10.008 3.958 10.343 3.098 10.232 2.22c-9.352.038-1.825.98-2.27 1.613.636.076 1.282-.49 1.884-.992.562-.476.998-1.185 1.115-1.885.38.884.067 1.751-.461 2.617z" />
                  </svg>
                </button>
                <button
                class="flex-1 flex justify-center items-center py-2 border border-gray-700 rounded-lg bg-[#2a2a3a] hover:bg-[#2a2a3a]/80">
                  <svg
                    class="w-5 h-5"
                    viewBox="0 0 18 18"
                  xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill="#EA4335"
                    d="M9 3.48c1.69 0 2.83.73 3.48 1.34l2.54-2.48C13.46.89 11.43 0 9 0 5.48 0 2.44 2.02.96 4.96l2.91 2.26C4.6 5.05 6.62 3.48 9 3.48z" />
                    <path
                      fill="#4285F4"
                    d="M17.64 9.2c0-.74-.06-1.28-.19-1.84H9v3.34h4.96c-.1.83-.64 2.08-1.84 2.92l2.84 2.2c1.7-1.57 2.68-3.88 2.68-6.62z" />
                    <path
                      fill="#FBBC05"
                    d="M3.88 10.78A5.54 5.54 0 001 9c0-.62.11-1.22.29-1.78L.96 4.96A9.008 9.008 0 00 0 9c0 1.45.35 2.82.96 4.04l2.92-2.26z" />
                    <path
                      fill="#34A853"
                    d="M9 18c2.43 0 4.47-.8 5.96-2.18l-2.84-2.2c-.76.53-1.78.9-3.12.9-2.38 0-4.4-1.57-5.12-3.74L.97 13.04C2.45 15.98 5.48 18 9 18z" />
                  </svg>
                </button>
                <button
                class="flex-1 flex justify-center items-center py-2 border border-gray-700 rounded-lg bg-[#2a2a3a] hover:bg-[#2a2a3a]/80">
                  <svg
                    class="w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                  fill="currentColor">
                    <path
                      d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932Z" />
                  </svg>
                </button>
              </div>
            </form>

            
          </div>
          <!-- Login Step 2: Forgot Password -->
          <div id="forgotPasswordStep" class="form-section hidden flex flex-col justify-center min-h-[400px] p-8">
              <div class="mb-6 text-center">
                <?php if (!empty($forgotMessage)): ?>
                  <h3 class="text-2xl font-bold text-white mb-2">Password Reset Link Sent</h3>
                  <p class="text-gray-300 mb-4">Check your email for the reset link below.</p>
                  <p class="<?php echo $forgotMessageClass; ?> mb-4 text-center"><?php echo $forgotMessage; ?></p>
                <?php else: ?>
                  <h3 class="text-2xl font-bold text-white mb-2">Forgot Password?</h3>
                  <p class="text-gray-300 mb-4">Enter your email address to generate a password reset link.</p>
                  <form action="php/forgot.php" method="post" class="flex flex-col gap-4">
                    <div>
                    <label
                for="email"
                class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                      <input type="email" id="forgotEmail" name="email" class="w-full bg-[#2a2a3a] border border-gray-700 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="your@email.com" required />
                    </div>
                    <button type="submit" class="w-full bg-[#FF8A00] text-black font-semibold py-2.5 px-4 rounded-lg hover:bg-[#FF8A00]/90 transition-all duration-200">Send Reset Link</button>
                  </form>
                <?php endif; ?>
                <button id="backToLoginStep" type="button" class="w-full mt-4 bg-gray-700 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-gray-600 transition-all duration-200">Back to Login</button>
              </div>
          </div>
        </div>
        

        <!-- Right side -->
        <div
        class="w-full md:w-1/2 p-6 md:p-10 overflow-y-auto hidden md:inline-block">
          <img
            src="https://app.folk.app/assets/login-product-preview-dark-Ch9H6vn8.avif"
            alt=""
          class="opacity-80 mt-16 mr-0" />
          <div id="testimonials" class="text-center max-w-1x2 mt-16 opacity-70">
            <div class="text-2xl font-bold text-white mb-6">
              Trusted by 3000+ Developer around the world
            </div>
            <div class="flex flex-wrap justify-center gap-8 md:gap-16">
              <div class="flex flex-col items-center">
                <span class="text-3xl font-bold text-white">4.9</span>
                <div class="flex my-2">
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                </div>
                <div class="flex items-center">
                  <div
                  class="w-6 h-6 rounded-full bg-[#FF6154] flex items-center justify-center mr-2">
                    <svg viewBox="0 0 14 14" fill="none" class="w-4 h-4">
                      <path
                        d="M10.0317 5.36124H8.83608C8.86828 5.17364 8.98451 5.06864 9.2197 4.94964L9.43946 4.83764C9.83294 4.63604 10.0429 4.40784 10.0429 4.03544C10.0429 3.80164 9.95191 3.61684 9.77127 3.48384C9.59073 3.35084 9.37789 3.28504 9.12868 3.28504C8.93592 3.28277 8.74666 3.33678 8.58412 3.44044C8.4203 3.54124 8.2985 3.67144 8.2229 3.83384L8.56868 4.18104C8.70309 3.90944 8.89774 3.77644 9.15387 3.77644C9.37088 3.77644 9.50387 3.88844 9.50387 4.04384C9.50387 4.17404 9.43946 4.28184 9.19034 4.40784L9.04892 4.47644C8.7423 4.63184 8.52946 4.80964 8.4063 5.01124C8.28311 5.21284 8.2229 5.46624 8.2229 5.77284V5.85684H10.0317V5.36124Z"
                      fill="white"></path>
                      <path
                        d="M9.41992 14.078C9.41992 11.5754 11.4556 9.5437 13.9705 9.5437C16.482 9.5437 18.521 11.5721 18.521 14.078C18.521 16.5806 16.4855 18.6123 13.9705 18.6123C11.4589 18.6123 9.41992 16.5806 9.41992 14.078Z"
                      fill="url(#paint0_linear_1464_2098)"></path>
                      <path
                        d="M25.0257 8.64232L18.2708 10.6168C18.2708 10.6168 17.2514 9.12663 15.0605 8.64232C16.9104 8.63219 25.0291 8.64232 25.0291 8.64232C25.0291 8.64232 28.0705 13.6743 24.6746 20.1124Z"
                      fill="#EACA05"></path>
                      <path
                        d="M8.70405 15.5379C7.75536 13.8998 3.85303 7.18579 3.85303 7.18579L8.8559 12.117C8.8559 12.117 8.34273 13.1699 8.53523 14.6768L8.70395 15.5379H8.70405Z"
                      fill="#DF3A32"></path>
                      <defs>
                        <linearGradient
                          id="paint0_linear_1464_2098"
                          x1="13.9703"
                          y1="9.60773"
                          x2="13.9703"
                          y2="18.3394"
                        gradientUnits="userSpaceOnUse">
                          <stop stop-color="#86BBE5"></stop>
                          <stop offset="1" stop-color="#1072BA"></stop>
                        </linearGradient>
                      </defs>
                    </svg>
                  </div>
                  <div class="text-sm text-gray-400">Product hunt</div>
                </div>
              </div>

              <div class="flex flex-col items-center">
                <span class="text-3xl font-bold text-white">4.8</span>
                <div class="flex my-2">
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                </div>
                <div class="flex items-center">
                  <div
                  class="w-6 h-6 rounded-full bg-[#FF492C] flex items-center justify-center mr-2">
                    <svg viewBox="0 0 14 14" fill="none" class="w-4 h-4">
                      <path
                        d="M10.0317 5.36124H8.83608C8.86828 5.17364 8.98451 5.06864 9.2197 4.94964L9.43946 4.83764C9.83294 4.63604 10.0429 4.40784 10.0429 4.03544C10.0429 3.80164 9.95191 3.61684 9.77127 3.48384C9.59073 3.35084 9.37789 3.28504 9.12868 3.28504C8.93592 3.28277 8.74666 3.33678 8.58412 3.44044C8.4203 3.54124 8.2985 3.67144 8.2229 3.83384L8.56868 4.18104C8.70309 3.90944 8.89774 3.77644 9.15387 3.77644C9.37088 3.77644 9.50387 3.88844 9.50387 4.04384C9.50387 4.17404 9.43946 4.28184 9.19034 4.40784L9.04892 4.47644C8.7423 4.63184 8.52946 4.80964 8.4063 5.01124C8.28311 5.21284 8.2229 5.46624 8.2229 5.77284V5.85684H10.0317V5.36124Z"
                      fill="white"></path>
                      <path
                        d="M9.41992 14.078C9.41992 11.5754 11.4556 9.5437 13.9705 9.5437C16.482 9.5437 18.521 11.5721 18.521 14.078C18.521 16.5806 16.4855 18.6123 13.9705 18.6123C11.4589 18.6123 9.41992 16.5806 9.41992 14.078Z"
                      fill="url(#paint0_linear_1464_2098)"></path>
                      <path
                        d="M25.0257 8.64232L18.2708 10.6168C18.2708 10.6168 17.2514 9.12663 15.0605 8.64232C16.9104 8.63219 25.0291 8.64232 25.0291 8.64232C25.0291 8.64232 28.0705 13.6743 24.6746 20.1124Z"
                      fill="#EACA05"></path>
                      <path
                        d="M8.70405 15.5379C7.75536 13.8998 3.85303 7.18579 3.85303 7.18579L8.8559 12.117C8.8559 12.117 8.34273 13.1699 8.53523 14.6768L8.70395 15.5379H8.70405Z"
                      fill="#DF3A32"></path>
                      <defs>
                        <linearGradient
                          id="paint0_linear_1464_2098"
                          x1="13.9703"
                          y1="9.60773"
                          x2="13.9703"
                          y2="18.3394"
                        gradientUnits="userSpaceOnUse">
                          <stop stop-color="#86BBE5"></stop>
                          <stop offset="1" stop-color="#1072BA"></stop>
                        </linearGradient>
                      </defs>
                    </svg>
                  </div>
                  <div class="text-sm text-gray-400">Chrome store</div>
                </div>
              </div>

              <div class="flex flex-col items-center">
                <span class="text-3xl font-bold text-white">4.5</span>
                <div class="flex my-2">
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                  <svg
                    height="24"
                    viewBox="0 -960 960 960"
                    width="24"
                  class="text-yellow-400 fill-current">
                    <path
                    d="M233-80 65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Z"></path>
                  </svg>
                </div>
                <div class="flex items-center">
                  <div
                  class="w-6 h-6 rounded-full bg-[#FF492C] flex items-center justify-center mr-2">
                    <svg viewBox="0 0 14 14" fill="none" class="w-4 h-4">
                      <path
                        d="M10.0317 5.36124H8.83608C8.86828 5.17364 8.98451 5.06864 9.2197 4.94964L9.43946 4.83764C9.83294 4.63604 10.0429 4.40784 10.0429 4.03544C10.0429 3.80164 9.95191 3.61684 9.77127 3.48384C9.59073 3.35084 9.37789 3.28504 9.12868 3.28504C8.93592 3.28277 8.74666 3.33678 8.58412 3.44044C8.4203 3.54124 8.2985 3.67144 8.2229 3.83384L8.56868 4.18104C8.70309 3.90944 8.89774 3.77644 9.15387 3.77644C9.37088 3.77644 9.50387 3.88844 9.50387 4.04384C9.50387 4.17404 9.43946 4.28184 9.19034 4.40784L9.04892 4.47644C8.7423 4.63184 8.52946 4.80964 8.4063 5.01124C8.28311 5.21284 8.2229 5.46624 8.2229 5.77284V5.85684H10.0317V5.36124Z"
                      fill="white"></path>
                      <path
                        d="M9.41992 14.078C9.41992 11.5754 11.4556 9.5437 13.9705 9.5437C16.482 9.5437 18.521 11.5721 18.521 14.078C18.521 16.5806 16.4855 18.6123 13.9705 18.6123C11.4589 18.6123 9.41992 16.5806 9.41992 14.078Z"
                      fill="url(#paint0_linear_1464_2098)"></path>
                      <path
                        d="M25.0257 8.64232L18.2708 10.6168C18.2708 10.6168 17.2514 9.12663 15.0605 8.64232C16.9104 8.63219 25.0291 8.64232 25.0291 8.64232C25.0291 8.64232 28.0705 13.6743 24.6746 20.1124Z"
                      fill="#EACA05"></path>
                      <path
                        d="M8.70405 15.5379C7.75536 13.8998 3.85303 7.18579 3.85303 7.18579L8.8559 12.117C8.8559 12.117 8.34273 13.1699 8.53523 14.6768L8.70395 15.5379H8.70405Z"
                      fill="#DF3A32"></path>
                      <defs>
                        <linearGradient
                          id="paint0_linear_1464_2098"
                          x1="13.9703"
                          y1="9.60773"
                          x2="13.9703"
                          y2="18.3394"
                        gradientUnits="userSpaceOnUse">
                          <stop stop-color="#86BBE5"></stop>
                          <stop offset="1" stop-color="#1072BA"></stop>
                        </linearGradient>
                      </defs>
                    </svg>
                  </div>
                  <div class="text-sm text-gray-400">G2 review</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button
          id="closeModal"
        class="absolute top-4 right-4 text-gray-300 hover:text-white z-10">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
          stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <header class="navbar-fixed z-50">
      <nav
      class="floating-navbar mx-auto my-4 px-4 py-4 rounded-xl flex justify-between items-center max-w-4xl max-h-16 w-[95%] md:w-auto">
        <div class="flex items-center">
          <div class="flex items-center mr-6">
            <div class="bg-[#FF8A00] p-2 rounded-lg mr-3">
              <svg
                version="1.2"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 207 199"
                width="24"
              height="24">
                <title>logo</title>
                <style>
                  .s0 {
                    fill: #fff;
                  }
                </style>
                <g>
                  <path
                    class="s0"
                  d="M107.5 0.6c-15.5 3.2-20 5-27.9 11.1-10.6 8.2-16.3 21.4-15.3 35.5 0.3 4.4 0.9 8.4 1.4 8.9 0.4 0.4 3.5-0.9 6.9-3.1 12.7-8.1 34.7-11.7 44.9-7.5 10.6 4.4 15.7 15.2 10.4 21.9-4.7 6-13.9 7.8-27 5.2-9.2-1.9-25.6-7.1-34.7-11.2-3.1-1.4-6.6-2.9-7.7-3.4-5.3-2.3-14.8-4.9-22.3-6.1-13.1-2-24.4 1-30.9 8.5-8.9 10-6.2 25.5 6.1 34.7 6.1 4.6 12.9 6.9 23.4 7.6l8.2 0.6v-2.7c0-4.1 3.9-14.8 6.3-17.4 7-7.5 19.9-8.8 38.7-3.8 14.7 3.9 27.5 4.5 35.4 1.7 3.3-1.1 7.8-3.3 10-4.8 7.5-5.1 16.3-14.9 19.8-22 3-6.1 3.3-7.6 3.3-15.8 0-8.3-0.3-9.6-3.4-15.9-4.5-9.2-9-13.9-16.6-17.5-8.6-4.1-21.3-6-29-4.5z" />
                  <path
                    class="s0"
                  d="M167.2 35.7c-6.8 3.3-10.8 13-12.4 30.3-0.5 6.3-2 14.6-3.1 18.5-1.8 5.9-3.1 8-8.2 13.1-11.5 11.8-23.7 13.6-53 7.9-36.7-7.1-64.3 1.9-75.3 24.4-3.6 7.5-3.7 7.7-3.6 19.6 0 11.1 0.3 12.6 3.1 19.2 8.1 19 23.6 30.3 41.8 30.3 23.4-0.1 47.1-14.9 68.5-43 10.6-13.9 25.4-27.1 37-33l4.1-2.1-0.7 2.8c-1.3 5.3-6.9 15.8-11.4 21.5-7.2 9-16.6 15.8-27.7 19.9-2.9 1.1-5.3 2.4-5.3 2.9 0 1.7 9.6 11.3 14.9 14.9 22.3 15.2 44 6.3 62-25.4 6.6-11.5 10.8-33.7 8.2-43.1-5.7-21-31.2-16.6-63.5 11-4.5 3.8-13.7 12.4-20.6 19.2-14.2 14-17.5 16.7-23.7 19-12.1 4.7-31-3.1-36.9-15.3-2.4-4.8-2.6-5.8-1.5-9.2 3.1-10.6 8.5-12.6 36.1-13.4 22.8-0.7 30-2 39.2-6.9 11.7-6.2 19.9-17.2 24.3-32.8l2.2-7.4 2.1 5.5c1.1 3.1 2.6 8.4 3.3 11.8l1.3 6.2 4.5-0.7c22.3-3.4 32.6-27.6 21.6-50.8-2.8-6-9.6-13.3-14.2-15.2-4.3-1.8-9-1.7-13.1 0.3z" />
                </g>
              </svg>
            </div>
            <span class="text-xl font-bold">Skillsy</span>
          </div>
        </div>

        <div class="hidden md:flex justify-center flex-1 space-x-8">
          <a
            href="#features"
          class="text-gray-300 hover:text-white transition-colors">Features</a>
          <a
            href="#how-it-works"
          class="text-gray-300 hover:text-white transition-colors">How It Works</a>
          <a
            href="#challenges"
          class="text-gray-300 hover:text-white transition-colors">Challenges</a>
          <a
            href="#testimonials"
          class="text-gray-300 hover:text-white transition-colors">Testimonials</a>
        </div>

        <div class="hidden md:flex items-center space-x-2">
          <?php if ($isLoggedIn): ?>
            <!-- User Profile -->
            <div class="dropdown relative">
            <div
              class="flex items-center gap-2 cursor-pointer"
              id="profileDropdown"
            >
              <img
                src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                alt="Profile"
                class="w-8 h-8 rounded-full object-cover"
              />
              <!-- Username -->
              <span class="font-medium hidden md:inline"><?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></span>
              <svg
                class="w-4 h-4 text-gray-400 hidden md:inline"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7" />
              </svg>
            </div>



            <!-- Dropdown menu -->
            <div class="dropdown-menu " id="profileMenu">
              <div class="dropdown-item">
                <img
                  src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                  alt="Profile"
                  class="w-8 h-8 rounded-full object-cover mr-3"
                />
                <div>
                  <p class="font-medium"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></p>
                  <p class="text-sm text-gray-400">@<?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
              </div>

              <div class="dropdown-divider"></div>

              <div class="dropdown-item">
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>My Profile</span>
              </div>

              <div class="dropdown-item">
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Profile</span>
              </div>

              <div class="dropdown-item">
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Settings</span>
              </div>

              <div class="dropdown-divider"></div>

              <div class="dropdown-item">
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <a href="php/logout.php">Log Out</a>
              </div>
            </div>
          <?php else: ?>
            <a
              href="#"
              class="text-gray-300 hover:text-white border px-4 py-2 rounded-full transition-colors"
            id="loginButton">Log In</a>
            <a
              href="#"
              class="cta-button px-4 py-2 rounded-full font-medium text-black"
            id="signUpButtonNav">Sign Up Free</a>
          <?php endif; ?>
        </div>

        <!-- Mobile Menu Button -->
        <button
          class="md:hidden p-2 rounded-lg hover:bg-gray-800 focus:outline-none"
        id="mobileMenuButton">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-white"
            fill="none"
            viewBox="0 0 24 24"
          stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </nav>

      <div
        class="md:hidden hidden bg-[#121212] z-50 fixed top-[80px] left-0 right-0 p-4 my-5 rounded-lg shadow-xl w-[95%] mx-auto"
      id="mobileMenu">
        <nav
        class="flex flex-col space-y-4 px-2 py-3 border-b border-gray-700 mb-4">
          <a
            href="#features"
          class="text-gray-300 hover:text-white transition-colors py-2">Features</a>
          <a
            href="#how-it-works"
          class="text-gray-300 hover:text-white transition-colors py-2">How It Works</a>
          <a
            href="#challenges"
          class="text-gray-300 hover:text-white transition-colors py-2">Challenges</a>
          <a
            href="#footer"
          class="text-gray-300 hover:text-white transition-colors py-2">Testimonials</a>
        </nav>
        <div class="flex flex-col space-y-3">
          <?php if ($isLoggedIn): ?>
            <!-- Mobile User Profile -->
            <div class="flex items-center space-x-2 p-2">
              <img
                src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                alt="Profile"
                class="w-8 h-8 rounded-full object-cover"
              />
              <div>
                <p class="font-medium text-white"><?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="text-sm text-gray-400">@<?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></p>
              </div>
            </div>
            <a
              href="php/logout.php"
              class="text-center text-gray-300 hover:text-white border border-gray-700 px-4 py-2 rounded-full transition-colors"
            >Log Out</a>
          <?php else: ?>
            <a
              href="#"
              class="text-center text-gray-300 hover:text-white border border-gray-700 px-4 py-2 rounded-full transition-colors"
            id="loginButtonMobile">Log In</a>
            <a
              href="#"
              class="text-center cta-button px-4 py-2 rounded-full font-medium text-black"
            id="signUpButtonMobile">Sign Up Free</a>
          <?php endif; ?>
        </div>
      </div>
    </header>

    <!-- Theme -->
    <div role="radiogroup" class="theme-switcher fixed bottom-6 right-6 z-50">
      <button
        type="button"
        role="radio"
        data-theme-switcher="light"
        data-active="false"
        class="theme-switcher_switch"
        aria-label="Switch to light theme"
        aria-checked="false"
      id="lightTheme">
        <svg
          style="color: currentcolor; width: 16px; height: 16px"
          width="24"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke-linejoin="round"
          stroke-linecap="round"
          stroke="currentColor"
          shape-rendering="geometricPrecision"
          height="24"
          fill="none"
          data-testid="geist-icon"
        class="icon">
          <circle r="5" cy="12" cx="12"></circle>
          <path d="M12 1v2"></path>
          <path d="M12 21v2"></path>
          <path d="M4.22 4.22l1.42 1.42"></path>
          <path d="M18.36 18.36l1.42 1.42"></path>
          <path d="M1 12h2"></path>
          <path d="M21 12h2"></path>
          <path d="M4.22 19.78l1.42-1.42"></path>
          <path d="M18.36 5.64l1.42-1.42"></path>
        </svg>
      </button>
      <button
        type="button"
        role="radio"
        data-theme-switcher="system"
        data-active="false"
        class="theme-switcher_switch"
        aria-label="Switch to system theme"
        aria-checked="false"
      id="systemTheme">
        <svg
          style="color: currentcolor; width: 16px; height: 16px"
          width="24"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke-linejoin="round"
          stroke-linecap="round"
          stroke="currentColor"
          shape-rendering="geometricPrecision"
          height="24"
          fill="none"
          data-testid="geist-icon"
        class="icon">
          <rect ry="2" rx="2" height="14" width="20" y="3" x="2"></rect>
          <path d="M8 21h8"></path>
          <path d="M12 17v4"></path>
        </svg>
      </button>
      <button
        type="button"
        role="radio"
        data-theme-switcher="dark"
        data-active="true"
        class="theme-switcher_switch"
        aria-label="Switch to dark theme"
        aria-checked="true"
      id="darkTheme">
        <svg
          style="color: currentcolor; width: 16px; height: 16px"
          width="24"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke-linejoin="round"
          stroke-linecap="round"
          stroke="currentColor"
          shape-rendering="geometricPrecision"
          height="24"
          fill="none"
          data-testid="geist-icon"
        class="icon">
          <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
        </svg>
      </button>
    </div>

    <main class="pt-28">
      <section class="hero-background-gradient text-center py-20 md:py-32">
        <div class="container mx-auto px-4">
          <div class="flex justify-center items-center space-x-2 mb-6">
            <div class="flex -space-x-2">
              <img
                src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg?t=st=1745619838~exp=1745623438~hmac=6573ade3246308882af3efdb32bfb286d334bd0a2ba6a6dbdaac7802457fb6a6&w=900"
                alt="User"
              class="w-6 h-6 rounded-full border-2 border-[#1C1C1E]" />
              <img
                src="https://img.freepik.com/free-vector/young-man-with-glasses-illustration_1308-174706.jpg?ga=GA1.1.2100041012.1745485540&semt=ais_hybrid&w=740"
                alt="User"
              class="w-6 h-6 rounded-full border-2 border-[#1C1C1E]" />
              <img
                src="https://img.freepik.com/premium-psd/smiling-3d-cartoon-man-avatar_975163-755.jpg?ga=GA1.1.2100041012.1745485540&semt=ais_hybrid&w=740"
                alt="User"
              class="w-6 h-6 rounded-full border-2 border-[#1C1C1E]" />
            </div>
          <span class="text-sm text-gray-400">Supporting over 100,000+ developers worldwide</span>
          </div>
          <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
            Unlock Skill Growth<br />with the Best Exchange Matches
          </h1>
          <p class="max-w-2xl mx-auto text-lg text-gray-400 mb-10">
            Explore real-world skill trades and learning experiences from real
            users worldwide.
          </p>
          <div class="flex justify-center space-x-4">
            <button class="star-btn">
              Try it free
              <div class="star-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  xml:space="preserve"
                  version="1.1"
                  style="
                    shape-rendering: geometricPrecision;
                    text-rendering: geometricPrecision;
                    image-rendering: optimizeQuality;
                    fill-rule: evenodd;
                    clip-rule: evenodd;
                  "
                  viewBox="0 0 784.11 815.53"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                  <defs></defs>
                  <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                      class="fil0"
                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                  </g>
                </svg>
              </div>
              <div class="star-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  xml:space="preserve"
                  version="1.1"
                  style="
                    shape-rendering: geometricPrecision;
                    text-rendering: geometricPrecision;
                    image-rendering: optimizeQuality;
                    fill-rule: evenodd;
                    clip-rule: evenodd;
                  "
                  viewBox="0 0 784.11 815.53"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                  <defs></defs>
                  <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                      class="fil0"
                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                  </g>
                </svg>
              </div>
              <div class="star-3">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  xml:space="preserve"
                  version="1.1"
                  style="
                    shape-rendering: geometricPrecision;
                    text-rendering: geometricPrecision;
                    image-rendering: optimizeQuality;
                    fill-rule: evenodd;
                    clip-rule: evenodd;
                  "
                  viewBox="0 0 784.11 815.53"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                  <defs></defs>
                  <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                      class="fil0"
                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                  </g>
                </svg>
              </div>
              <div class="star-4">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  xml:space="preserve"
                  version="1.1"
                  style="
                    shape-rendering: geometricPrecision;
                    text-rendering: geometricPrecision;
                    image-rendering: optimizeQuality;
                    fill-rule: evenodd;
                    clip-rule: evenodd;
                  "
                  viewBox="0 0 784.11 815.53"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                  <defs></defs>
                  <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                      class="fil0"
                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                  </g>
                </svg>
              </div>
              <div class="star-5">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  xml:space="preserve"
                  version="1.1"
                  style="
                    shape-rendering: geometricPrecision;
                    text-rendering: geometricPrecision;
                    image-rendering: optimizeQuality;
                    fill-rule: evenodd;
                    clip-rule: evenodd;
                  "
                  viewBox="0 0 784.11 815.53"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                  <defs></defs>
                  <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                      class="fil0"
                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                  </g>
                </svg>
              </div>
              <div class="star-6">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  xml:space="preserve"
                  version="1.1"
                  style="
                    shape-rendering: geometricPrecision;
                    text-rendering: geometricPrecision;
                    image-rendering: optimizeQuality;
                    fill-rule: evenodd;
                    clip-rule: evenodd;
                  "
                  viewBox="0 0 784.11 815.53"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                  <defs></defs>
                  <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                      class="fil0"
                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                  </g>
                </svg>
              </div>
            </button>
            <button
            class="bg-[#2C2C2E] text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-[#3A3A3C] transition-colors">
              Explore Flows
            </button>
          </div>
        </div>
        <div
        class="relative h-[600px] mb-24 container mx-auto flex justify-center items-center hidden md:flex">
          <!-- Mobile preview -->
          <div
          class="hidden md:block absolute top-100 transform translate-x-[300px] w-1/4 h-5/6 mobile-preview shadow-2xl z-10">
            <div class="mobile-notch"></div>
            <div class="flex items-center justify-center h-full">
              <div class="text-2xl font-bold">Hello, Jane!</div>
            </div>
          </div>

          <div
            class="absolute bottom-0 w-full md:w-4/5 bg-[#1e1e2e] rounded-lg overflow-hidden shadow-2xl"
          style="transform: translateY(200px)">
            <div
            class="p-0 h-full transform flex items-center justify-center bg-[#0A0A0B]">
              <img
                src="assets/WhatsApp Image 2025-04-26 at 02.54.18.jpeg"
                alt="Skillsy Social Feed"
              class="object-cover w-full h-full opacity-80" />
            </div>
          </div>
        </div>
      </section>

      <!-- Logo carousel -->
      <div class="logos-marquee max-w-6xl mx-auto my-12">
        <h2 class="text-center text-white text-2xl font-medium mb-12">
          Trusted by the world leaders
        </h2>
        <div class="home-logo-wrapper">
          <div class="clients-grid logo-animate">
            <img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542556_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac48-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542559_deloitte.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac49-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542554_Amazon%20logo.svg"
              loading="eager"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542555_Frame%2018610.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac4b-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542558_Frame%2018611.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac4c-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542557_Frame%2018612.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac4d-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255a_EY.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac4e-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255d_toyota.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac4f-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255c_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac50-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255b_airbus.svg"
              loading="eager"
              alt=""
            class="client-logo" />
          </div>
          <div class="clients-grid logo-animate">
            <img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542556_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac53-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542559_deloitte.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac54-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542554_Amazon%20logo.svg"
              loading="eager"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542555_Frame%2018610.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac56-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542558_Frame%2018611.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac57-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542557_Frame%2018612.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac58-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255a_EY.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac59-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255d_toyota.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac5a-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255c_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac5b-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255b_airbus.svg"
              loading="eager"
              alt=""
            class="client-logo" />
          </div>
          <div class="clients-grid logo-animate">
            <img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542556_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac5e-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542559_deloitte.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac5f-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542554_Amazon%20logo.svg"
              loading="eager"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542555_Frame%2018610.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac61-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542558_Frame%2018611.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac62-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542557_Frame%2018612.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac63-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255a_EY.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac64-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255d_toyota.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac65-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255c_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac66-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255b_airbus.svg"
              loading="eager"
              alt=""
            class="client-logo" />
          </div>
          <div class="home-logo-left-gradient"></div>
          <div class="home-logo-left-gradient right"></div>
        </div>
        <div class="home-logo-wrapper reverse">
          <div class="clients-grid logo-animate-alt">
            <img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542556_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac6c-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542559_deloitte.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac6d-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542554_Amazon%20logo.svg"
              loading="eager"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542555_Frame%2018610.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac6f-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542558_Frame%2018611.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac70-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542557_Frame%2018612.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac71-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255a_EY.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac72-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255d_toyota.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac73-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255c_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac74-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255b_airbus.svg"
              loading="eager"
              alt=""
            class="client-logo" />
          </div>
          <div class="clients-grid logo-animate-alt">
            <img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542556_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac77-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542559_deloitte.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac78-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542554_Amazon%20logo.svg"
              loading="eager"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542555_Frame%2018610.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac7a-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542558_Frame%2018611.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac7b-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542557_Frame%2018612.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac7c-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255a_EY.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac7d-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255d_toyota.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac7e-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255c_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac7f-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255b_airbus.svg"
              loading="eager"
              alt=""
            class="client-logo" />
          </div>
          <div class="clients-grid logo-animate-alt">
            <img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542556_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac82-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542559_deloitte.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac83-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542554_Amazon%20logo.svg"
              loading="eager"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542555_Frame%2018610.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac85-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542558_Frame%2018611.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac86-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f542557_Frame%2018612.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac87-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255a_EY.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac88-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255d_toyota.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac89-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255c_Frame%2018608.svg"
              loading="eager"
              id="w-node-_672280b4-ff28-8ac3-f54a-c76ee9bfac8a-09ede84c"
              alt=""
            class="client-logo" /><img
              src="https://cdn.prod.website-files.com/65aebad6eb424b0209ede842/65afaf92263c2c5d3f54255b_airbus.svg"
              loading="eager"
              alt=""
            class="client-logo" />
          </div>
          <div class="home-logo-left-gradient"></div>
          <div class="home-logo-left-gradient right"></div>
        </div>
      </div>

      <!-- Features -->

      <section id="features" class="py-20">
        <div class="container mx-auto px-4">
          <div class="text-center mb-16">
            <div class="badge inline-block mb-4">✨ Platform Features</div>
            <h2 class="text-3xl md:text-5xl font-bold mb-6">
              Everything you need to grow as a developer
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
              Skillsy provides the tools, community, and resources to accelerate
              your development journey
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- 1 -->
            <div class="glass-card p-8 rounded-xl">
              <div class="feature-icon mb-6">
                <i class="fas fa-users text-2xl text-[#6E0FF5]"></i>
              </div>
              <h3 class="text-2xl font-bold mb-4">Developer Community</h3>
              <p class="text-gray-300 mb-6">
                Connect with thousands of developers from around the world.
                Build your network and find collaborators with complementary
                skills.
              </p>
              <a href="#" class="text-[#FF8A00] font-medium flex items-center">
                Explore Community
                <svg
                  class="w-4 h-4 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </a>
            </div>

            <!-- 2 -->
            <div class="glass-card p-8 rounded-xl">
              <div class="feature-icon mb-6">
                <i class="fas fa-code text-2xl text-[#6E0FF5]"></i>
              </div>
              <h3 class="text-2xl font-bold mb-4">Skill Exchange</h3>
              <p class="text-gray-300 mb-6">
                Teach what you know, learn what you don't. Our platform
                facilitates knowledge sharing through interactive sessions and
                resources.
              </p>
              <a href="#" class="text-[#FF8A00] font-medium flex items-center">
                Start Exchanging
                <svg
                  class="w-4 h-4 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </a>
            </div>

            <!-- 3 -->
            <div class="glass-card p-8 rounded-xl">
              <div class="feature-icon mb-6">
                <i class="fas fa-trophy text-2xl text-[#6E0FF5]"></i>
              </div>
              <h3 class="text-2xl font-bold mb-4">Coding Challenges</h3>
              <p class="text-gray-300 mb-6">
                Put your skills to the test with our weekly coding challenges.
                Solve problems, compare solutions, and learn new approaches.
              </p>
              <a href="#" class="text-[#FF8A00] font-medium flex items-center">
                Try Challenges
                <svg
                  class="w-4 h-4 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </a>
            </div>

            <!-- 4 -->
            <div class="glass-card p-8 rounded-xl">
              <div class="feature-icon mb-6">
                <i class="fas fa-project-diagram text-2xl text-[#6E0FF5]"></i>
              </div>
              <h3 class="text-2xl font-bold mb-4">Collaborative Projects</h3>
              <p class="text-gray-300 mb-6">
                Find teammates for side projects or join existing ones. Build
                your portfolio while gaining real-world collaboration
                experience.
              </p>
              <a href="#" class="text-[#FF8A00] font-medium flex items-center">
                Explore Projects
                <svg
                  class="w-4 h-4 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </a>
            </div>

            <!-- 5 -->
            <div class="glass-card p-8 rounded-xl">
              <div class="feature-icon mb-6">
                <i class="fas fa-comments text-2xl text-[#6E0FF5]"></i>
              </div>
              <h3 class="text-2xl font-bold mb-4">Mentorship Network</h3>
              <p class="text-gray-300 mb-6">
                Connect with mentors who can guide your development journey or
                become a mentor to help others grow and expand your leadership
                skills.
              </p>
              <a href="#" class="text-[#FF8A00] font-medium flex items-center">
                Find a Mentor
                <svg
                  class="w-4 h-4 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </a>
            </div>

            <!-- 6 -->
            <div class="glass-card p-8 rounded-xl">
              <div class="feature-icon mb-6">
                <i class="fas fa-chart-line text-2xl text-[#6E0FF5]"></i>
              </div>
              <h3 class="text-2xl font-bold mb-4">Growth Analytics</h3>
              <p class="text-gray-300 mb-6">
                Track your progress, identify skill gaps, and get personalized
                recommendations to accelerate your growth as a developer.
              </p>
              <a href="#" class="text-[#FF8A00] font-medium flex items-center">
                View Analytics
                <svg
                  class="w-4 h-4 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </section>

      <section id="how-it-works" class="py-20">
        <div class="container mx-auto px-4">
          <div class="text-center mb-16">
            <div class="badge inline-block mb-4">🔄 How It Works</div>
            <h2 class="text-3xl md:text-5xl font-bold mb-6">
              Your journey on Skillsy
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
              From creating your profile to collaborating on projects, here's
              how to make the most of the platform
            </p>
          </div>

          <div class="flex flex-col lg:flex-row items-center justify-between">
            <div class="lg:w-2/5 mb-10 lg:mb-0 order-2 lg:order-1">
              <div class="space-y-12">
                <div class="flex">
                  <div class="flex-shrink-0 mr-6">
                    <div
                    class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-indigo-600 to-pink-500 text-white text-xl font-bold">
                      1
                    </div>
                  </div>
                  <div>
                    <h3 class="text-2xl font-bold mb-2">
                      Create your developer profile
                    </h3>
                    <p class="text-gray-300">
                      Sign up and showcase your skills, projects, and interests.
                      Customize your profile to reflect your unique development
                      journey.
                    </p>
                  </div>
                </div>

                <div class="flex">
                  <div class="flex-shrink-0 mr-6">
                    <div
                    class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-indigo-600 to-pink-500 text-white text-xl font-bold">
                      2
                    </div>
                  </div>
                  <div>
                    <h3 class="text-2xl font-bold mb-2">
                      Connect with developers
                    </h3>
                    <p class="text-gray-300">
                      Find and connect with developers who share your interests
                      or have skills you want to learn. Build your network of
                      collaborators.
                    </p>
                  </div>
                </div>

                <div class="flex">
                  <div class="flex-shrink-0 mr-6">
                    <div
                    class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-indigo-600 to-pink-500 text-white text-xl font-bold">
                      3
                    </div>
                  </div>
                  <div>
                    <h3 class="text-2xl font-bold mb-2">Exchange skills</h3>
                    <p class="text-gray-300">
                      Share your knowledge in areas you excel and learn from
                      others in areas you want to improve. Schedule learning
                      sessions or join workshops.
                    </p>
                  </div>
                </div>

                <div class="flex">
                  <div class="flex-shrink-0 mr-6">
                    <div
                    class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-indigo-600 to-pink-500 text-white text-xl font-bold">
                      4
                    </div>
                  </div>
                  <div>
                    <h3 class="text-2xl font-bold mb-2">Grow together</h3>
                    <p class="text-gray-300">
                      Collaborate on projects, participate in challenges, and
                      track your progress as you level up your skills with the
                      community.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="lg:w-1/2 order-1 lg:order-2 mb-10 lg:mb-0">
              <div class="card-gradient p-4 rounded-xl shadow-2xl">
                <img
                  src="https://cdn.prod.website-files.com/6652d4aa5b29e1f90dacd957/667b8071f26f3c2e26020c0c_Home%20Hero%20V1-p-1080.webp"
                  alt="Skillsy Interface"
                class="rounded-lg w-full" />
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="challenges" class="py-20">
        <div class="container mx-auto px-4">
          <div class="text-center mb-16">
            <div class="badge inline-block mb-4">🏆 Coding Challenges</div>
            <h2 class="text-3xl md:text-5xl font-bold mb-6">
              Put your skills to the test
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
              Solve real-world coding problems, compete with peers, and learn
              new approaches
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- 1 -->
            <div class="challenge-card glass-card p-6 rounded-xl">
              <div class="flex justify-between items-start mb-4">
                <span
                class="px-3 py-1 bg-green-500/20 text-[#FF8A00] rounded-full text-sm font-medium">Beginner</span>
                <span class="text-gray-400">
                  <i class="fas fa-users mr-1"></i> 254
                </span>
              </div>
              <h3 class="text-xl font-bold mb-2">
                Algorithmic Array Manipulation
              </h3>
              <p class="text-gray-300 mb-4">
                Implement efficient array sorting, filtering, and transformation
                techniques to process data within constraints.
              </p>
              <div class="flex justify-between items-center">
                <div class="flex items-center">
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-gray-600">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-gray-400 ml-2">(4.2)</span>
                </div>
              <a href="#" class="text-[#FF8A00] font-medium">View Challenge</a>
              </div>
            </div>

            <!-- 2 -->
            <div class="challenge-card glass-card p-6 rounded-xl">
              <div class="flex justify-between items-start mb-4">
                <span
                class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm font-medium">Intermediate</span>
                <span class="text-gray-400">
                  <i class="fas fa-users mr-1"></i> 187
                </span>
              </div>
              <h3 class="text-xl font-bold mb-2">
                Build a React Component Library
              </h3>
              <p class="text-gray-300 mb-4">
                Design and implement reusable, accessible, and performant UI
                components with comprehensive documentation.
              </p>
              <div class="flex justify-between items-center">
                <div class="flex items-center">
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-gray-400 ml-2">(4.8)</span>
                </div>
              <a href="#" class="text-[#FF8A00] font-medium">View Challenge</a>
              </div>
            </div>

            <!-- 3 -->
            <div class="challenge-card glass-card p-6 rounded-xl">
              <div class="flex justify-between items-start mb-4">
                <span
                class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm font-medium">Advanced</span>
                <span class="text-gray-400">
                  <i class="fas fa-users mr-1"></i> 126
                </span>
              </div>
              <h3 class="text-xl font-bold mb-2">Distributed Systems Design</h3>
              <p class="text-gray-300 mb-4">
                Create a fault-tolerant, highly available system that can handle
                millions of requests with minimal latency.
              </p>
              <div class="flex justify-between items-center">
                <div class="flex items-center">
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="text-gray-600">
                    <i class="fas fa-star-half-alt"></i>
                  </span>
                  <span class="text-gray-400 ml-2">(4.5)</span>
                </div>
              <a href="#" class="text-[#FF8A00] font-medium">View Challenge</a>
              </div>
            </div>
          </div>

          <div class="mt-12 text-center">
            <a
              href="#"
            class="cta-button inline-block px-8 py-4 rounded-full font-medium text-lg">
              Explore All Challenges
            </a>
          </div>
        </div>
      </section>
    </main>

    <footer
      class="relative z-10 mx-auto max-w-[90%] mb-16 rounded-3xl bg-[#000] shadow-2xl px-6 sm:px-10 py-16 sm:py-20 mt-12"
    style="box-shadow: 0 8px 40px 0 rgba(0, 0, 0, 0.45)">
      <!-- Logo/Status -->
      <div class="flex flex-col space-y-12">
        <div class="flex flex-col-12 justify-between mr-6">
          <div class="flex items-center gap-2 mb-3">
            <div class="bg-[transparent] p-2 rounded-lg">
              <svg
                version="1.2"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 207 199"
                width="48"
              height="48">
                <title>logo</title>
                <style>
                  .s0 {
                    fill: #fff;
                  }
                </style>
                <g>
                  <path
                    class="s0"
                  d="M107.5 0.6c-15.5 3.2-20 5-27.9 11.1-10.6 8.2-16.3 21.4-15.3 35.5 0.3 4.4 0.9 8.4 1.4 8.9 0.4 0.4 3.5-0.9 6.9-3.1 12.7-8.1 34.7-11.7 44.9-7.5 10.6 4.4 15.7 15.2 10.4 21.9-4.7 6-13.9 7.8-27 5.2-9.2-1.9-25.6-7.1-34.7-11.2-3.1-1.4-6.6-2.9-7.7-3.4-5.3-2.3-14.8-4.9-22.3-6.1-13.1-2-24.4 1-30.9 8.5-8.9 10-6.2 25.5 6.1 34.7 6.1 4.6 12.9 6.9 23.4 7.6l8.2 0.6v-2.7c0-4.1 3.9-14.8 6.3-17.4 7-7.5 19.9-8.8 38.7-3.8 14.7 3.9 27.5 4.5 35.4 1.7 3.3-1.1 7.8-3.3 10-4.8 7.5-5.1 16.3-14.9 19.8-22 3-6.1 3.3-7.6 3.3-15.8 0-8.3-0.3-9.6-3.4-15.9-4.5-9.2-9-13.9-16.6-17.5-8.6-4.1-21.3-6-29-4.5z" />
                  <path
                    class="s0"
                  d="M167.2 35.7c-6.8 3.3-10.8 13-12.4 30.3-0.5 6.3-2 14.6-3.1 18.5-1.8 5.9-3.1 8-8.2 13.1-11.5 11.8-23.7 13.6-53 7.9-36.7-7.1-64.3 1.9-75.3 24.4-3.6 7.5-3.7 7.7-3.6 19.6 0 11.1 0.3 12.6 3.1 19.2 8.1 19 23.6 30.3 41.8 30.3 23.4-0.1 47.1-14.9 68.5-43 10.6-13.9 25.4-27.1 37-33l4.1-2.1-0.7 2.8c-1.3 5.3-6.9 15.8-11.4 21.5-7.2 9-16.6 15.8-27.7 19.9-2.9 1.1-5.3 2.4-5.3 2.9 0 1.7 9.6 11.3 14.9 14.9 22.3 15.2 44 6.3 62-25.4 6.6-11.5 10.8-33.7 8.2-43.1-5.7-21-31.2-16.6-63.5 11-4.5 3.8-13.7 12.4-20.6 19.2-14.2 14-17.5 16.7-23.7 19-12.1 4.7-31-3.1-36.9-15.3-2.4-4.8-2.6-5.8-1.5-9.2 3.1-10.6 8.5-12.6 36.1-13.4 22.8-0.7 30-2 39.2-6.9 11.7-6.2 19.9-17.2 24.3-32.8l2.2-7.4 2.1 5.5c1.1 3.1 2.6 8.4 3.3 11.8l1.3 6.2 4.5-0.7c22.3-3.4 32.6-27.6 21.6-50.8-2.8-6-9.6-13.3-14.2-15.2-4.3-1.8-9-1.7-13.1 0.3z" />
                </g>
              </svg>
            </div>
            <span class="text-2xl font-semibold text-white">Skillsy..</span>
          </div>
          <div
          class="text-xs text-gray-400 tracking-widest flex items-center gap-2">
            CURRENT STATUS
            <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
          </div>
        </div>

        <!-- Footer links -->
        <div
        class="hidden md:grid grid-cols-1 pt-10 max-w-[75%] sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
          <div>
            <div class="text-white font-semibold mb-6">Learn</div>
            <ul class="space-y-3 text-gray-400 text-sm">
              <li>
                <a href="#" class="hover:text-gray-300">Developer guides</a>
              </li>
              <li>
                <a href="#" class="hover:text-gray-300">SDK & API reference</a>
              </li>
              <li><a href="#" class="hover:text-gray-300">Samples</a></li>
              <li><a href="#" class="hover:text-gray-300">Libraries</a></li>
              <li><a href="#" class="hover:text-gray-300">GitHub</a></li>
            </ul>
          </div>

          <div>
            <div class="text-white font-semibold mb-6">Stay connected</div>
            <ul class="space-y-3 text-gray-400 text-sm">
              <li>
                <a href="#" class="hover:text-gray-300">Check out the blog</a>
              </li>
              <li>
                <a href="#" class="hover:text-gray-300">Find us on Reddit</a>
              </li>
              <li><a href="#" class="hover:text-gray-300">Follow on X</a></li>
              <li>
                <a href="#" class="hover:text-gray-300">Subscribe on YouTube</a>
              </li>
              <li>
                <a href="#" class="hover:text-gray-300">Attend an event</a>
              </li>
            </ul>
          </div>

          <div>
            <div class="text-white font-semibold mb-6">Support</div>
            <ul class="space-y-3 text-gray-400 text-sm">
              <li>
                <a href="#" class="hover:text-gray-300">Contact support</a>
              </li>
              <li>
                <a href="#" class="hover:text-gray-300">Stack Overflow</a>
              </li>
              <li>
                <a href="#" class="hover:text-gray-300">Slack community</a>
              </li>
              <li><a href="#" class="hover:text-gray-300">Release notes</a></li>
              <li>
                <a href="#" class="hover:text-gray-300">Brand guidelines</a>
              </li>
              <li><a href="#" class="hover:text-gray-300">FAQs</a></li>
            </ul>
          </div>

          <div>
            <div class="text-white font-semibold mb-6">
              Tools for developers
            </div>
            <ul class="space-y-3 text-gray-400 text-sm">
              <li><a href="#" class="hover:text-gray-300">Android</a></li>
              <li><a href="#" class="hover:text-gray-300">Chrome</a></li>
              <li><a href="#" class="hover:text-gray-300">Firebase</a></li>
              <li>
              <a href="#" class="hover:text-gray-300">Google Cloud Platform</a>
              </li>
              <li><a href="#" class="hover:text-gray-300">All products</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div
      class="border-t border-gray-800 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center">
        <div class="text-gray-500 text-sm mb-4 sm:mb-0">
          2024 Skillsy. All rights reserved.
        </div>
        <div class="flex gap-6 text-gray-500 text-sm">
          <a href="#" class="hover:text-gray-300">Terms</a>
          <a href="#" class="hover:text-gray-300">Privacy</a>
          <a href="#" class="underline text-gray-300">Manage Cookies</a>
        </div>
      </div>
    </footer>

    <script src="script.js?v=forcecache"></script>

<?php if ($showLoginModal): ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Check what kind of errors we have
    const hasNameError = <?php echo !empty($errorName) ? 'true' : 'false'; ?>;
    const hasUserNameError = <?php echo !empty($errorUserName) ? 'true' : 'false'; ?>;
    const hasEmailError = <?php echo !empty($errorEmail) ? 'true' : 'false'; ?>;
    const hasPasswordError = <?php echo !empty($errorPswrd) ? 'true' : 'false'; ?>;
    const showStep2 = <?php echo isset($_SESSION['showStep2']) && $_SESSION['showStep2'] ? 'true' : 'false'; ?>;
    const showLoginForm = <?php echo isset($_SESSION['showLoginForm']) && $_SESSION['showLoginForm'] ? 'true' : 'false'; ?>;
    
    // Open the modal
    const loginModal = document.getElementById('login');
    if (loginModal) loginModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Check if we should show login form after successful registration
    if (showLoginForm) {
      // Show login form
      showLoginForm();
    } else {
      // Determine if errors are specifically from signup (name or username errors exist)
      const isSignupError = hasNameError || hasUserNameError || hasEmailError || hasPasswordError;

      if (isSignupError) {
        // It's a signup error
        const signUpToggle = document.getElementById('signUpToggle');
        const loginToggle = document.getElementById('loginToggle');
        const signUpStep1 = document.getElementById('signUpStep1');
        const signUpStep2 = document.getElementById('signUpStep2');
        const loginForm = document.getElementById('loginForm');
        
        // Set active tab styling for signup
        if (signUpToggle && loginToggle) {
          signUpToggle.classList.add('active-tab', 'bg-black');
          signUpToggle.classList.remove('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
          loginToggle.classList.remove('active-tab', 'bg-black');
          loginToggle.classList.add('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
        }
        
        // Hide login form
        if (loginForm) loginForm.classList.add('hidden');
        
        // If error is in step 2, show step 2, otherwise show step 1
        if (showStep2) {
          // Show step 2 (name field error)
          if (signUpStep1) signUpStep1.classList.add('hidden');
          if (signUpStep2) signUpStep2.classList.remove('hidden');
        } else {
          // Show step 1 (username/email/password error)
          if (signUpStep1) signUpStep1.classList.remove('hidden');
          if (signUpStep2) signUpStep2.classList.add('hidden');
        }
      } else {
        // Default to showing the login form
        showLoginForm();
      }
    }
    // Check if we should show forgot password section
    if (<?php echo $showForgotSection ? 'true' : 'false'; ?>) {
      // Hide all modal sections except forgot password
      var loginForm = document.getElementById('loginForm');
      var signUpStep1 = document.getElementById('signUpStep1');
      var signUpStep2 = document.getElementById('signUpStep2');
      var forgotStep = document.getElementById('forgotPasswordStep');
      if (loginForm) loginForm.classList.add('hidden');
      if (signUpStep1) signUpStep1.classList.add('hidden');
      if (signUpStep2) signUpStep2.classList.add('hidden');
      if (forgotStep) forgotStep.classList.remove('hidden');
      // Optionally set tab visual state if you use tabs
      var loginToggle = document.getElementById('loginToggle');
      var signUpToggle = document.getElementById('signUpToggle');
      if (loginToggle) loginToggle.classList.remove('active-tab', 'bg-black');
      if (loginToggle) loginToggle.classList.add('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
      if (signUpToggle) signUpToggle.classList.remove('active-tab', 'bg-black');
      if (signUpToggle) signUpToggle.classList.add('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
      // Focus the forgot email input for better UX
      var forgotEmail = document.getElementById('forgotEmail');
      if (forgotEmail) forgotEmail.focus();
    }
  });
</script>
<?php endif; ?>
<?php if ($showLoginModal): ?>
<script>
window.addEventListener('DOMContentLoaded', function() {
  document.getElementById('login').classList.remove('hidden');
  document.body.style.overflow = 'hidden';
  // Modal section logic based on PHP
  var activeSection = <?php echo json_encode($activeModalSection); ?>;
  var loginForm = document.getElementById('loginForm');
  var signUpStep1 = document.getElementById('signUpStep1');
  var signUpStep2 = document.getElementById('signUpStep2');
  var forgotStep = document.getElementById('forgotPasswordStep');
  var loginToggle = document.getElementById('loginToggle');
  var signUpToggle = document.getElementById('signUpToggle');
  // Hide all
  if (loginForm) loginForm.classList.add('hidden');
  if (signUpStep1) signUpStep1.classList.add('hidden');
  if (signUpStep2) signUpStep2.classList.add('hidden');
  if (forgotStep) forgotStep.classList.add('hidden');
  // Activate correct section
  if (activeSection === 'login') {
    if (loginForm) loginForm.classList.remove('hidden');
    if (loginToggle) {
      loginToggle.classList.add('active-tab', 'bg-black');
      loginToggle.classList.remove('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
    }
    if (signUpToggle) {
      signUpToggle.classList.remove('active-tab', 'bg-black');
      signUpToggle.classList.add('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
    }
  } else if (activeSection === 'signup') {
    if (signUpStep1) signUpStep1.classList.remove('hidden');
    if (signUpToggle) {
      signUpToggle.classList.add('active-tab', 'bg-black');
      signUpToggle.classList.remove('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
    }
    if (loginToggle) {
      loginToggle.classList.remove('active-tab', 'bg-black');
      loginToggle.classList.add('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
    }
  }
  // If forgot section, override
  if (<?php echo $showForgotSection ? 'true' : 'false'; ?>) {
    if (loginForm) loginForm.classList.add('hidden');
    if (signUpStep1) signUpStep1.classList.add('hidden');
    if (signUpStep2) signUpStep2.classList.add('hidden');
    if (forgotStep) forgotStep.classList.remove('hidden');
    if (loginToggle) loginToggle.classList.remove('active-tab', 'bg-black');
    if (loginToggle) loginToggle.classList.add('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
    if (signUpToggle) signUpToggle.classList.remove('active-tab', 'bg-black');
    if (signUpToggle) signUpToggle.classList.add('bg-transparent', 'border', 'border-gray-700', 'hover:bg-white/5');
    var forgotEmail = document.getElementById('forgotEmail');
    if (forgotEmail) forgotEmail.focus();
  }
});
</script>
<?php endif; ?>

</body>

</html>