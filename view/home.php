<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../model/mydb.php';

// Require login for home page
if (!isset($_SESSION['userName'])) {
    header('Location: ../view/index.php');
    exit();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['userName']);
$name = ($isLoggedIn && isset($_SESSION['name']) && !empty(trim($_SESSION['name']))) ? $_SESSION['name'] : '@.';
$userName = ($isLoggedIn && isset($_SESSION['userName']) && !empty(trim($_SESSION['userName']))) ? $_SESSION['userName'] : '@.';

?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skillsy - Social Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/home.css" />
    <link rel="stylesheet" href="../assets/css/test.css" />
  </head>

  <body class="min-h-screen">
    <!-- sidebar -->
    <div
      id="mdSidebar"
      class="fixed top-0 left-0 h-full w-72 bg-[#0a0a0b] z-50 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto"
    >
      <div class="p-6 space-y-6">
        <!-- Header with close button -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="bg-[#FF8A00] p-2 rounded-lg mr-3">
              <svg
                version="1.2"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 207 199"
                width="24"
                height="24"
              >
                <title>logo</title>
                <style>
                  .s0 {
                    fill: #fff;
                  }
                </style>
                <g>
                  <path
                    class="s0"
                    d="m107.5 0.6c-15.5 3.2-20 5-27.9 11.1-10.6 8.2-16.3 21.4-15.3 35.5 0.3 4.4 0.9 8.4 1.4 8.9 0.4 0.4 3.5-0.9 6.9-3.1 12.7-8.1 34.7-11.7 44.9-7.5 10.6 4.4 15.7 15.2 10.4 21.9-4.7 6-13.9 7.8-27 5.2-9.2-1.9-25.6-7.1-34.7-11.2-3.1-1.4-6.6-2.9-7.7-3.4-5.3-2.3-14.8-4.9-22.3-6.1-13.1-2-24.4 1-30.9 8.5-8.9 10-6.2 25.5 6.1 34.7 6.1 4.6 12.9 6.9 23.4 7.6l8.2 0.6v-2.7c0-4.1 3.9-14.8 6.3-17.4 7-7.5 19.9-8.8 38.7-3.8 14.7 3.9 27.5 4.5 35.4 1.7 3.3-1.1 7.8-3.3 10-4.8 7.5-5.1 16.3-14.9 19.8-22 3-6.1 3.3-7.6 3.3-15.8 0-8.3-0.3-9.6-3.4-15.9-4.5-9.2-9-13.9-16.6-17.5-8.6-4.1-21.3-6-29-4.5z"
                  />
                  <path
                    class="s0"
                    d="m167.2 35.7c-6.8 3.3-10.8 13-12.4 30.3-0.5 6.3-2 14.6-3.1 18.5-1.8 5.9-3.1 8-8.2 13.1-11.5 11.8-23.7 13.6-53 7.9-36.7-7.1-64.3 1.9-75.3 24.4-3.6 7.5-3.7 7.7-3.6 19.6 0 11.1 0.3 12.6 3.1 19.2 8.1 19 23.6 30.3 41.8 30.3 23.4-0.1 47.1-14.9 68.5-43 10.6-13.9 25.4-27.1 37-33l4.1-2.1-0.7 2.8c-1.3 5.3-6.9 15.8-11.4 21.5-7.2 9-16.6 15.8-27.7 19.9-2.9 1.1-5.3 2.4-5.3 2.9 0 1.7 9.6 11.3 14.9 14.9 22.3 15.2 44 6.3 62-25.4 6.6-11.5 10.8-33.7 8.2-43.1-5.7-21-31.2-16.6-63.5 11-4.5 3.8-13.7 12.4-20.6 19.2-14.2 14-17.5 16.7-23.7 19-12.1 4.7-31-3.1-36.9-15.3-2.4-4.8-2.6-5.8-1.5-9.2 3.1-10.6 8.5-12.6 36.1-13.4 22.8-0.7 30-2 39.2-6.9 11.7-6.2 19.9-17.2 24.3-32.8l2.2-7.4 2.1 5.5c1.1 3.1 2.6 8.4 3.3 11.8l1.3 6.2 4.5-0.7c22.3-3.4 32.6-27.6 21.6-50.8-2.8-6-9.6-13.3-14.2-15.2-4.3-1.8-9-1.7-13.1 0.3z"
                  />
                </g>
              </svg>
            </div>
            <span class="text-xl font-bold">Skillsy</span>
          </div>
          <button id="closeSidebar" class="text-gray-400 hover:text-white p-1">
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </button>
        </div>

        <!-- Search Bar -->
        <div class="relative">
          <div class="flex items-center bg-[#252525] rounded-full px-4 py-2">
            <span class="text-gray-400 mr-2">#</span>
            <input
              type="text"
              placeholder="Explore"
              class="bg-transparent outline-none w-full"
            />
          </div>
        </div>

        <!-- Main Navigation -->
        <div class="bg-[#1a1a1a] p-4 rounded-xl">
          <h3
            class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-3 px-2"
          >
            Main
          </h3>
          <nav class="space-y-1">
            <a
              href="#"
              class="flex items-center space-x-3 p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
            >
              <svg
                class="w-5 h-5 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span>Home</span>
            </a>
            <a
              href="#"
              class="flex items-center space-x-3 p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
            >
              <svg
                class="w-5 h-5 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                ></path>
              </svg>
              <span>Popular</span>
            </a>
            <a
              href="#"
              class="flex items-center space-x-3 p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
            >
              <svg
                class="w-5 h-5 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                ></path>
              </svg>
              <span>Explore</span>
            </a>
            <a
              href="#"
              class="flex items-center space-x-3 p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
            >
              <svg
                class="w-5 h-5 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span>All</span>
            </a>
          </nav>
        </div>

        <!-- Custom Feeds Section -->
        <div class="bg-[#1a1a1a] p-4 rounded-xl">
          <div
            class="flex justify-between items-center mb-3 sidebar-section-header cursor-pointer"
          >
            <h3
              class="text-xs font-medium text-gray-400 uppercase tracking-wider px-2"
            >
              Custom Feeds
            </h3>
            <button class="text-gray-400 hover:text-white">
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                ></path>
              </svg>
            </button>
          </div>

          <a
            href="#"
            class="flex items-center space-x-3 p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
          >
            <svg
              class="w-5 h-5 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              ></path>
            </svg>
            <span>Create a custom feed</span>
          </a>
        </div>

        <!-- Recent Section -->
        <div class="bg-[#1a1a1a] p-4 rounded-xl">
          <div
            class="flex justify-between items-center mb-3 sidebar-section-header cursor-pointer"
          >
            <h3
              class="text-xs font-medium text-gray-400 uppercase tracking-wider px-2"
            >
              Recent
            </h3>
            <button class="text-gray-400 hover:text-white">
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                ></path>
              </svg>
            </button>
          </div>

          <a
            href="#"
            class="flex items-center space-x-3 p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
          >
            <div class="w-6 h-6 rounded-full overflow-hidden">
              <img
                src="https://i.redd.it/snoovatar/avatars/6ea3bd67-42cc-4916-a063-9d7343232573.png"
                alt="r/teenagers"
                class="w-full h-full object-cover"
              />
            </div>
            <span>r/teenagers</span>
          </a>
        </div>

        <!-- Communities Section -->
        <div class="bg-[#1a1a1a] p-4 rounded-xl">
          <div
            class="flex justify-between items-center mb-3 sidebar-section-header cursor-pointer"
          >
            <h3
              class="text-xs font-medium text-gray-400 uppercase tracking-wider px-2"
            >
              Communities
            </h3>
            <button class="text-gray-400 hover:text-white">
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                ></path>
              </svg>
            </button>
          </div>

          <a
            href="#"
            class="flex items-center space-x-3 p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
          >
            <svg
              class="w-5 h-5 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              ></path>
            </svg>
            <span>Create a community</span>
          </a>

          <a
            href="#"
            class="flex items-center justify-between p-2 text-white hover:bg-[#252525] rounded-lg transition-colors"
          >
            <div class="flex items-center space-x-3">
              <div class="w-6 h-6 rounded-full overflow-hidden">
                <img
                  src="https://www.redditstatic.com/desktop2x/img/favicon/android-icon-192x192.png"
                  alt="r/JapaneseLanguage"
                  class="w-full h-full object-cover"
                />
              </div>
              <span>r/JapaneseLangu...</span>
            </div>
            <svg
              class="w-4 h-4 text-yellow-400"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
              ></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
    <!-- sidebar -->

    <div
      id="sidebarOverlay"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"
    ></div>

    <div class="px-4 py-4">
      <!-- header -->
      <header
        class="flex justify-between items-center py-4 px-6 bg-[#1a1a1a] rounded-xl mb-6 header-scroll main-header"
        id="mainHeader"
      >
        <div class="flex items-center">
          <!-- Hamburger mobile -->
          <div class="flex items-center">
            <!-- Hamburger menu for mobile only -->
            <button class="md:hidden p-2 mr-2" id="hamburgerBtn">
              <svg
                class="w-6 h-6 text-gray-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                ></path>
              </svg>
            </button>

            <!-- Logo -->
            <div class="hidden md:block bg-[#FF8A00] p-2 rounded-lg mr-3">
              <svg
                version="1.2"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 207 199"
                width="24"
                height="24"
              >
                <title>logo</title>
                <style>
                  .s0 {
                    fill: #fff;
                  }
                </style>
                <g>
                  <path
                    class="s0"
                    d="m107.5 0.6c-15.5 3.2-20 5-27.9 11.1-10.6 8.2-16.3 21.4-15.3 35.5 0.3 4.4 0.9 8.4 1.4 8.9 0.4 0.4 3.5-0.9 6.9-3.1 12.7-8.1 34.7-11.7 44.9-7.5 10.6 4.4 15.7 15.2 10.4 21.9-4.7 6-13.9 7.8-27 5.2-9.2-1.9-25.6-7.1-34.7-11.2-3.1-1.4-6.6-2.9-7.7-3.4-5.3-2.3-14.8-4.9-22.3-6.1-13.1-2-24.4 1-30.9 8.5-8.9 10-6.2 25.5 6.1 34.7 6.1 4.6 12.9 6.9 23.4 7.6l8.2 0.6v-2.7c0-4.1 3.9-14.8 6.3-17.4 7-7.5 19.9-8.8 38.7-3.8 14.7 3.9 27.5 4.5 35.4 1.7 3.3-1.1 7.8-3.3 10-4.8 7.5-5.1 16.3-14.9 19.8-22 3-6.1 3.3-7.6 3.3-15.8 0-8.3-0.3-9.6-3.4-15.9-4.5-9.2-9-13.9-16.6-17.5-8.6-4.1-21.3-6-29-4.5z"
                  />
                  <path
                    class="s0"
                    d="m167.2 35.7c-6.8 3.3-10.8 13-12.4 30.3-0.5 6.3-2 14.6-3.1 18.5-1.8 5.9-3.1 8-8.2 13.1-11.5 11.8-23.7 13.6-53 7.9-36.7-7.1-64.3 1.9-75.3 24.4-3.6 7.5-3.7 7.7-3.6 19.6 0 11.1 0.3 12.6 3.1 19.2 8.1 19 23.6 30.3 41.8 30.3 23.4-0.1 47.1-14.9 68.5-43 10.6-13.9 25.4-27.1 37-33l4.1-2.1-0.7 2.8c-1.3 5.3-6.9 15.8-11.4 21.5-7.2 9-16.6 15.8-27.7 19.9-2.9 1.1-5.3 2.4-5.3 2.9 0 1.7 9.6 11.3 14.9 14.9 22.3 15.2 44 6.3 62-25.4 6.6-11.5 10.8-33.7 8.2-43.1-5.7-21-31.2-16.6-63.5 11-4.5 3.8-13.7 12.4-20.6 19.2-14.2 14-17.5 16.7-23.7 19-12.1 4.7-31-3.1-36.9-15.3-2.4-4.8-2.6-5.8-1.5-9.2 3.1-10.6 8.5-12.6 36.1-13.4 22.8-0.7 30-2 39.2-6.9 11.7-6.2 19.9-17.2 24.3-32.8l2.2-7.4 2.1 5.5c1.1 3.1 2.6 8.4 3.3 11.8l1.3 6.2 4.5-0.7c22.3-3.4 32.6-27.6 21.6-50.8-2.8-6-9.6-13.3-14.2-15.2-4.3-1.8-9-1.7-13.1 0.3z"
                  />
                </g>
              </svg>
            </div>
            <span class="text-xl font-bold">Skillsy</span>
          </div>

          <!-- Search bar -->
          <div class="hidden md:block ml-6 relative search-bar">
            <div class="flex items-center bg-[#252525] rounded-full px-4 py-2">
              <span class="text-gray-400 mr-2">#</span>
              <input
                type="text"
                placeholder="Explore"
                class="bg-transparent w-full outline-none"
              />
            </div>
          </div>
        </div>

        <!-- Mobile search bar-->
        <div class="md:hidden relative search-bar">
          <div class="flex items-center bg-[#252525] rounded-full px-3 py-1">
            <span class="text-gray-400 mr-1">#</span>
            <input
              type="text"
              placeholder="Search"
              class="bg-transparent outline-none w-24 text-sm"
            />
          </div>
        </div>

        <div class="flex items-center">
          <!-- Icons -->
          <div class="hidden md:flex items-center space-x-6 header-icons">
            <button class="relative p-2">
              <svg
                class="w-6 h-6 text-gray-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                ></path>
              </svg>
            </button>

            <button class="relative p-2">
              <svg
                class="w-6 h-6 text-gray-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                ></path>
              </svg>
              <span
                class="absolute top-0 right-0 bg-yellow-400 text-xs w-4 h-4 flex items-center justify-center rounded-full"
                >2</span
              >
            </button>
            <button class="p-2">
              <svg
                class="w-6 h-6 text-gray-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                ></path>
              </svg>
            </button>
          </div>

          <!-- dropdown -->
          <div class="dropdown">
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
              <span class="font-medium hidden md:inline"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></span>
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
                  d="M19 9l-7 7-7-7"
                ></path>
              </svg>
            </div>

            <!-- Dropdown menu -->
            <div class="dropdown-menu" id="profileMenu">
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
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                  ></path>
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
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                  ></path>
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
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                  ></path>
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  ></path>
                </svg>
                <span>Settings</span>
              </div>

              <div class="dropdown-divider"></div>

              <!-- Theme -->
              <div class="theme-switcher mx-auto">
                <button
                  id="darkTheme"
                  class="theme-switcher_switch"
                  data-active="true"
                  aria-checked="true"
                  role="switch"
                >
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
                      d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646L11.828 15H9v-2.828l8.586-8.586z"
                    ></path>
                  </svg>
                </button>
                <button
                  id="lightTheme"
                  class="theme-switcher_switch"
                  data-active="false"
                  aria-checked="false"
                  role="switch"
                >
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
                      d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                    ></path>
                  </svg>
                </button>
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
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6 0H9"
                  ></path>
                </svg>
                <a href="../controller/logout.php">Log Out</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- header -->

      <!-- main -->
      <div class="flex flex-col md:flex-row gap-6">
        <!-- Left sidebar -->
        <div class="w-full md:w-1/4 sidebar-left">
          <!-- Profile -->
          <div class="bg-[#1A1A1A] rounded-xl p-6 mb-6">
            <div class="relative mb-6">
              <div class="profile-circle w-40 h-40 mx-auto">
                <img
                  src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                  alt="Profile"
                  class="w-36 h-36 rounded-full object-cover absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                />
              </div>
            </div>

            <div class="text-center mb-4">
              <h2 class="text-xl font-bold"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h2>
              <p class="text-gray-400">@<?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>

            <div class="flex justify-center gap-8 mb-6">
              <div class="text-center">
                <p class="font-bold">1984</p>
                <p class="text-sm text-gray-400">Followers</p>
              </div>
              <div class="text-center">
                <p class="font-bold">1002</p>
                <p class="text-sm text-gray-400">Following</p>
              </div>
            </div>

            <p class="text-center text-gray-300 mb-6">
              <span class="text-yellow-400">✨</span> Hello, I'm a developer and
              tech enthusiast who loves to code.
              <span class="text-yellow-400">✨</span>
            </p>

            <button
              class="w-full bg-[#252525] hover:bg-[#303030] py-2 rounded-lg transition"
            >
              My Profile
            </button>
          </div>

          <!-- Skills -->
          <div class="bg-[#1A1A1A] rounded-xl p-6 mb-6">
            <h3 class="font-bold mb-4">Skills</h3>
            <div class="flex flex-wrap gap-2">
              <span class="bg-[#252525] text-sm px-3 py-1 rounded-full"
                >UX Design</span
              >
              <span class="bg-[#252525] text-sm px-3 py-1 rounded-full"
                >Copywriting</span
              >
              <span class="bg-[#252525] text-sm px-3 py-1 rounded-full"
                >Mobile</span
              >
              <span class="bg-[#252525] text-sm px-3 py-1 rounded-full"
                >Research</span
              >
              <span class="bg-[#252525] text-sm px-3 py-1 rounded-full"
                >User Interview</span
              >
              <span class="bg-[#252525] text-sm px-3 py-1 rounded-full"
                >JS</span
              >
              <span class="bg-[#252525] text-sm px-3 py-1 rounded-full"
                >Logo</span
              >
            </div>
          </div>

          <!-- Communities -->
          <div class="bg-[#1A1A1A] rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
              <h3 class="font-bold">Communities</h3>
              <div class="flex gap-2">
                <button
                  class="w-8 h-8 flex items-center justify-center bg-[#252525] rounded-full"
                >
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    ></path>
                  </svg>
                </button>
                <button
                  class="w-8 h-8 flex items-center justify-center bg-[#252525] rounded-full"
                >
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center"
                >
                  <div class="w-6 h-6 border-2 border-black rounded-full"></div>
                </div>
                <div>
                  <p class="font-medium">UX designers community</p>
                  <p class="text-sm text-yellow-400">
                    • 32 your friends are in
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center"
                >
                  <div class="w-6 h-6 border-2 border-black rounded-full"></div>
                </div>
                <div>
                  <p class="font-medium">Frontend developers</p>
                  <p class="text-sm text-yellow-400">
                    • 12 your friends are in
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- main fyp -->
        <div class="w-full md:w-2/4 main-content">
          <div class="md:flex justify-between mb-6">
            <div class="flex -space-x-2">
              <div
                class="w-12 h-12 rounded-full border-2 border-[orange] bg-[#1A1A1A] flex items-center justify-center"
              >
                <img
                  src="https://randomuser.me/api/portraits/women/68.jpg"
                  class="w-10 h-10 rounded-full object-cover"
                  alt="User"
                />
              </div>
              <div
                class="w-12 h-12 rounded-full border-2 border-[#1A1A1A] bg-[#1A1A1A] flex items-center justify-center"
              >
                <img
                  src="https://randomuser.me/api/portraits/men/32.jpg"
                  class="w-10 h-10 rounded-full object-cover"
                  alt="User"
                />
              </div>
              <div
                class="w-12 h-12 rounded-full border-2 border-[#1A1A1A] bg-[#1A1A1A] flex items-center justify-center"
              >
                <img
                  src="https://randomuser.me/api/portraits/women/42.jpg"
                  class="w-10 h-10 rounded-full object-cover"
                  alt="User"
                />
              </div>
              <div
                class="w-12 h-12 rounded-full border-2 border-[#1A1A1A] bg-[#1A1A1A] flex items-center justify-center"
              >
                <img
                  src="https://randomuser.me/api/portraits/men/45.jpg"
                  class="w-10 h-10 rounded-full object-cover"
                  alt="User"
                />
              </div>
              <div
                class="w-12 h-12 rounded-full border-2 border-[#1A1A1A] bg-[#1A1A1A] flex items-center justify-center"
              >
                <img
                  src="https://randomuser.me/api/portraits/women/31.jpg"
                  class="w-10 h-10 rounded-full object-cover"
                  alt="User"
                />
              </div>
              <div
                class="w-12 h-12 rounded-full border-2 border-[#1A1A1A] bg-[#1A1A1A] flex items-center justify-center"
              >
                <img
                  src="https://randomuser.me/api/portraits/men/22.jpg"
                  class="w-10 h-10 rounded-full object-cover"
                  alt="User"
                />
              </div>
            </div>
          </div>

          <!-- Post -->
          <div class="bg-[#1A1A1A] rounded-xl p-6 mb-6">
            <div class="flex gap-4">
              <img
                src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                alt="Profile"
                class="w-10 h-10 rounded-full object-cover"
              />
              <div class="flex-1">
                <div class="bg-[#252525] rounded-xl p-3 mb-4">
                  <input
                    type="text"
                    placeholder="Tell your friends about your thoughts..."
                    class="bg-transparent w-full outline-none"
                  />
                </div>
                <div class="flex flex-wrap gap-3">
                  <button
                    class="flex items-center gap-2 bg-[#252525] hover:bg-[#303030] px-4 py-2 rounded-xl transition"
                  >
                    <svg
                      class="w-5 h-5 text-teal-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                      ></path>
                    </svg>
                    <span>Photo</span>
                  </button>
                  <button
                    class="flex items-center gap-2 bg-[#252525] hover:bg-[#303030] px-4 py-2 rounded-xl transition"
                  >
                    <svg
                      class="w-5 h-5 text-blue-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                      ></path>
                    </svg>
                    <span>Video</span>
                  </button>
                  <button
                    class="hidden md:flex items-center gap-2 bg-[#252525] hover:bg-[#303030] px-4 py-2 rounded-xl transition"
                  >
                    <svg
                      class="w-5 h-5 text-purple-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                      ></path>
                    </svg>
                    <span>Poll</span>
                  </button>
                  <button
                    class="hidden md:flex items-center gap-2 bg-[#252525] hover:bg-[#303030] px-4 py-2 rounded-xl transition"
                  >
                    <svg
                      class="w-5 h-5 text-yellow-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 11V9a2 2 0 00-2-2m2 4v4a2 2 0 104 0v-1m-4-3H9m2 0h4m6 1a9 9 0 11-18 0 9 9 0 0118 0z"
                      ></path>
                    </svg>
                    <span>Tip</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Post 1 -->
          <div class="bg-[#1A1A1A] rounded-xl p-6 mb-6">
            <div class="flex justify-between mb-4">
              <div class="flex gap-3">
                <img
                  src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                  alt="User"
                  class="w-12 h-12 rounded-full object-cover"
                />
                <div>
                  <div class="flex items-center gap-1">
                    <h4 class="font-bold">Arsher</h4>
                    <svg
                      class="w-4 h-4 text-blue-500"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M6.267 3.455a3.066 3.066 0 001.745-.723a3.066 3.066 0 013.976 0a3.066 3.066 0 001.745.723a3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976a3.066 3.066 0 00-.723 1.745a3.066 3.066 0 01-2.812 2.812a3.066 3.066 0 00-1.745.723a3.066 3.066 0 01-3.976 0a3.066 3.066 0 00-1.745-.723a3.066 3.066 0 01-2.812-2.812a3.066 3.066 0 00-.723-1.745a3.066 3.066 0 010-3.976a3.066 3.066 0 00.723-1.745a3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                  <p class="text-sm text-yellow-400">• 1 hr ago</p>
                </div>
              </div>
              <button>
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                  ></path>
                </svg>
              </button>
            </div>
            <p class="mb-4 text-gray-300">
              In some cases you may see a third-party client name, which
              indicates the Tweet came from a non-Twitter application.
            </p>
            <div class="rounded-xl overflow-hidden mb-4">
              <img
                src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1064&q=80"
                alt="Post"
                class="w-full h-64 object-cover"
              />
            </div>
            <div class="flex justify-between post-actions">
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-red-500 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                  ></path>
                </svg>
              </button>
              <button
                class="px-4 py-1.5 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
              >
                Hire me
              </button>
            </div>
          </div>

          <div class="flex-grow border-t mb-6 border-gray-700"></div>

          <!-- Post 1 -->
          <div class="bg-[#1A1A1A] rounded-xl p-6 mb-6">
            <div class="flex justify-between mb-4">
              <div class="flex gap-3">
                <img
                  src="https://randomuser.me/api/portraits/women/68.jpg"
                  alt="User"
                  class="w-12 h-12 rounded-full object-cover"
                />
                <div>
                  <div class="flex items-center gap-1">
                    <h4 class="font-bold">Maya Johnson</h4>
                    <svg
                      class="w-4 h-4 text-blue-500"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M6.267 3.455a3.066 3.066 0 001.745-.723a3.066 3.066 0 013.976 0a3.066 3.066 0 001.745.723a3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976a3.066 3.066 0 00-.723 1.745a3.066 3.066 0 01-2.812 2.812a3.066 3.066 0 00-1.745.723a3.066 3.066 0 01-3.976 0a3.066 3.066 0 00-1.745-.723a3.066 3.066 0 01-2.812-2.812a3.066 3.066 0 00-.723-1.745a3.066 3.066 0 010-3.976a3.066 3.066 0 00.723-1.745a3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                  <p class="text-sm text-yellow-400">• 3 hrs ago</p>
                </div>
              </div>
              <button>
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                  ></path>
                </svg>
              </button>
            </div>
            <p class="mb-4 text-gray-300">
              Just completed my latest UI design course! Here's a quick look at
              the color theory project I worked on. Looking for feedback from
              fellow designers 🎨
            </p>
            <div class="rounded-xl overflow-hidden mb-4">
              <img
                src="https://images.unsplash.com/photo-1579546929662-711aa81148cf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                alt="Post"
                class="w-full h-64 object-cover"
              />
            </div>
            <div class="flex justify-between post-actions">
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-red-500 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                  ></path>
                </svg>
              </button>
              <button
                class="px-4 py-1.5 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
              >
                Collaborate
              </button>
            </div>
          </div>

          <div class="flex-grow border-t mb-6 border-gray-700"></div>

          <!-- Post 2 -->
          <div class="bg-[#1A1A1A] rounded-xl p-6 mb-6">
            <div class="flex justify-between mb-4">
              <div class="flex gap-3">
                <img
                  src="https://randomuser.me/api/portraits/men/32.jpg"
                  alt="User"
                  class="w-12 h-12 rounded-full object-cover"
                />
                <div>
                  <div class="flex items-center gap-1">
                    <h4 class="font-bold">Alex Chen</h4>
                  </div>
                  <p class="text-sm text-yellow-400">• 5 hrs ago</p>
                </div>
              </div>
              <button>
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                  ></path>
                </svg>
              </button>
            </div>
            <p class="mb-4 text-gray-300">
              Sharing my latest React component library. It's open source and
              includes dark/light themes with animation support. Check out the
              demo below and let me know your thoughts!
            </p>
            <div class="rounded-xl overflow-hidden mb-4">
              <img
                src="https://images.unsplash.com/photo-1517292987719-0369a794ec0f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80"
                alt="Post"
                class="w-full h-64 object-cover"
              />
            </div>
            <div class="flex justify-between post-actions">
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-red-500 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                  ></path>
                </svg>
              </button>
              <button
                class="px-4 py-1.5 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
              >
                Fork repo
              </button>
            </div>
          </div>

          <div class="flex-grow border-t mb-6 border-gray-700"></div>

          <!-- Post 3 -->
          <div class="bg-[#1A1A1A] rounded-xl p-6 mb-6">
            <div class="flex justify-between mb-4">
              <div class="flex gap-3">
                <img
                  src="https://randomuser.me/api/portraits/women/42.jpg"
                  alt="User"
                  class="w-12 h-12 rounded-full object-cover"
                />
                <div>
                  <div class="flex items-center gap-1">
                    <h4 class="font-bold">Sarah Williams</h4>
                    <svg
                      class="w-4 h-4 text-blue-500"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M6.267 3.455a3.066 3.066 0 001.745-.723a3.066 3.066 0 013.976 0a3.066 3.066 0 001.745.723a3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976a3.066 3.066 0 00-.723 1.745a3.066 3.066 0 01-2.812 2.812a3.066 3.066 0 00-1.745.723a3.066 3.066 0 01-3.976 0a3.066 3.066 0 00-1.745-.723a3.066 3.066 0 01-2.812-2.812a3.066 3.066 0 00-.723-1.745a3.066 3.066 0 010-3.976a3.066 3.066 0 00.723-1.745a3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                  <p class="text-sm text-yellow-400">• 8 hrs ago</p>
                </div>
              </div>
              <button>
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                  ></path>
                </svg>
              </button>
            </div>
            <p class="mb-4 text-gray-300">
              I'm looking for UX researchers to join our panel study next week.
              We're exploring accessibility in mobile apps and need diverse
              perspectives. $50/hour compensation. DM if interested!
            </p>
            <div class="flex justify-between post-actions">
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-red-500 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                  ></path>
                </svg>
              </button>
              <button
                class="flex items-center gap-2 text-gray-400 hover:text-gray-300 transition"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                  ></path>
                </svg>
              </button>
              <button
                class="px-4 py-1.5 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
              >
                Apply
              </button>
            </div>
          </div>

          <!-- Comment -->
          <div class="bg-[#1A1A1A] p-4 rounded-xl">
            <div class="flex gap-4">
              <img
                src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                alt="Profile"
                class="w-8 h-8 rounded-full object-cover"
              />
              <div class="flex-1 relative">
                <input
                  type="text"
                  placeholder="Write your comment"
                  class="bg-[#252525] w-full py-2 px-4 rounded-xl outline-none"
                />
                <div class="absolute right-3 top-2 flex gap-2">
                  <button>
                    <svg
                      class="w-5 h-5 text-gray-400"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      ></path>
                    </svg>
                  </button>
                  <button>
                    <svg
                      class="w-5 h-5 text-gray-400"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                      ></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right sidebar -->
        <div class="w-full md:w-1/4 sidebar-right">
          <div class="bg-[#1A1A1A] rounded-xl p-6">
            <h3 class="font-bold mb-6">Recent activity</h3>

            <!-- Activity -->
            <div class="mb-6">
              <div class="flex items-start gap-3 mb-2">
                <div class="relative">
                  <img
                    src="https://randomuser.me/api/portraits/men/32.jpg"
                    alt="User"
                    class="w-10 h-10 rounded-full object-cover"
                  />
                  <div
                    class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full border-2 border-[#1A1A1A]"
                  ></div>
                </div>
                <div>
                  <h4 class="font-medium">Vitally Akterskiy</h4>
                  <p class="text-sm text-gray-400">
                    subscribed on you
                    <span class="text-yellow-400">• 3 min ago</span>
                  </p>
                </div>
              </div>
              <div class="flex justify-between items-center">
                <div class="text-lg font-medium">
                  $10.00 <span class="text-sm text-gray-400">/tip</span>
                </div>
                <button
                  class="px-4 py-1 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
                >
                  Thanks
                </button>
              </div>
            </div>

            <!-- Activity -->
            <div class="mb-6 pb-6 border-b border-gray-700">
              <div class="flex items-start gap-3 mb-2">
                <img
                  src="https://randomuser.me/api/portraits/men/45.jpg"
                  alt="User"
                  class="w-10 h-10 rounded-full object-cover"
                />
                <div>
                  <h4 class="font-medium">Maksym Karafizi</h4>
                  <p class="text-sm text-gray-400">
                    wanna hire you
                    <span class="text-yellow-400">• 6 hrs ago</span>
                  </p>
                </div>
              </div>
              <div class="flex justify-between items-center">
                <div class="text-lg font-medium">
                  $90.00 <span class="text-sm text-gray-400">/purchase</span>
                </div>
                <button
                  class="px-4 py-1 bg-gray-700 text-white font-medium rounded-full hover:bg-gray-600 transition"
                >
                  Thanked
                </button>
              </div>
            </div>

            <!-- Activity -->
            <div class="mb-6">
              <div class="flex items-start gap-3 mb-2">
                <img
                  src="https://randomuser.me/api/portraits/men/36.jpg"
                  alt="User"
                  class="w-10 h-10 rounded-full object-cover"
                />
                <div>
                  <h4 class="font-medium">Evgeniy Alexandrov</h4>
                  <p class="text-sm text-gray-400">
                    sent you a tip
                    <span class="text-yellow-400">• 7 hrs ago</span>
                  </p>
                </div>
              </div>
              <div class="flex justify-between items-center">
                <div class="text-lg font-medium">
                  $30.00 <span class="text-sm text-gray-400">/purchase</span>
                </div>
                <button
                  class="px-4 py-1 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
                >
                  Thanks
                </button>
              </div>
            </div>

            <!-- Activity -->
            <div class="mb-6 pb-6 border-b border-gray-700">
              <div class="flex items-start gap-3 mb-2">
                <img
                  src="https://randomuser.me/api/portraits/women/42.jpg"
                  alt="User"
                  class="w-10 h-10 rounded-full object-cover"
                />
                <div>
                  <h4 class="font-medium">Rosaline Kumbirai</h4>
                  <p class="text-sm text-gray-400">
                    sent you job request
                    <span class="text-yellow-400">• 1 hr ago</span>
                  </p>
                </div>
              </div>
              <div class="flex justify-between items-center">
                <div class="text-lg font-medium">
                  $20.00 <span class="text-sm text-gray-400">/purchase</span>
                </div>
                <button
                  class="px-4 py-1 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
                >
                  Thanks
                </button>
              </div>
            </div>

            <!-- Group invitation -->
            <div class="mb-4">
              <div class="flex items-start gap-3 mb-2">
                <div
                  class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center"
                >
                  <div
                    class="w-6 h-6 border-2 border-[#1A1A1A] rounded-full"
                  ></div>
                </div>
                <div>
                  <h4 class="font-medium">UX designers group</h4>
                  <p class="text-sm text-yellow-400">• 12 hrs ago</p>
                </div>
              </div>
              <div class="flex gap-2 mt-3">
                <button
                  class="flex-1 px-4 py-1.5 bg-gray-700 text-white font-medium rounded-full hover:bg-gray-600 transition"
                >
                  Discard
                </button>
                <button
                  class="flex-1 px-4 py-1.5 bg-yellow-400 text-black font-medium rounded-full hover:bg-yellow-500 transition"
                >
                  Join
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- main -->

    <!-- mobile-nav -->
    <div class="md:hidden mobile-nav">
      <a href="#" class="mobile-nav-btn active">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
          ></path>
        </svg>
        <span>Home</span>
      </a>
      <a href="#" class="mobile-nav-btn">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
          ></path>
        </svg>
        <span>Popular</span>
      </a>
      <a href="#" class="mobile-nav-btn">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
          ></path>
        </svg>
        <span>Create</span>
      </a>
      <a href="#" class="mobile-nav-btn">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
          ></path>
        </svg>
        <span>Inbox</span>
      </a>
      <div class="mobile-nav-btn">
        <img
          src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
          alt=""
          class="w-6 h-6 rounded-full"
        />
        <span>Profile</span>
      </div>
    </div>
    <!-- mobile-nav -->

    <script src="../assets/js/script.js"></script>
  </body>
</html>