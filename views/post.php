<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
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
            <section class="w-100 p-4">
                <div class="post bg-body p-4 mb-2 rounded-3">
                    <div class="user d-flex gap-3">
                        <a href="" class="d-block text-decoration-none small rounded-2"
                           style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
                        <div class="lh-1">
                            <p class="m-0 text-body">username </p>
                            <p class="text-muted small mt-2">23:12 12 мая 2023</p>
                        </div>
                        <div class="ms-auto d-flex gap-1 align-items-center align-self-start text-muted"><span>123</span><img
                                src="/img/icons/views.svg" alt="views" width="16" height="16">
                            <button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Пожаловаться">
                                <img src="/img/icons/exclamation.svg" alt="complaint" width="20" height="20">
                            </button>
                        </div>
                    </div>
                    <h1 class="mb-4 font-monospace fw-bold fs-2">Заголовок</h1>
                    <div class="text mb-3">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, enim!</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, enim!</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, enim!</p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consequuntur, fugit id, impedit
                        ipsam minima natus officiis quasi qui quo totam voluptas? Atque deleniti dignissimos doloribus
                        facere laborum, quia vel velit! Ab, aspernatur aut culpa dignissimos error, facere incidunt
                        magnam, minima modi molestiae nam necessitatibus quia rerum sint sunt unde velit. Adipisci harum
                        nesciunt nostrum numquam perspiciatis totam voluptatem! A amet blanditiis consequatur esse fugit
                        id illo in maxime nihil totam! Dolor eum iusto nesciunt quasi veniam. Alias assumenda atque
                        cumque, dolores eum expedita itaque laudantium maxime ,
                        molestias mollitia necessitatibus nemo
                        nesciunt officia optio possimus quasi sequi similique suscipit voluptatum.
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn border-0 p-0 text-muted d-flex align-items-center gap-1">
                            <span>123</span><img
                                src="/img/icons/like.svg" alt="likes" width="16" height="16"></button>
                        <div
                                class="text-muted d-flex align-items-center gap-1"><span>123</span><img
                                src="/img/icons/chat.svg" alt="chat" width="16" height="16"></div>
                        <button class="btn border-0 p-0 text-muted d-flex align-items-center gap-1">
                            <img src="/img/icons/bookmark.svg" alt="bookmark" width="16" height="16"></button>
                        <button class="btn ms-auto border-0 p-0 text-muted d-flex align-items-center gap-1"><img
                                src="/img/icons/share.svg" alt="share" width="16" height="16"></button>
                    </div>
                </div>

                <div class="comments bg-body p-4 rounded-3">
                    <div class="w-100 btn btn-outline-secondary text-center small"
                         data-bs-toggle="collapse"
                         data-bs-target="#newCommentMain" role="button">
                        ответить
                    </div>
                    <div class="collapse mt-4" id="newCommentMain">
                        <form class="form-control border-0 p-0" action="" method="post">
                            <input type="hidden" value="main" name="parent_id">
                            <div class="form-floating">
                            <textarea class="form-control shadow-none" name="comment"
                                      maxlength="300" minlength="1" id="text"
                                      required style="height: 100px"></textarea>
                                <label for="text">комментарий</label>
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn text-warning small p-1" value="отправить">
                                <button class="btn text-secondary small p-1" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#newCommentMain">
                                    отмена
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="comments-list mt-4">
<!--                        ///////////////////////////////-->
                        <div class="comment mt-1">
                            <div class="comment-header d-flex gap-3">
                                <a href="" class="d-block text-decoration-none small rounded-2"
                                   style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
                                <div class="lh-1">
                                    <p class="m-0 text-body">username </p>
                                    <p class="text-muted small mt-2">23:12 12 мая 2023</p>
                                </div>
                                <div class="ms-auto d-flex gap-1 align-items-center align-self-start">
                                    <button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Пожаловаться">
                                        <img src="/img/icons/exclamation.svg" alt="complaint" width="20"
                                             height="20">
                                    </button>
                                </div>
                            </div>
                            <div class="comment-body">
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab deleniti
                                    dicta
                                    distinctio enim et explicabo molestias officia omnis ullam vel!</p>
                            </div>
                            <div class="comment-footer row align-items-center">
                                <div class="col-6 col-sm-8 col-lg-10 border-bottom border-secondary-subtle"></div>
                                <button class="col-auto btn btn-sm border-0" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#newComment1">Ответить
                                </button>
                                <div class="col border-bottom border-secondary-subtle"></div>
                            </div>

                            <div class="comments-list mt-1 ms-4">
                                <div class="comment mt-1">
                                    <div class="collapse" id="newComment1">
                                        <form class="form-control border-0 p-0" action="" method="post">
                                            <input type="hidden" value="1" name="parent_id">
                                            <div class="form-floating">
                                                         <textarea class="form-control shadow-none" name="comment"
                                                                   maxlength="300" minlength="1" id="text"
                                                                   required style="height: 100px">
                                                         </textarea>
                                                <label for="text">комментарий</label>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <input type="submit" class="btn text-warning small p-1"
                                                       value="отправить">
                                                <button class="btn text-secondary small p-1" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#newComment1">
                                                    отмена
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="comment mt-1">
                                    <div class="comment-header d-flex gap-3">
                                        <a href="" class="d-block text-decoration-none small rounded-2"
                                           style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
                                        <div class="lh-1">
                                            <p class="m-0 text-body">username </p>
                                            <p class="text-muted small mt-2">23:12 12 мая 2023</p>
                                        </div>
                                        <div class="ms-auto d-flex gap-1 align-items-center align-self-start">
                                            <button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Пожаловаться">
                                                <img src="/img/icons/exclamation.svg" alt="complaint" width="20"
                                                     height="20">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab
                                            deleniti
                                            dicta
                                            distinctio enim et explicabo molestias officia omnis ullam vel!</p>
                                    </div>
                                    <div class="comment-footer row align-items-center">
                                        <div class="col-6 col-sm-8 col-lg-10 border-bottom border-secondary-subtle"></div>
                                        <button class="col-auto btn btn-sm border-0" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#newComment1">Ответить
                                        </button>
                                        <div class="col border-bottom border-secondary-subtle"></div>
                                    </div>
                                    <div class="comments-list">
                                        <div class="comment mt-1">
                                            <div class="collapse" id="newComment1">
                                                <form class="form-control border-0 p-0" action="" method="post">
                                                    <input type="hidden" value="1" name="parent_id">
                                                    <div class="form-floating">
                                                         <textarea class="form-control shadow-none" name="comment"
                                                                   maxlength="300" minlength="1" id="text"
                                                                   required style="height: 100px">
                                                         </textarea>
                                                        <label for="text">комментарий</label>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <input type="submit" class="btn text-warning small p-1"
                                                               value="отправить">
                                                        <button class="btn text-secondary small p-1" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#newComment1">
                                                            отмена
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--                                ///////////////////////-->
                                <div class="comment mt-1">
                                    <div class="comment-header d-flex gap-3">
                                        <a href="" class="d-block text-decoration-none small rounded-2"
                                           style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
                                        <div class="lh-1">
                                            <p class="m-0 text-body">username </p>
                                            <p class="text-muted small mt-2">23:12 12 мая 2023</p>
                                        </div>
                                        <div class="ms-auto d-flex gap-1 align-items-center align-self-start">
                                            <button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Пожаловаться">
                                                <img src="/img/icons/exclamation.svg" alt="complaint" width="20"
                                                     height="20">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab
                                            deleniti
                                            dicta
                                            distinctio enim et explicabo molestias officia omnis ullam vel!</p>
                                    </div>
                                    <div class="comment-footer row align-items-center">
                                        <div class="col-6 col-sm-8 col-lg-10 border-bottom border-secondary-subtle"></div>
                                        <button class="col-auto btn btn-sm border-0" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#newComment1">Ответить
                                        </button>
                                        <div class="col border-bottom border-secondary-subtle"></div>
                                    </div>
                                    <div class="comments-list">
                                        <div class="comment mt-1">
                                            <div class="collapse" id="newComment1">
                                                <form class="form-control border-0 p-0" action="" method="post">
                                                    <input type="hidden" value="1" name="parent_id">
                                                    <div class="form-floating">
                                                         <textarea class="form-control shadow-none" name="comment"
                                                                   maxlength="300" minlength="1" id="text"
                                                                   required style="height: 100px">
                                                         </textarea>
                                                        <label for="text">комментарий</label>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <input type="submit" class="btn text-warning small p-1"
                                                               value="отправить">
                                                        <button class="btn text-secondary small p-1" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#newComment1">
                                                            отмена
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--                            ///////////////////-->
                            </div>
                        </div>
<!--                        //////////////////////-->
                    </div>
                </div>
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
