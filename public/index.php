<?php



$page = $_GET['page'] ?? 'home';

if($page=="login"|| $page=="register"){
    $path='auth';
}
else{
    $path='pages';
}


include __DIR__ . '/../public/includes/header.php';
$file = __DIR__ . '/../public/' . $path . '/' . $page . '.php';

if (file_exists($file)) {
    ?>
    <div id="main" class="min-h-screen mt-4">   
    <?php

    include $file;

    ?>
    </div>
    <?php
} else {
    echo "Page not found";
}

include __DIR__ . '/../public/includes/footer.php';
?>