<?php
//header("HTTP/1.0 404 Not Found");
$title = "404 Not Found";
require_once LAYOUT . '/empty/header.php';
?>

<main class="row error min-vh-100 justify-content-center">
    <div class="col-4 col-lg-3 col-xl-2" style="background: url('/public/img/img-404.png') no-repeat center; background-size: contain;"></div>
    <div class="col-4 col-lg-3 col-xl-2" style="background: url('/public/img/text-404.png') no-repeat center; background-size: contain"></div>
</main>
404
<?php
require_once LAYOUT . '/empty/footer.php';
