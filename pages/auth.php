<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="overflow-x-hidden">

<main class="row min-vh-100 mt-5 justify-content-center">
    <div class="mw-500 col-11">
        <div class="form-control p-4 rounded-5 border-5 border-warning-subtle">
            <div class="card-img-top mb-4"
                 style="background: url(/img/form-header.gif) no-repeat center; background-size: contain; height: 200px"></div>
            <form action="" method="post" class="form row flex-column gy-3">
                <div class="col">
                    <label for="username" class="form-label fw-semibold">Имя юзера или email</label>
                    <input type="text" name="username" class="form-control focus-ring focus-ring-warning rounded-3 p-2" id="username"
                           placeholder="имя юзера"
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

<script src="/js/bootstrap.bundle.js"></script>
<script src="/js/script.js"></script>
</body>
</html>
