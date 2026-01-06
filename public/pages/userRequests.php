<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php?page=login");
    exit;
}




// Dummy requests array for the logged-in user

?>

<script>

    document.addEventListener('DOMContentLoaded', async() => {
        try{
            const response=await fetch('/app/controller/fetchUserRequests.php',{
                method:'GET',
                headers:{
                    'Content-Type': 'application/json'
                }});
            const data=await response.json();
            if(data.success){ 
                const requests=data.requests;
                if(requests.length===0){
                    const noRequests=document.getElementById('noRequests');
                    noRequests.style.display='block';
                    return;
                }
                requests.forEach(request => {
                    const requestElement = document.createElement('div');
                    requestElement.className = 'bg-white p-6 rounded-lg shadow hover:shadow-lg transition';
                    requestElement.innerHTML = `
                        <h3 class="text-xl font-semibold mb-2">${request.title}</h3>
                        <p class="text-sm text-gray-500 mb-2">Category: ${request.category}</p>
                        <p class="text-gray-700 mb-4">${request.description}</p>
                        <div class="text-sm text-gray-600 mb-4">
                           
                            👤 Posted by ${request.posted_by}<br>
                            ✅ Status: ${request.status}

                        </div>
                        <div class="text-sm text-gray-600 mb-4 gap-2">
                        <h2 class="text-lg font-semibold mb-2">Contact Details:</h2>
                         📍 ${request.location}<br>
                        <p>Email: ${request.email}</p>
                        <p>Contact Number: ${request.contact_no}</p>
                        </div>
                        <a onclick="deleteRequest(${request.id})" class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 cursor-pointer">
                            Delete Request
                        </a>
                    `;
                    document.querySelector('.grid').appendChild(requestElement);
                });
               
            }
        }
        catch(e){
            console.log(e);
        }
    })
    async function deleteRequest(id) {
       
       try{

       
        const response=await fetch('/app/controller/deleteUserProducts.php',{
            method:'POST',
            headers:{
                'Content-Type': 'application/json'
            },
            body:JSON.stringify({
                id:id
            })
        })
        const data=await response.json();
        if(data.success){
            alert(data.message);
            location.reload();
        }
        else{
            alert(data.message);
        }
       }
    
    catch(e){
        console.log(e);
        
    }
}
</script>

<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-blue-600 mb-6">My Requests</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
    </div>

    <div id="noRequests" style="display:none">
        <h2 class="text-lg font-semibold mb-2">No Requests Found</h2>
    </div>

</div>
