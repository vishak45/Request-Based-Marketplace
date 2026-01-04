<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /Request-Based-Marketplace/public/index.php?page=login");
    exit();
}
?>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg">

    <!-- Heading -->
    <h2 class="text-3xl font-bold text-blue-600 mb-2 text-center">
        Create a Request
    </h2>
    <p class="text-gray-500 text-center mb-8">
        Request a product or service and let others contact you
    </p>

    <form
        onsubmit="addProducts()"
        method="POST"
        class="space-y-6"
    >

        <!-- Request Type -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Request Type
            </label>
            <select
                name="request_type"
                id="requestType"
                required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                onchange="updateCategories()"
            >
                <option value="">Select type</option>
                <option value="product">Product</option>
                <option value="service">Service</option>
            </select>
        </div>

        <!-- Title -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Title
            </label>
            <input
                type="text"
                name="title"
                id="title"
                required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. Used Cricket Bat / Need a Plumber"
            >
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Description
            </label>
            <textarea
                name="description"
                rows="4"
                id="description"
                required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="Describe your requirement clearly"
            ></textarea>
        </div>

        <!-- Category -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Category
            </label>
            <select
                name="category"
                id="category"
                required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Select category</option>
            </select>
        </div>

        <!-- Divider -->
        <hr class="my-6">

        <h3 class="text-xl font-bold text-blue-600">
            Contact Details
        </h3>

        <!-- Location -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Location
            </label>
            <input
                type="text"
                name="location"
                id="location"
                required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="City / Area"
            >
        </div>

        <!-- Contact Number -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Contact Number
            </label>
            <input
                type="tel"
                name="contact_no"
                pattern="[0-9]{10}"
                id="contact_no"
                required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="10-digit mobile number"
            >
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Email (optional)
            </label>
            <input
                type="email"
                id="email"
                name="email"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="your@email.com"
            >
        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 transition"
        >
            Submit Request
        </button>

    </form>
</div>


<script>
     async function addProducts() {
        event.preventDefault();
        const requestType = document.getElementById('requestType').value;
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        const category = document.getElementById('category').value;
        const location = document.getElementById('location').value;
        const contact_no = document.getElementById('contact_no').value;
        const email = document.getElementById('email').value??'';
        try{
            const response=await fetch('/Request-Based-Marketplace/app/controller/addProducts.php',{
                method:'POST',
                headers:{
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({
                    request_type:requestType,
                    title:title,
                    description:description,
                    category:category,
                    location:location,
                    contact_no:contact_no,
                    email:email
                })
            })
            const data=await response.json();
            if(data.success){
                alert(data.message); 
                window.location.href='/Request-Based-Marketplace/public/pages/userRequests.php';
            }
            else{
                alert(data.message);
            }
        }
        catch(err)
        {
            console.log(err);
        }
    }
function updateCategories() {
    const type = document.getElementById('requestType').value;
    const category = document.getElementById('category');

    category.innerHTML = '<option value="">Select category</option>';

    const productCategories = [
        'Electronics',
        'Sports',
        'Furniture',
        'Books',
        'Vehicles',
        'Others'
    ];

    const serviceCategories = [
        'Plumbing',
        'Electrician',
        'Carpentry',
        'Cleaning',
        'Repair',
        'Tutoring',
        'Others'
    ];

    const list = type === 'product' ? productCategories : serviceCategories;

    list.forEach(item => {
        const option = document.createElement('option');
        option.value = item.toLowerCase();
        option.textContent = item;
        category.appendChild(option);
    });
}
</script>
