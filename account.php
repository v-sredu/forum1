<?php
session_start();
require_once 'functions.php';
$link = require 'connect.php';

preg_match('#user/(?<id>[0-9]+)#', $_SERVER['REQUEST_URI'], $params);
$id_user = $params['id'];
$is_user_page = !empty($_SESSION['id']) && ($_SESSION['id'] == $id_user);
$query_user = "SELECT * FROM users WHERE id = '$id_user' LIMIT 1";
$result_user = mysqli_query($link, $query_user);
$user = mysqli_fetch_assoc($result_user);

if (!$user) {
    header('Location: /404');
    die();
}

ob_start();
?>
<?php if (!empty($_SESSION['update'])) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Внимание!</strong> <?= $_SESSION['update'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;
unset($_SESSION['update']);
?>
    <div class="container p-0">
        <div class="card mb-3 bg-light">
            <div class="row p-3">
                <div class="col-auto mx-2 rounded-circle h-100px"
                     style="width: 100px; background-image: url('<?= $user['avatar'] ?>'); background-size: cover; background-position: center">
                </div>
                <div class="col text-black">
                    <h5 class="mb-2 fw-bold"><?= my_mb_ucfirst($user['name']) . ' ' . my_mb_ucfirst($user['surname']) ?></h5>
                    <p class="mb-2"><?= $user['username'] ?></p>
                    <?php if ($is_user_page): ?>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button"
                                    class="border-0 bg-transparent p-1 text-secondary link-underline link-underline-opacity-0"
                                    data-bs-toggle="modal" data-bs-target="#exist">выйти
                            </button>
                            <a href="/user/setting_account" class="border-0 bg-transparent p-1 text-info link-underline link-underline-opacity-0">настройки</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ($is_user_page): ?>
            <div class="p-2 mb-3 border-0">
                <a href="/user/create_post"
                   class="d-block btn p-2 link-underline link-underline-opacity-0 text-body-emphasis text-center text-uppercase fw-bold bg-info">
                    новый пост</a>
            </div>
        <?php endif; ?>
        <ul class="container cards p-0">
                <?php
                $query_posts = "SELECT * FROM posts WHERE user_id = '$id_user'";
                $result_posts = mysqli_query($link, $query_posts);
                for (; $row = mysqli_fetch_assoc($result_posts);) :
                ?>
            <li class="card mb-3 border-0">
                <a href="/main/<?= $row['id'] ?>" class="d-block link-underline link-underline-opacity-0 link-light">
                    <?php if (!empty($row['cover'])) : ?>
                    <div class="card-image-top" style="height: 150px; background-image: url('<?= $row['cover'] ?>'); background-position: center; background-size: cover"></div>
                <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title text-body"><?= $row['title'] ?> </h4>
                            <p class="small"><a href="/user/<?= $id_user ?>"
                                                class="link-underline link-underline-opacity-0 text-body-secondary">От
                                    <?= $user['username'] ?></a></p>
                        </div>
                        <p class="card-text text-body-secondary">
                            <?= mb_substr($row['content'], 0, 100, 'utf-8'); ?>...
                        </p>
                        <div class="ms-auto d-flex justify-content-end gap-3 small text-body-tertiary">
                            <p class="mb-0">
                                <?= $row['views'] ?> просмотров
                            </p>
                            <p class="mb-0">
                                <?php
                        $query_likes = "SELECT id FROM likes WHERE post_id = '$row[id]'";
                        echo mysqli_query($link, $query_likes) -> num_rows;
                        ?>
                                лайк</p>
                        </div>
                        <?php if ($is_user_page): ?>
                        <a href="/user/<?= $row['id'] ?>/setting_post" class="mt-3 float-end btn btn-outline-secondary p-0 font-monospace text-uppercase">
                            изменить
                        </a>
                <?php endif; ?>
                    </div>
                </a>
            </li>
                <?php endfor; ?>
        </ul>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Вы точно хотите выйти?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Вам придется снова вспоминать пароль от аккаунта...
                </div>
                <div class="modal-footer">
                    <form action="/main" method="post">
                        <input type="hidden" name="exist" value="true">
                        <button type="submit" class="btn btn-outline-secondary">выйти</button>
                    </form>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">остаться</button>
                </div>
            </div>
        </div>
    </div>
<?php
$output = ob_get_clean();
echo template('layout.php', ['content' => $output, 'title' => $user['username']]);
