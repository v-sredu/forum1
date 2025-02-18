<?php
header("HTTP/1.0 404 Not Found");
ob_start();
?>
<main class="row error min-vh-100 justify-content-center">
    <div class="col-4 col-lg-3 col-xl-2" style="background: url('/public/img/img-404.png') no-repeat center; background-size: contain;"></div>
    <div class="col-4 col-lg-3 col-xl-2" style="background: url('/public/img/text-404.png') no-repeat center; background-size: contain"></div>
</main>
<?php
$content = ob_get_clean();
$title = 'Ошибка 404';

return template([
	'content' => $content,
	'title' => $title,
], 'empty.php');
