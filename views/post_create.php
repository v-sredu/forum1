<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="overflow-x-hidden">
<header class="nav w-100 bg-body p-2 blur">
    <div class="container-lg d-flex justify-content-between ">
        <div class="col-1">
            <a href="#" class="d-none d-sm-block text-decoration-none font-monospace fw-bold fs-3 text-body">Forum</a>
            <a href="#" class="d-block d-sm-none text-decoration-none font-monospace fw-bold fs-3 text-body">F</a>
        </div>
        <div class="col-7 col-md-5">
            <form action="" method="get">
                <label class="visually-hidden" for="inlineFormInput">Поиск</label>
                <div class="input-group shadow-sm rounded-3">
                    <input type="text" class="form-control border-0 shadow-none bg-body-secondary" id="inlineFormInput"
                           placeholder="Поиск">
                    <button class="input-group-text border-0" type="submit"><img class="rounded-1"
                                                                                 src="/img/icons/search.svg"
                                                                                 alt="search" width="16" height="16">
                    </button>
                </div>
            </form>
        </div>
        <!--            <div class="col-1 lh-1 text-body d-none d-sm-block">-->
        <!--                <a href="" class="text-decoration-none small text-dark">вход</a> / <a href="" class="text-decoration-none small text-dark">регистрация</a>-->
        <!--            </div>-->
        <div class="col-auto d-none d-sm-block">
            <a href="" class="d-block text-decoration-none small rounded-2"
               style="width: 35px; height: 35px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
        </div>

        <div class="col-1 d-block d-sm-none">

            <button class="btn p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                <img src="/img/icons/navbar.svg" alt="navbar" width="35" height="35">
            </button>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                 aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
                </div>
                <section class="offcanvas-body">
                    <div class="p-3">
                        <div class="list-group list-group-flush mb-3">
                            <a href="" class="list-group-item rounded-3">аккаунт</a>
                            <!--                            <a href="" class="list-group-item rounded-3">войти</a>-->
                            <a href="" class="list-group-item rounded-3">избранное</a>
                            <a href="" class="list-group-item rounded-3">подписки</a>
                            <a href="" class="list-group-item rounded-3">настройки</a>
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item p-0 bg-transparent">
                                <a href="#" class="list-group-item border-0 bg-transparent text-uppercase rounded-3 active">новое</a>
                            </div>
                            <div class="list-group-item p-0 bg-transparent">
                                <a href="#" class="list-group-item border-0 bg-transparent text-uppercase rounded-3">популярное</a>
                            </div>
                            <div class="list-group-item p-0 bg-transparent">
                                <a href="#" class="list-group-item border-0 bg-transparent rounded-3">уппы списка</a>
                                <a href="#" class="list-group-item border-0 bg-transparent rounded-3">уппы списка</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>
</header>


<main class="container-xl min-vh-100 mb-2 d-flex justify-content-between p-0">
    <section class="d-none d-sm-block col-3 col-lg-2 p-3 border-end text-center">
        <div class="d-lg-none d-block  list-group list-group-flush mb-3">
            <a href="" class="list-group-item rounded-3">избранное</a>
            <a href="" class="list-group-item rounded-3">подписки</a>
            <a href="" class="list-group-item rounded-3">настройки</a>
        </div>
        <div class="list-group list-group-flush">
            <div class="list-group-item p-0 bg-transparent">
                <a href="#" class="list-group-item border-0 bg-transparent text-uppercase rounded-3 active">новое</a>
            </div>
            <div class="list-group-item p-0 bg-transparent">
                <a href="#" class="list-group-item border-0 bg-transparent text-uppercase rounded-3">популярное</a>
            </div>
            <div class="list-group-item p-0 bg-transparent">
                <a href="#" class="list-group-item border-0 bg-transparent rounded-3">уппы списка</a>
                <a href="#" class="list-group-item border-0 bg-transparent rounded-3">уппы списка</a>
            </div>
        </div>
    </section>

    <div class="col wrapper">
        <div class="wrapper d-flex">
            <section class="w-100 p-4 border-0">
                <form action="" class="form-control p-3">
                    <div class="col form-floating mb-3">
                        <input type="text" class="form-control focus-ring focus-ring-warning fs-4 fw-bold font-monospace" id="title" placeholder="title">
                        <label for="title">Заголовок</label>
                    </div>
                    <div class="col form-floating mb-3">
                        <textarea class="form-control focus-ring focus-ring-warning" name="text" id="text" placeholder="Введите текст" style="height: 800px"></textarea>
                        <label for="text">Введите текст</label>
                    </div>
                    <div class="col form-floating mb-3">
                        <input type="text" class="form-control focus-ring focus-ring-warning" id="tag" placeholder="title">
                        <label for="tag">введите теги через запятую</label>
                    </div>
                    <div class="col text-end">
                        <input class="btn btn-warning" type="submit" value="опубликовать">
                    </div>
                </form>
            </section>

            <section class="d-none d-lg-block col-2 p-3 border-start">
                <div class="list-group list-group-flush text-center">
                    <a href="" class="list-group-item rounded-3">избранное</a>
                    <a href="" class="list-group-item rounded-3">подписки</a>
                    <a href="" class="list-group-item rounded-3">настройки</a>
                </div>
            </section>
        </div>
    </div>

</main>
<footer class="bg-body p-3">
    <p class="text-center text-body-secondary">сделано с любовью</p>
</footer>

<!--modal-->
<div class="modal fade" id="modalAuth" tabindex="-1" aria-labelledby="modalAuthLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAuthLabel">Сначала войдите в аккаунт</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <a href="" class="text-muted text-decoration-none">Вход</a>
                /
                <a href="" class="text-muted text-decoration-none">Регистрация</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalExit" tabindex="-1" aria-labelledby="modalExitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExitLabel">Вы точно хотите выйти?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Вам придется снова вспоминать пароль от аккаунта...
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <input type="hidden" name="exist" value="true">
                    <button type="submit" class="btn">выйти</button>
                </form>
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">остаться</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/bootstrap.bundle.js"></script>
<script src="/js/script.js"></script>
</body>
</html>
