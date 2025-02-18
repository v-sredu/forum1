<?php
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
?>
            <main class="w-100 p-4">
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
            </main>
<?php
$content = ob_get_clean();
$title = '';

return template([
	'content' => $content,
	'title' => $title,
	'user_data' => $user_data
]);
