<?php
require_once 'functions.php';
$link = require 'connect.php';

if (!empty($_POST)) {
    list('username' => $username, 'password' => $password) = $_POST;
    $query = "SELECT id, password FROM users WHERE username = '$username' LIMIT 1";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $user = mysqli_fetch_assoc($res);
    if (empty($user)) {
        CreateCookie('is-invalid', true);
    } else if (password_verify($password, $user['password'])) {
        DeleteCookie('is-invalid');
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['status'] = 'user';
        $id = $user['id'];
        $_SESSION['id'] = $id;
        header("Location: /user/$id");
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <title>Авторизация</title>
</head>

<body>
<main class="container mt-5 ">
    <div class="row ">
        <div class="col-7 m-auto p-0 shadow rounded-2">
            <form class="row form-control p-4 gy-3" action="" method="post">
                <div class="col">
                    <label for="validationDefault04" class="form-label fw-semibold">Никнейм</label>
                    <input type="text" name="username" class="form-control <?= !empty($_COOKIE['is-invalid']) ? 'is-invalid' : '' ?> " id="validationDefault04" value="<?= $_POST['username'] ?? '' ?>" placeholder="Нагибатор3000" required>
                </div>
                <div class="col">
                    <label for="validationDefault05" class="form-label fw-semibold">Пароль</label>
                    <input type="password" name="password" class="form-control <?= !empty($_COOKIE['is-invalid']) ? 'is-invalid' : '' ?> " id="validationDefault05"
                           placeholder="1234567890" required>
                    <div class="invalid-feedback">
                        неверный логин или пароль
                    </div>
                </div>
                <div class="col mt-5">
                    <input type="submit" class="btn btn-info light w-100 d-block" value="Войти">
                </div>
                <div class="col">
                    <p class="text-end">Нет аккаунта? <a class="link-underline link-underline-opacity-0"
                                                         href="/reg">зарегистрироваться</a></p>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
<script src="/js/bootstrap.bundle.min.js"></script>
</html>
