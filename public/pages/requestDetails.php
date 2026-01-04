<?php
require_once __DIR__ . '/../../app/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['requestId'])) {
    echo "Invalid Request";
    exit;
}

$id = (int) $_GET['requestId'];

$query = "SELECT * FROM product_list WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Request not found";
    exit;
}


$query = "SELECT name FROM users WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $product['userId']);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();
?>

<div class="max-w-4xl mx-auto px-4 py-10">

    <div class="bg-white rounded-xl shadow-lg p-8">

        <!-- Header -->
        <div class="mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-blue-600 mb-2">
                <?= htmlspecialchars($product['title']) ?>
            </h1>

            <div class="flex flex-wrap gap-3 text-sm">
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                    <?= htmlspecialchars($product['req_type']) ?>
                </span>

                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                    <?= htmlspecialchars($product['category']) ?>
                </span>

                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">
                    <?= htmlspecialchars($product['status']) ?>
                </span>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Description</h3>
            <p class="text-gray-700 leading-relaxed">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            </p>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6 text-sm">

            <div>
                <p class="text-gray-500">Request ID</p>
                <p class="font-medium"><?= $product['id'] ?></p>
            </div>

            <div>
                <p class="text-gray-500">Location</p>
                <p class="font-medium"><?= htmlspecialchars($product['location']) ?></p>
            </div>

            <div>
                <p class="text-gray-500">Contact Number</p>
                <p class="font-medium"><?= htmlspecialchars($product['contact_no']) ?></p>
            </div>

            <div>
                <p class="text-gray-500">Email</p>
                <p class="font-medium"><?= htmlspecialchars($product['email']) ?></p>
            </div>

            <div>
                <p class="text-gray-500">Posted By</p>
                <p class="font-medium"><?= htmlspecialchars($user['name']) ?></p>
            </div>

            <div>
                <p class="text-gray-500">Created At</p>
                <p class="font-medium"><?= htmlspecialchars($product['created_at']) ?></p>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex gap-4 mt-6">
            <a href="javascript:history.back()"
               class="px-5 py-2 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                ← Back
            </a>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $product['userId']): ?>
                <a href="#"
                   class="px-5 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition">
                    Edit Request
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>
