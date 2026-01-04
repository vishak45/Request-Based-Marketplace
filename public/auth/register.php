<?php

 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['user_id']))
{
    header("Location: /Request-Based-Marketplace/public/index.php?page=home");
    exit();
}

?>



   
    <script>
        async function register(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;  
            if(password !== confirmPassword){
                alert('Passwords do not match');
                return;
            }
            try{
                const response=await fetch('/Request-Based-Marketplace/app/auth/registerAuth.php', {
                    method:"POST",
                    headers:{
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({name, email, password})
                })
                const data=await response.json();
                if(response.ok && data.success){
                    alert(data.message);
                    window.location.href = '/Request-Based-Marketplace/public/index.php?page=login';
                }
                else if(!response.ok){
                    alert(data.message);

                }
            }
            catch{
                console.log(error);
                alert('Something went wrong');
            }
        }
    </script>


    <div class="bg-white p-8 rounded-lg shadow-md w-full mx-auto max-w-2xl">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">
            Create an Account
        </h2>

        <!-- Register Form -->
        <form onsubmit="register(event)"
              method="POST"
              class="space-y-4">

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    placeholder="John Doe"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    placeholder="you@example.com"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    minlength="6"
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                </label>
                <input
                    type="password"
                    name="confirm_password"
                    id="confirm-password"
                    required
                    minlength="6"
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition">
                Register
            </button>

        </form>

        <!-- Footer -->
        <p class="text-sm text-center text-gray-600 mt-4">
            Already have an account?
            <a href="/Request-Based-Marketplace/public/index.php?page=login"
               class="text-blue-600 hover:underline">
                Login
            </a>
        </p>

    </div>


