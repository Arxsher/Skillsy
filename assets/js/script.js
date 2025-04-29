document.addEventListener("DOMContentLoaded", function () {
  if (window.location.search.includes('showForgot=1') || window.location.search.match(/showForgot(=|&|$)/)) {
    var loginForm = document.getElementById("loginForm");
    var signUpStep1 = document.getElementById("signUpStep1");
    var signUpStep2 = document.getElementById("signUpStep2");
    var forgotStep = document.getElementById("forgotPasswordStep");
    if (loginForm) loginForm.classList.add("hidden");
    if (signUpStep1) signUpStep1.classList.add("hidden");
    if (signUpStep2) signUpStep2.classList.add("hidden");
    if (forgotStep) forgotStep.classList.remove("hidden");
    var loginToggle = document.getElementById("loginToggle");
    var signUpToggle = document.getElementById("signUpToggle");
    if (loginToggle) loginToggle.classList.remove("active-tab", "bg-black");
    if (loginToggle) loginToggle.classList.add("bg-transparent", "border", "border-gray-700", "hover:bg-white/5");
    if (signUpToggle) signUpToggle.classList.remove("active-tab", "bg-black");
    if (signUpToggle) signUpToggle.classList.add("bg-transparent", "border", "border-gray-700", "hover:bg-white/5");
    var forgotEmail = document.getElementById('forgotEmail');
    if (forgotEmail) forgotEmail.focus();
  }
});

const login = document.getElementById("login");
const signUpToggle = document.getElementById("signUpToggle");
const loginToggle = document.getElementById("loginToggle");
const signUpStep1 = document.getElementById("signUpStep1");
const signUpStep2 = document.getElementById("signUpStep2");
const loginForm = document.getElementById("loginForm");
const closeModal = document.getElementById("closeModal");
const modalOverlay = document.getElementById("modalOverlay");
const signUpButtonNav = document.getElementById("signUpButtonNav");
const loginButton = document.getElementById("loginButton");

if (closeModal) closeModal.addEventListener("click", closeModalFunc);
if (modalOverlay) modalOverlay.addEventListener("click", closeModalFunc);
if (signUpToggle) signUpToggle.addEventListener("click", showSignUpStep1);
if (loginToggle) loginToggle.addEventListener("click", showLoginForm);
if (signUpButtonNav)
  signUpButtonNav.addEventListener("click", function (e) {
    e.preventDefault();
    showSignUpStep1();
  });
if (loginButton)
  loginButton.addEventListener("click", function (e) {
    e.preventDefault();
    showLoginForm();
  });

// escape
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape" && !login.classList.contains("hidden")) {
    closeModalFunc();
  }
});

function closeModalFunc() {
  login.classList.add("hidden");
  document.body.style.overflow = "";
}

function showSignUpStep1() {
  signUpToggle.classList.add("active-tab", "bg-black");
  signUpToggle.classList.remove(
    "bg-transparent",
    "border",
    "border-gray-700",
    "hover:bg-white/5"
  );
  loginToggle.classList.remove("active-tab", "bg-black");
  loginToggle.classList.add(
    "bg-transparent",
    "border",
    "border-gray-700",
    "hover:bg-white/5"
  );

  // Show signup form
  if (signUpStep1) signUpStep1.classList.remove("hidden");
  if (signUpStep2) signUpStep2.classList.add("hidden");
  if (loginForm) loginForm.classList.add("hidden");

  login.classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

function showLoginForm() {
  // Set active tab styling
  loginToggle.classList.add("active-tab", "bg-black");
  loginToggle.classList.remove(
    "bg-transparent",
    "border",
    "border-gray-700",
    "hover:bg-white/5"
  );
  signUpToggle.classList.remove("active-tab", "bg-black");
  signUpToggle.classList.add(
    "bg-transparent",
    "border",
    "border-gray-700",
    "hover:bg-white/5"
  );

  // Show login form
  if (signUpStep1) signUpStep1.classList.add("hidden");
  if (signUpStep2) signUpStep2.classList.add("hidden");
  if (loginForm) loginForm.classList.remove("hidden");

  login.classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

if (document.getElementById("nextButton")) {
  document.getElementById("nextButton").addEventListener("click", function () {
    if (signUpStep1) signUpStep1.classList.add("hidden");
    if (signUpStep2) signUpStep2.classList.remove("hidden");
  });
}

if (document.getElementById("backToStep1")) {
  document.getElementById("backToStep1").addEventListener("click", function () {
    if (signUpStep1) signUpStep1.classList.remove("hidden");
    if (signUpStep2) signUpStep2.classList.add("hidden");
  });
}

// Navbar
(function () {
  const header = document.querySelector(".navbar-fixed");
  let lastScrollTop = 0;
  let isScrolling;

  window.addEventListener("scroll", function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop <= 10) {
      header.classList.remove("navbar-hidden");
      return;
    }

    if (scrollTop > lastScrollTop) {
      header.classList.add("navbar-hidden");
    } else {
      header.classList.remove("navbar-hidden");
    }

    lastScrollTop = scrollTop;

    clearTimeout(isScrolling);

    isScrolling = setTimeout(function () {
      header.classList.remove("navbar-hidden");
    }, 500);
  });
})();

