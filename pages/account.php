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
                </section>
            </div>
        </div>

    </div>
</header>


<main class="container-xl mb-2 min-vh-100 d-flex justify-content-between p-0">
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

        <div class="profile mb-2 card border-0">
            <div class="card-image-top"
                 style="background: url('/img/avatars/none.jpg') no-repeat center; background-size: cover; height: 100px">
            </div>
            <div class="card-body p-2">
                <div class="d-flex flex-column align-items-center align-items-md-start flex-sm-row text-center text-sm-start">
                    <div class="profile-avatar mx-4 mb-3 rounded-circle"
                         style="width: 100px; height: 100px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;">
                    </div>
                        <div class="profile-info lh-1">
                            <h1 class="card-title fw-bold fs-4">username</h1>
                            <p class="text-muted">123 подписчиков, 23 поста</p>
                        </div>
                    <button type="button" class="btn border-0 p-0 ms-sm-auto mb-1" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Пожаловаться">
                        <img src="/img/icons/exclamation.svg" alt="complaint" width="20" height="20">
                    </button>
                        <button type="submit" class="btn btn-sm btn-info align-self-stretch align-self-md-start">Подписаться</button>
                    </div>
            </div>
        </div>

        <div class="wrapper d-flex">
            <section class="col p-4 mt-0">
                <div class="d-flex align-items-center mb-2">
                    <div class="border-top w-100">
                    </div>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle btn-sm border-0" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            Сортировать по:
                        </button>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item small" href="#">По дате</a></li>
                            <li><a class="dropdown-item small" href="#">По лайкам</a></li>
                            <li><a class="dropdown-item small" href="#">По просмотрам</a></li>
                        </ul>
                    </div>
                </div>

                <div class="cards mb-4 d-flex flex-column gap-3">
                    <div class="card border-0 rounded-4 p-2">
                        <div class="card-body">
                            <div class="card-top d-flex justify-content-between">
                                <div class="user d-flex gap-3">
                                    <a href="" class="d-block text-decoration-none small rounded-2"
                                       style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
                                    <div class="lh-1">
                                        <p class="m-0 text-body">username </p>
                                        <p class="text-muted small mt-2">23:12 12 мая 2023</p>
                                    </div>
                                </div>
                                <div class="wrapper">
                                    <button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Пожаловаться">
                                        <img src="/img/icons/exclamation.svg" alt="complaint" width="20" height="20">
                                    </button>
                                </div>
                            </div>
                            <a class="mb-3 text-decoration-none d-block text-body" href="#">
                                <h3 class="card-title fs-5">Заголовок карточки</h3>
                                <p class="card-text">Это более широкая карточка с вспомогательным текстом ниже в
                                    качестве
                                    естественного перму контенту. Этот контент немного...</p>
                            </a>
                            <div class="tag-group mb-3 d-flex flex-wrap gap-2">
                                <a href="#"
                                   class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#Default</a>
                                <a href="#"
                                   class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#Default</a>
                                <a href="#"
                                   class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#Default</a>
                                <a href="#"
                                   class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#Default</a>
                                <a href="#"
                                   class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#Default</a>
                                <a href="#"
                                   class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#Default</a>
                                <a href="#"
                                   class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#Default</a>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn border-0 p-0 text-muted d-flex align-items-center gap-1">
                                    <span>123</span><img
                                        src="/img/icons/like.svg" alt="likes" width="16" height="16"></button>
                                <a href=""
                                   class="text-decoration-none text-muted d-flex align-items-center gap-1"><span>123</span><img
                                        src="/img/icons/chat.svg" alt="chat" width="16" height="16"></a>
                                <div class="text-muted d-flex align-items-center gap-1"><span>123</span><img
                                        src="/img/icons/views.svg" alt="views" width="16" height="16"></div>
                                <button class="btn border-0 p-0 text-muted d-flex align-items-center gap-1">
                                    <img src="/img/icons/bookmark.svg" alt="bookmark" width="16" height="16"></button>
                                <button class="btn ms-auto border-0 p-0 text-muted d-flex align-items-center gap-1"><img
                                        src="/img/icons/share.svg" alt="share" width="16" height="16"></button>
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
