<?php
// Dummy product requests (later this will come from DB)

// Dummy product requests
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../app/config/db.php';
if(!isset($_SESSION['user_id'])){
    $query = "SELECT * FROM product_list where req_type='Product' and status='Open'";
$result = $connection->query($query);
$productRequests = $result->fetch_all(MYSQLI_ASSOC);

$query = "SELECT * FROM product_list where req_type='Service' and status='Open'";
$result = $connection->query($query);
$serviceRequests = $result->fetch_all(MYSQLI_ASSOC);
}
else{
        $query = "SELECT * FROM product_list where req_type='Product' and status='Open' and userId!={$_SESSION['user_id']}";
$result = $connection->query($query);
$productRequests = $result->fetch_all(MYSQLI_ASSOC);

$query = "SELECT * FROM product_list where req_type='Service' and status='Open' and userId!={$_SESSION['user_id']}";
$result = $connection->query($query);
$serviceRequests = $result->fetch_all(MYSQLI_ASSOC);
}

?>
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Hero Section -->
    <div class="bg-blue-600 text-white rounded-lg p-8 mb-10">
        <h1 class="text-3xl font-bold mb-2">
            Request Products, Services, and More.
        </h1>
        <p class="text-lg mb-4">
            Find what you need and share your requirements with others.
        </p>
        <a href="/index.php?page=requestProducts"
   class="inline-block bg-white text-blue-600 px-6 py-2 rounded font-semibold hover:bg-gray-100">
    Create a Request
</a>

    </div>

    <!-- Section Title -->
     <div class="mb-6 " >
    <h2 class="text-2xl font-bold mb-6">Latest Product Requests</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    <?php
    if(empty($productRequests)){ ?>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">
                No Product Requests of other users Found
            </h3>
        </div>
    <?php }

?>
    <?php foreach ($productRequests as $request ): ?>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">

            <h3 class="text-xl font-semibold mb-2">
                <?= htmlspecialchars($request['title']) ?>
            </h3>

            <p class="text-sm text-gray-500 mb-2">
                Category: <?= htmlspecialchars($request['category']) ?>
            </p>

            <p class="text-gray-700 mb-4">
                <?= htmlspecialchars($request['description']) ?>
            </p>

            <div class="text-sm text-gray-600 mb-4">
                📍 <?= htmlspecialchars($request['location']) ?><br>
                👤 Requested by <?php
                 $query="SELECT name FROM users WHERE id=?";
    $stmt=$connection->prepare($query);
    $stmt->bind_param('i', $request['userId']);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();
    $request['posted_by']=$row['name'];
                 echo htmlspecialchars($request['posted_by']); ?><br>
                ✅ Status: <?= htmlspecialchars($request['status']) ?>
            </div>
            

            <a href="/index.php?page=requestDetails&requestId=<?=$request['id']?>"
               class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                View Details
            </a>

        </div>
    <?php endforeach; ?>
</div>
<h2 class="text-2xl font-bold mb-6">Latest Service Requests</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php
    if(empty($serviceRequests)){ ?>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">
                No Service Requests of other users Found
            </h3>
        </div>
    <?php }

?>
    <?php foreach ($serviceRequests as $request): ?>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">

            <h3 class="text-xl font-semibold mb-2">
                <?= htmlspecialchars($request['title']) ?>
            </h3>

            <p class="text-sm text-gray-500 mb-2">
                Category: <?= htmlspecialchars($request['category']) ?>
            </p>

            <p class="text-gray-700 mb-4">
                <?= htmlspecialchars($request['description']) ?>
            </p>

            <div class="text-sm text-gray-600 mb-4">
                📍 <?= htmlspecialchars($request['location']) ?><br>
               👤 Requested by <?php
                 $query="SELECT name FROM users WHERE id=?";
    $stmt=$connection->prepare($query);
    $stmt->bind_param('i', $request['userId']);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();
    $request['posted_by']=$row['name'];
                 echo htmlspecialchars($request['posted_by']); ?><br>
                ✅ Status: <?= htmlspecialchars($request['status']) ?>
            </div>

             <a href="/index.php?page=requestDetails&requestId=<?=$request['id']?>"
               class="block text-center bg-green-600 text-white py-2 rounded hover:bg-green-700">
                View Details
            </a>

        </div>
    <?php endforeach; ?>
</div>

</div>
