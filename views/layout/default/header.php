<?php
$res = DB->query('SELECT * FROM tags')->getAll();
$tags_link = '';
foreach ($res as $row)
{
	$tags_link .= "<a href='?tag=$row[id]' class='list-group-item d-inline-block p-2 mb-1 rounded-4'>$row[name]</a>";
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?=$user_data['theme']?>">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/style.css">
	<title> <?=$title?> </title>
</head>
<body class="overflow-x-hidden">
<header class="nav w-100 bg-body p-2">
	<div class="container-lg d-flex justify-content-between ">
		<div class="col-1">
			<a href="/" class="d-none d-sm-block text-decoration-none font-monospace fw-bold fs-3 text-body">Forum</a>
			<a href="/" class="d-block d-sm-none text-decoration-none font-monospace fw-bold fs-3 text-body">F</a>
		</div>
		<div class="col-7 col-md-5">
			<form action="/" method="GET">
				<label class="visually-hidden" for="inlineFormInput">Поиск</label>
				<div class="input-group shadow-sm rounded-3">
					<input type="text" class="form-control border-0 shadow-none bg-body-secondary" name="key_words"
							id="inlineFormInput"
							placeholder="Поиск">
					<button class="input-group-text border-0" type="submit">
						<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
							<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
						</svg>
					</button>
				</div>
			</form>
		</div>
		<?php if ($user_data['auth']) : ?>
			<div class="col-auto d-none d-sm-block">
				<a href="/user/<?=$user_data['username']?>" class="d-block text-decoration-none small rounded-2"
						style="width: 35px; height: 35px; background: url('/public/img/avatars/<?=$user_data['avatar'] ?>') no-repeat transparent; background-size: cover;"></a>
			</div>
		<?php else: ?>
			<div class="col-1 lh-1 text-body d-none d-sm-block">
				<a href="../../../public/index.php" class="text-decoration-none small text-dark">вход</a> / <a
						href="../../../public/index.php"
						class="text-decoration-none small text-dark">регистрация</a>
			</div>
		<?php endif; ?>
		<div class="col-1 d-block d-sm-none">

			<button class="btn p-0" type="button" id="buttonNav">
				<svg width="35" height="35" fill="currentColor" viewBox="0 0 16 16">
					<path fill-rule="evenodd"
							d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"></path>
				</svg>
			</button>
		</div>
	</div>
</header>

<div class="container-xl min-vh-100 d-flex justify-content-between p-0">
	<div class="d-none d-sm-block col-3 col-lg-2 p-3 border-end text-center">
		<div class="d-lg-none d-block  list-group list-group-flush mb-3">
			<?php if ($user_data['auth']): ?>
				<a href="/posts/favourites" class="list-group-item rounded-3">избранное</a>
				<a href="/posts/favourites-users" class="list-group-item rounded-3">подписки</a>
				<a href="../../../public/index.php" class="list-group-item rounded-3">настройки</a>
			<?php endif; ?>
		</div>
		<div class="list-group list-group-flush d-block mt-1 text-start">
			<?=$tags_link ?>
		</div>
	</div>

	<div class="col wrapper d-flex">
