<?php
session_start();
require_once 'functions.php';
$link = require 'connect.php';

if (!empty($_SESSION['auth'])) {
    $id = $_SESSION['id'];
    $query = "SELECT * FROM users WHERE id = '$id'";
    $user = mysqli_fetch_assoc(mysqli_query($link, $query));
    list('name' => $name, 'surname' => $surname, 'username' => $username, 'password' => $hash) = $user;
if (!empty($_POST)) {
    list('name' => $new_name, 'surname' => $new_surname, 'username' => $new_username, 'password' => $new_password, 'again_password' => $new_again_password) = $_POST;

    $query_user = "SELECT * FROM users WHERE username = '$new_username'";
    $res = mysqli_query($link, $query_user) or die(mysqli_error($link));
    $user = mysqli_fetch_assoc($res);


    if (!empty($user)) {
        CreateCookie('is_invalid_username', true);
        CreateCookie('error_username', 'данный пользователь уже существует');
    } else if (mb_strlen($new_username) === 0 || mb_strlen($new_username) > 10) {
        CreateCookie('is_invalid_username', true);
        CreateCookie('error_username', 'максимальная длина псевдонима 10 символов');
    } else {
        DeleteCookie('is_invalid_username');
        DeleteCookie('error_username');
        if (5 < strlen($new_password) && strlen($new_again_password) < 10) {
            CreateCookie('is_invalid_password', true);
            CreateCookie('error_password', 'длина пароля должна быть от 5 до 10 символов');
        } else if (!preg_match('#[0-9]#', $new_password)) {
            CreateCookie('is_invalid_password', true);
            CreateCookie('error_password', 'пароль должен содержать хотя бы одну цифру');
        } else if (!preg_match('#[a-zA-Z]#', $new_password)) {
            CreateCookie('is_invalid_password', true);
            CreateCookie('error_password', 'пароль должен содержать хотя бы одну латинскую букву');
        } else if ($new_password !== $new_again_password) {
            CreateCookie('is_invalid_password', true);
            CreateCookie('error_password', 'пароли не совпадают');
        } else {
            DeleteCookie('is_invalid_password');
            DeleteCookie('error_password');
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            $add_user_query = "INSERT INTO users (name, surname, username, avatar, password, status) VALUES ('$new_name', '$new_surname', '$new_username', DEFAULT, '$hash', DEFAULT)";

            if (!empty($_FILES) && $_FILES['avatar']['size'] > 0) {
                if ($_FILES['avatar']['size'] > 1048576) {
                    CreateCookie('is_invalid_file', true);
                    CreateCookie('error_file', 'максимальный размер файла 1мб');
                } else if ($_FILES['avatar']['type'] !== 'image/jpeg' && $_FILES['avatar']['type'] !== 'image/png') {
                    CreateCookie('is_invalid_file', true);
                    CreateCookie('error_file', 'допустимый тип файла .jpg и .png');
                } else {
                    DeleteCookie('is_invalid_file');
                    DeleteCookie('error_file');

                    mysqli_query($link, $add_user_query) or die(mysqli_error($link));
                    $id = mysqli_insert_id($link);

                    $name_file = $_FILES['avatar']['type'] === 'image/jpeg' ? $id . '.jpg' : $id . '.png';
                    $url = 'img/avatars/' . $name_file;
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $url);

                    $add_file = "UPDATE users SET avatar = '/$url' WHERE id = '$id'";
                    mysqli_query($link, $add_file) or die(mysqli_error($link));

                    $_SESSION['auth'] = true;
                    $_SESSION['status'] = 'user';
                    $_SESSION['id'] = $id;
                    header("Location: /user/$id");
                    die();
                }
            } else {
                mysqli_query($link, $add_user_query) or die(mysqli_error($link));
                $id = mysqli_insert_id($link);
                $_SESSION['auth'] = true;
                $_SESSION['status'] = 'user';
                $_SESSION['id'] = $id;
                header("Location: /user/$id");
                die();
            }
        }
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
    <title>Регистрация</title>
</head>

<body>
<main class="container mt-5 ">
    <div class="row ">
        <div class="col-7 m-auto p-0 shadow rounded-2 ">
            <form class="row form-control p-4 gy-3" action="" method="post" enctype="multipart/form-data">
                <div class="col">
                    <label for="validationDefault01" class="form-label fw-semibold">Ваша аватарка</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
                    <input type="file" name="avatar"
                           class="form-control <?= !empty($_COOKIE['is_invalid_file']) ? 'is-invalid' : '' ?>"
                           id="validationDefault01" aria-label="file example" accept=".jpg,.png">
                    <div class="invalid-feedback">
                        <?= $_COOKIE['error_file'] ?>
                    </div>
                </div>
                <div class="col">
                    <label for="validationDefault02" class="form-label fw-semibold">Имя</label>
                    <input type="text" name="name" class="form-control <?= !empty($_POST['name']) ? 'is-valid' : '' ?>"
                           id="validationDefault02" placeholder="Иван" value="<?= $_POST['name'] ?? '' ?>"
                           required>
                </div>
                <div class="col">
                    <label for="validationDefault03" class="form-label fw-semibold">Фамилия</label>
                    <input type="text" name="surname"
                           class="form-control <?= !empty($_POST['surname']) ? 'is-valid' : '' ?>"
                           id="validationDefault03" placeholder="Иванович" value="<?= $_POST['surname'] ?? '' ?>"
                           required>
                </div>
                <div class="col">
                    <label for="validationDefault04" class="form-label fw-semibold">Никнейм</label>
                    <input type="text" name="username"
                           class="form-control <?= !empty($_POST['username']) ? (!empty($_COOKIE['is_invalid_username']) ? 'is-invalid' : 'is-valid') : '' ?>"
                           id="validationDefault04" placeholder="Нагибатор3000" value="<?= $_POST['username'] ?? '' ?>"
                           required>
                    <div class="invalid-feedback">
                        <?= $_COOKIE['error_username'] ?>
                    </div>
                </div>
                <div class="col">
                    <label for="validationDefault05" class="form-label fw-semibold">Пароль</label>
                    <input type="password" name="password"
                           class="form-control <?= !empty($_POST['password']) ? (!empty($_COOKIE['is_invalid_password']) ? 'is-invalid' : '') : '' ?> "
                           id="validationDefault05"
                           placeholder="1234567890 пожалуйста, не вводите" required>
                    <div class="invalid-feedback">
                        <?= $_COOKIE['error_password'] ?>
                    </div>
                </div>
                <div class="col">
                    <label for="validationDefault06" class="form-label fw-semibold">Повторите пароль</label>
                    <input type="password" name="again_password" class="form-control" id="validationDefault06" required>
                </div>
                <div class="col mt-5">
                    <input type="submit" class="btn btn-info light w-100 d-block" value="Зарегаться">
                </div>
                <div class="col">
                    <p class="text-end">Есть аккаунт? <a class="link-underline link-underline-opacity-0"
                                                         href="/auth">войти</a></p>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
<script src="/js/bootstrap.bundle.min.js"></script>
</html>
<?php
} else {
    Header("location: /404.php");
}
