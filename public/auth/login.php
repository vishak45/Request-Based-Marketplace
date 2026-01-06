<?php

 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['user_id']))
{
    header("Location: /index.php?page=home");
    exit();
}

?>



    
    <script>
       async function loginUsr(event) {
        event.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        try {
            const response = await fetch('/app/auth/loginAuth.php', {
                method: 'POST',
                
               headers:{
                'Content-Type': 'application/json'
               },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (data.success) {
                console.log(data.data.id, data.data.name, data.data.email);
                alert('Login successful!');
                window.location.href = '/index.php?page=home';
            } else {
                alert('Login failed. Please check your email and password.');
            }
        } catch (error) {
            console.error('Login error', error.message);
            alert('Something went wrong. Please try again.');
        }
       }
        </script>




    <div class="bg-white p-8 rounded-lg shadow-md w-full mx-auto max-w-2xl ">
        <div >
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">
            Login to RequestMart
        </h2>

        <!-- Login Form -->
      <form onsubmit="loginUsr(event)"
              method="POST"
              class="space-y-4">

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
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
                    id="password"
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Submit -->
            <button 
           
            id="login"
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition"
            >
                Login
            </button>

        </form>

        <!-- Footer -->
        <p class="text-sm text-center text-gray-600 mt-4">
            Don’t have an account?
            <a href="/Request-Based-Marketplace/public/index.php?page=register"
               class="text-blue-600 hover:underline">
                Register
            </a>
        </p>
</div>
    </div>