document.querySelectorAll(".password-toggle-icon").forEach((toggle) => {
  toggle.addEventListener("click", function () {
    const targetId = this.getAttribute("data-target");
    const passwordInput = document.getElementById(targetId);

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      this.classList.add("show");
    } else {
      passwordInput.type = "password";
      this.classList.remove("show");
    }
  });
});

// theme toggle
document.addEventListener("DOMContentLoaded", function () {
  // Get theme switcher elements
  const lightThemeButton = document.getElementById("lightTheme");
  const systemThemeButton = document.getElementById("systemTheme");
  const darkThemeButton = document.getElementById("darkTheme");

  if (lightThemeButton && darkThemeButton) {
    // theme to dark
    document.documentElement.setAttribute("data-theme", "dark");
    darkThemeButton.setAttribute("data-active", "true");
    darkThemeButton.setAttribute("aria-checked", "true");

    // theme toggle
    lightThemeButton.addEventListener("click", function () {
      document.documentElement.setAttribute("data-theme", "light");
      lightThemeButton.setAttribute("data-active", "true");
      lightThemeButton.setAttribute("aria-checked", "true");
      darkThemeButton.setAttribute("data-active", "false");
      darkThemeButton.setAttribute("aria-checked", "false");
      systemThemeButton.setAttribute("data-active", "false");
      systemThemeButton.setAttribute("aria-checked", "false");
    });

    darkThemeButton.addEventListener("click", function () {
      document.documentElement.setAttribute("data-theme", "dark");
      darkThemeButton.setAttribute("data-active", "true");
      darkThemeButton.setAttribute("aria-checked", "true");
      lightThemeButton.setAttribute("data-active", "false");
      lightThemeButton.setAttribute("aria-checked", "false");
      systemThemeButton.setAttribute("data-active", "false");
      systemThemeButton.setAttribute("aria-checked", "false");
    });

    // system theme
    if (systemThemeButton) {
      systemThemeButton.addEventListener("click", function () {
        const prefersDarkMode = window.matchMedia(
          "(prefers-color-scheme: dark)"
        ).matches;
        const systemTheme = prefersDarkMode ? "dark" : "light";

        document.documentElement.setAttribute("data-theme", systemTheme);

        systemThemeButton.setAttribute("data-active", "true");
        systemThemeButton.setAttribute("aria-checked", "true");
        lightThemeButton.setAttribute("data-active", "false");
        lightThemeButton.setAttribute("aria-checked", "false");
        darkThemeButton.setAttribute("data-active", "false");
        darkThemeButton.setAttribute("aria-checked", "false");

        // system theme
        window
          .matchMedia("(prefers-color-scheme: dark)")
          .addEventListener("change", (event) => {
            if (systemThemeButton.getAttribute("data-active") === "true") {
              const newTheme = event.matches ? "dark" : "light";
              document.documentElement.setAttribute("data-theme", newTheme);
            }
          });
      });
    }
  }

  // Profile dropdown
  const profileDropdown = document.getElementById("profileDropdown");
  const profileMenu = document.getElementById("profileMenu");

  if (profileDropdown && profileMenu) {
    profileDropdown.addEventListener("click", function () {
      profileMenu.classList.toggle("show");
    });

    // close dropdown outside
    document.addEventListener("click", function (event) {
      if (
        !profileDropdown.contains(event.target) &&
        !profileMenu.contains(event.target)
      ) {
        profileMenu.classList.remove("show");
      }
    });
  }

  // Mobile navigation
  const navButtons = document.querySelectorAll(".mobile-nav-btn");
  navButtons.forEach((button) => {
    button.addEventListener("click", function () {
      navButtons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");
    });
  });

  // Mobile dropdown
  const mobileProfileDropdown = document.getElementById(
    "mobileProfileDropdown"
  );
  if (mobileProfileDropdown && profileMenu) {
    mobileProfileDropdown.addEventListener("click", function () {
      profileMenu.classList.toggle("show");
    });
  }

  // Sidebar
  const hamburgerBtn = document.getElementById("hamburgerBtn");
  const mdSidebar = document.getElementById("mdSidebar");
  const sidebarOverlay = document.getElementById("sidebarOverlay");

  function toggleSidebar() {
    const isOpen = !mdSidebar.classList.contains("-translate-x-full");

    if (isOpen) {
      mdSidebar.classList.add("-translate-x-full");
      sidebarOverlay.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    } else {
      mdSidebar.classList.remove("-translate-x-full");
      sidebarOverlay.classList.remove("hidden");
      document.body.classList.add("overflow-hidden");
    }
  }

  if (hamburgerBtn && mdSidebar && sidebarOverlay) {
    hamburgerBtn.addEventListener("click", toggleSidebar);
    sidebarOverlay.addEventListener("click", toggleSidebar);
  }

  // Handle section toggles
  const sectionHeaders = document.querySelectorAll(".sidebar-section-header");
  sectionHeaders.forEach((header) => {
    header.addEventListener("click", () => {
      const content = header.nextElementSibling;
      if (content) {
        content.classList.toggle("hidden");
        const arrow = header.querySelector("svg");
        if (arrow) arrow.classList.toggle("rotate-180");
      }
    });
  });

  // forgot password
  const showForgotPassword = document.getElementById("showForgotPassword");
  const forgotPasswordStep = document.getElementById("forgotPasswordStep");
  const backToLoginStep = document.getElementById("backToLoginStep");

  if (showForgotPassword && loginForm && forgotPasswordStep) {
    showForgotPassword.addEventListener("click", function (e) {
      e.preventDefault();
      loginForm.classList.add("hidden");
      forgotPasswordStep.classList.remove("hidden");
    });
  }

  if (backToLoginStep && loginForm && forgotPasswordStep) {
    backToLoginStep.addEventListener("click", function () {
      forgotPasswordStep.classList.add("hidden");
      loginForm.classList.remove("hidden");
    });
  }
});

document
  .getElementById("mobileMenuButton")
  .addEventListener("click", function () {
    const mobileMenu = document.getElementById("mobileMenu");
    mobileMenu.classList.toggle("hidden");
  });

// Close mobile menu
document.querySelectorAll("#mobileMenu a").forEach((link) => {
  link.addEventListener("click", function () {
    document.getElementById("mobileMenu").classList.add("hidden");
  });
});

if (document.getElementById("loginButtonMobile")) {
  document
    .getElementById("loginButtonMobile")
    .addEventListener("click", function (e) {
      e.preventDefault();
      showLoginForm();
      document.getElementById("mobileMenu").classList.add("hidden");
    });
}

if (document.getElementById("signUpButtonMobile")) {
  document
    .getElementById("signUpButtonMobile")
    .addEventListener("click", function (e) {
      e.preventDefault();
      showSignUpStep1();
      document.getElementById("mobileMenu").classList.add("hidden");
    });
}
console.log("showForgotPassword", document.getElementById("showForgotPassword"));
console.log("loginForm", document.getElementById("loginForm"));
console.log("forgotPasswordStep", document.getElementById("forgotPasswordStep"));
console.log("backToLoginStep", document.getElementById("backToLoginStep"));
