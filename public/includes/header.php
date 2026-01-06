<?php
ob_start();
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RequestMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>

var dropdown;


function toggleDropdown() {
     dropdown = document.getElementById('userDropdown');
   
    dropdown.classList.toggle('hidden');
}

function logoutUSr()
{
    const ask=confirm('Are you sure you want to logout?');
    if(ask)
    {
        window.location.href='/pages/logout.php';
    }
    return;
}

</script>

</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-white shadow-md ">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        
        <!-- Logo / Brand -->
        <div class="flex items-center space-x-2">
            <span class="text-xl font-bold text-blue-600">
                Request<span class="text-gray-800">Mart</span>
            </span>
        </div>
<button
    class="md:hidden text-gray-700 focus:outline-none"
    onclick="document.getElementById('mobileMenu').classList.toggle('hidden')"
>
    ☰
</button>
        <!-- Navigation -->
        <nav class="hidden md:flex space-x-6">
            <a href="/index.php?page=home" class="text-gray-700 hover:text-blue-600 font-medium">
                Home
            </a>
            <a href="/index.php?page=viewRequests" class="text-gray-700 hover:text-blue-600 font-medium">
                View Requests
            </a>
            <a href="/index.php?page=requestProducts" class="text-gray-700 hover:text-blue-600 font-medium">
                Create Request
            </a>
        </nav>
 
        <!-- Auth Buttons -->
    <?php
    if(!isset($_SESSION['user_id']))
{

?>

        <nav class="hidden md:flex space-x-3">
            <a href="/index.php?page=login"
               class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50">
                Login
            </a>
            <a href="/index.php?page=register"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Register
            </a>
        </nav>
        <?php
}else{?>
<nav class="hidden md:flex relative inline-block text-left">
    <!-- Button -->
    <button
        id="userMenuButton"
        onclick="toggleDropdown()"
        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none"
    >
        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Dropdown -->
    <div
        id="userDropdown"
        class="hidden absolute right-0 mt-10 w-48 bg-white rounded-md shadow-lg border z-50"
    >
        <a href="/index.php?page=userRequests"
           class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
            My Requests 
        </a>

    

        <a href="/index.php?page=profile"
           class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
            Profile
        </a>

        <div class="border-t"></div>

        <button onclick="logoutUSr()" class="block px-4 py-2 text-red-600 hover:bg-gray-100">
            Logout
        </button>
    </div>
</nav>

<?php

}?>
    </div>
     <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t bg-white px-4 py-3 space-y-2">
        <a href="/index.php" class="block py-2">Home</a>
        <a href="/index.php?page=viewRequests" class="block py-2">View Requests</a>
        <a href="/index.php?page=requestProducts" class="block py-2">
            Create Request
        </a>

        <div class="border-t pt-2"></div>

        <?php if (!isset($_SESSION['user_id'])){ ?>
            <a href="/index.php?page=login" class="block py-2">Login</a>
            <a href="/index.php?page=register" class="block py-2">Register</a>
        <?php }else{?>
            <a href="/index.php?page=profile" class="block py-2">Profile</a>
            <a href="/index.php?page=userRequests" class="block py-2">My Requests</a>
            <button onclick="logoutUSr()" class="block py-2 text-red-600">Logout</button>
        <?php } ?>
    </div>
</header>
