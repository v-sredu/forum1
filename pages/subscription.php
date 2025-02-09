<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
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
                <div class="offcanvas-body">
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
                                <a href="#"
                                   class="list-group-item border-0 bg-transparent text-uppercase rounded-3 active">новое</a>
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
                </>
            </div>
        </div>

    </div>
</header>


<main class="container-xl mb-2 min-vh-100 d-flex justify-content-between p-0">
    <div class="d-none d-sm-block col-3 col-lg-2 p-3 border-end text-center">
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
    </div>

    <div class="col wrapper">
        <div class="wrapper d-flex">
            <section class="col p-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="border-top w-100">
                    </div>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle btn-sm border-0" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            Сортировать по:
                        </button>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item small" href="#">По подписчикам</a></li>
                            <li><a class="dropdown-item small" href="#">По количеству постов</a></li>
                        </ul>
                    </div>
                </div>

                <div class="cards mb-4 d-flex flex-column gap-3">
                    <div class="card border-0 rounded-4 p-2 mb-1">
                            <div class="card-body d-flex justify-content-between">
                                <a href="" class="user d-flex gap-3 text-decoration-none">
                                    <div class="small rounded-2"
                                         style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></div>
                                    <div class="lh-2">
                                        <p class="m-0 text-body">username </p>
                                        <p class="m-0 text-body text-muted small">12 постов, 20 подписчиков</p>
                                    </div>
                                </a>
                                <div class="wrapper">
                                    <button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Пожаловаться">
                                        <img src="/img/icons/exclamation.svg" alt="complaint" width="20"
                                             height="20">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link text-body border-0 border-end">Назад</a>
                        </li>
                        <li class="page-item"><a class="page-link text-body border-top-0 border-bottom-0" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link text-body border-top-0 border-bottom-0" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link text-body border-top-0 border-bottom-0" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-body bg-warning border-0 border-start" href="#">Вперед</a>
                        </li>
                    </ul>
                </nav>
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
