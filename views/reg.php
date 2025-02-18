<?php
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
?>
	<main class="row min-vh-100 mt-5 justify-content-center">
		<div class="mw-500 col-11">
			<div class="alert alert-danger d-none" role="alert">
			</div>
			<div class="form-control p-4 rounded-5 border-5 border-warning-subtle">
				<form action="" method="get" class="form row flex-column gy-3" id="formUserData" enctype="multipart/form-data">
					<input type="hidden" name="typePost" value="reg">
					<div class="col">
						<label for="formFile" class="form-label">Выберите аватар</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="102400" />
						<input class="form-control" name="file" type="file" id="formFile" accept=".jpg, .png">
					</div>
					<div class="col">
						<label for="name" class="form-label">Имя</label>
						<input type="text" name="name" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="name"
								placeholder="name"
								required>
					</div>
					<div class="col">
						<label for="surname" class="form-label">Фамилия</label>
						<input type="text" name="surname" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="surname"
								placeholder="surname"
								required>
					</div>
					<div class="col">
						<label for="username" class="form-label">Никнейм</label>
						<input type="text" name="username" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="username"
								placeholder="username"
								required>
					</div>
					<div class="col">
						<label for="password" class="form-label">Пароль</label>
						<input type="text" name="password" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="password"
								placeholder="1234567890" required>
					</div>
					<div class="col">
						<label for="repeatPassword" class="form-label">Повторите пароль</label>
						<input type="text" name="repeatPassword" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="repeatPassword"
								placeholder="1234567890" required>
					</div>
					<div class="col mt-5">
						<input type="submit" class="btn btn-warning w-100 p-2" value="Регистрация">
					</div>
					<div class="col">
						<p class="text-end">Есть аккаунт? <a class="text-decoration-none"
									href="/auth">Войти</a></p>
					</div>
				</form>
			</div>
		</div>
	</main>
<?php
$content = ob_get_clean();
$title = 'Регистрация';

return template([
	'content' => $content,
	'title' => $title,
	'user_data' => $user_data
], 'empty.php');
