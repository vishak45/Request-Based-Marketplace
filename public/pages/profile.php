<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /Request-Based-Marketplace/public/index.php?page=login");
    exit();
}

// Session data
$userName  = $_SESSION['user_name'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? 'user@email.com';

// Dummy user

?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <!-- Profile Card -->
    <div class="bg-white p-6 rounded-xl shadow mb-10 flex items-center gap-6">
        <div class="w-16 h-16 rounded-full bg-blue-600 text-white flex items-center justify-center text-2xl font-bold">
            <?= strtoupper(substr($userName, 0, 1)) ?>
        </div>

        <div>
            <h2 class="text-2xl font-bold"><?= htmlspecialchars($userName) ?></h2>
            <p class="text-gray-600"><?= htmlspecialchars($userEmail) ?></p>
        </div>
    </div>

    <!-- My Requests -->
    <div class="bg-white p-6 rounded-xl shadow">
        Find your requests on the <a href="/Request-Based-Marketplace/public/index.php?page=userRequests" class="text-blue-600">My Requests</a> page
        </div>

      

    </div>
</div>
