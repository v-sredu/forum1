<?php
header("HTTP/1.0 404 Not Found");
$user_data = $_COOKIE['user'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?=$user_data['theme'] ?? 'light'?>">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/style.css">
	<title>404 Not Found</title>
</head>
<body>
<main class="row error min-vh-100 justify-content-center">
    <div class="col-4 col-lg-3 col-xl-2" style="background: url('/public/img/img-404.png') no-repeat center; background-size: contain;"></div>
    <div class="col-4 col-lg-3 col-xl-2" style="background: url('/public/img/text-404.png') no-repeat center; background-size: contain"></div>
</main>
<script src="/public/js/script.js"></script>
</body>
</html>
