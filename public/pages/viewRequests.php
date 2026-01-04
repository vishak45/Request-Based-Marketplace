<?php

require_once __DIR__ . '/../../app/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if(isset($_SESSION['user_id'])){
    $query = "
    SELECT p.*, u.name AS posted_by
    FROM product_list p
    JOIN users u ON p.userId = u.id
    WHERE p.userId!={$_SESSION['user_id']}";
}
else{
    $query = "
    SELECT p.*, u.name AS posted_by
    FROM product_list p
    JOIN users u ON p.userId = u.id ";
}

$result = $connection->query($query);
$allRequests = $result->fetch_all(MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    $search = strtolower($data['search'] ?? '');
    $filterTypes = $data['filterTypes'] ?? [];

    $filtered = array_filter($allRequests, function ($req) use ($search, $filterTypes) {

        $matchesSearch =
            !$search ||
            str_contains(strtolower($req['title']), $search) ||
            str_contains(strtolower($req['category']), $search) ||
            str_contains(strtolower($req['description']), $search);

        $matchesType =
            empty($filterTypes) ||
            in_array($req['req_type'], $filterTypes);

        return $matchesSearch && $matchesType;
    });

    echo json_encode([
        'success' => true,
        'requests' => array_values($filtered)
    ]);
    exit;
}
?>


<div class="mb-6">
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">

        <input
            type="text"
            id="search"
            placeholder="Search by title, category, or description"
            class="w-full sm:w-1/2 border border-gray-300 rounded-md py-3 px-4 focus:ring-2 focus:ring-blue-500"
        >

        <div class="flex gap-4 text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" class="filterType" value="product">
                Product
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" class="filterType" value="service">
                Service
            </label>
        </div>

        <button
            onclick="applyFilters()"
            class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition"
        >
            Filter
        </button>
    </div>
</div>


<div id="requestsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

<?php if (empty($allRequests)): ?>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-xl font-semibold">
            No requests found of other users
        </h3>
    </div>
<?php endif; ?>

<?php foreach ($allRequests as $request): ?>
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
            👤 Requested by <?= htmlspecialchars($request['posted_by']) ?><br>
            ✅ Status: <?= htmlspecialchars($request['status']) ?>
        </div>

        <a href="/Request-Based-Marketplace/public/index.php?page=requestDetails&requestId=<?=$request['id']?>"
           class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            View Details
        </a>

    </div>
<?php endforeach; ?>

</div>

<script>
async function applyFilters() {
    const search = document.getElementById('search').value;

    const filterTypes = Array.from(
        document.querySelectorAll('.filterType:checked')
    ).map(cb => cb.value);

    const response = await fetch(
        '/Request-Based-Marketplace/public/pages/viewRequests.php',
        {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ search, filterTypes })
        }
    );

    const data = await response.json();
    renderRequests(data.requests);
}

function renderRequests(requests) {
    const grid = document.getElementById('requestsGrid');
    grid.innerHTML = '';

    if (requests.length === 0) {
        grid.innerHTML = `
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold">
                    No matching requests found
                </h3>
            </div>
        `;
        return;
    }

    requests.forEach(req => {
        grid.innerHTML += `
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">
                    ${escapeHtml(req.title)}
                </h3>

                <p class="text-sm text-gray-500 mb-2">
                    Category: ${escapeHtml(req.category)}
                </p>

                <p class="text-gray-700 mb-4">
                    ${escapeHtml(req.description)}
                </p>

                <div class="text-sm text-gray-600 mb-4">
                    📍 ${escapeHtml(req.location)}<br>
                    👤 Requested by ${escapeHtml(req.posted_by)}<br>
                    ✅ Status: ${escapeHtml(req.status)}
                </div>

                <a href="/Request-Based-Marketplace/public/index.php?page=requestDetails&requestId=<?=$request['id']?>"
                   class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    View Details
                </a>
            </div>
        `;
    });
}

function escapeHtml(text) {
    return text
        ?.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}
</script>
