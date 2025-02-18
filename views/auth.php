<?php
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
?>
<main class="row min-vh-100 mt-5 justify-content-center">
    <div class="mw-500 col-11">
        <div class="form-control p-4 rounded-5 border-5 border-warning-subtle">
            <form action="" method="post" class="form row flex-column gy-3">
                <div class="col">
                    <label for="username" class="form-label fw-semibold">Имя</label>
                    <input type="text" name="username" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="username"
                           placeholder="имя юзера" min="3"
                           required>
                </div>
                <div class="col">
                    <label for="password" class="form-label fw-semibold">Пароль</label>
                    <input type="password" name="password" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="password"
                           placeholder="1234567890" required>
                </div>
                <div class="col mt-5">
                    <input type="submit" class="btn btn-warning w-100 p-2" value="Войти">
                </div>
                <div class="col">
                <p class="text-end">Нет аккаунта? <a class="text-decoration-none"
                                                          href="/reg">зарегистрироваться</a></p>
                </div>
            </form>
        </div>
    </div>
</main>
<?php
$content = ob_get_clean();
$title = 'Авторизация';

return template([
'content' => $content,
'title' => $title,
'user_data' => $user_data
], 'empty.php');
