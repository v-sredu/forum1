<!DOCTYPE html>
<html lang="en" data-bs-theme="<?=$user_data['theme'] ?? 'light'?>">
<head>
	<meta charset="UTF-8">
	<title> <?= $title ?></title>
	<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/style.css">
</head>
<body class="overflow-x-hidden">
<?= $content ?>
<script src="/public/js/script.js"></script>
</body>
</html>
