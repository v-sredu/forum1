<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="overflow-x-hidden">
<header class="nav row w-100 p-2 m-0 bg-body text-center align-items-center">
    <div class="col"><a href="" class="text-decoration-none text-body">пользователи</a></div>
    <div class="col"><a href="" class="text-decoration-none text-body">посты</a></div>
    <div class="col"><a href="" class="text-decoration-none text-body">комментарии</a></div>
    <div class="col dropdown">
        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            настройки
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">сменить язык</a></li>
            <li><a class="dropdown-item" href="#">сменить тему</a></li>
        </ul>
    </div>
</header>


<main class="container-xl min-vh-100 p-2">
    <div class="wrapper  d-flex justify-content-between">
        <table class="table table-bordered table-hover text-center table-responsive">
            <thead>
            <tr>
                <th scope="col">id комментария</th>
                <th scope="col">id пользователя</th>
                <th scope="col">количество жалоб</th>
                <th scope="col">очистить жалобы</th>
                <th scope="col">удалить комментарий</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <tr class="table-danger">
                <td><a href="" class="text-decoration-none d-block">1</a></td>
                <td><a href="" class="text-decoration-none d-block">1</a></td>
                <td>1234</td>
                <td><a href="" class="text-decoration-none d-block">очистить</a></td>
                <td><a href="" class="text-decoration-none d-block">удалить</a></td>
            </tr>
            <tr class="">
                <td><a href="" class="text-decoration-none d-block">1</a></td>
                <td><a href="" class="text-decoration-none d-block">1</a></td>
                <td>1234</td>
                <td><a href="" class="text-decoration-none d-block">очистить</a></td>
                <td><a href="" class="text-decoration-none d-block">удалить</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</main>

<footer class="bg-body p-3">
    <p class="text-center text-body-secondary">сделано с любовью</p>
</footer>

<script src="/js/bootstrap.bundle.js"></script>
</body>
</html>
