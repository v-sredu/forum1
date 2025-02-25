<?php
if (empty($_COOKIE['user']))
{
	abort(404);
}
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
?>
<main class="w-100 p-2 p-sm-3 border-0">
	<form action="/" class="form-control p-1 p-sm-3 border-0" method="post">
		<input type="hidden" name="typePost" value="createPost">
		<div class="col form-floating mb-3">
			<input type="text" class="form-control focus-ring focus-ring-warning fs-6 font-monospace" id="title" name="title" maxlength="90"
					placeholder="title" required>
			<label for="title">Заголовок</label>
		</div>
		<div class="col form-floating mb-3">
			<textarea class="form-control focus-ring focus-ring-warning min-vh-100" name="content" id="text" required maxlength="1000"></textarea>
		</div>
		<div class="col form-floating mb-3">
			<input type="text" class="form-control focus-ring focus-ring-warning" id="tag" name="tags" placeholder="title" required>
			<label for="tag">введите теги через запятую слитно (максимум 6 тегов)</label>
		</div>
		<div class="col text-end">
			<input class="btn btn-warning" type="submit" value="опубликовать">
		</div>
	</form>
</main>
<?php
$content = ob_get_clean();
$title = '';

return template([
	'content' => $content,
	'title' => $title,
	'user_data' => $user_data
]);
