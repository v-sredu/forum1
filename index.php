<?php
session_start();
require_once 'functions.php';
$link = require 'connect.php';

if (!empty($_GET)) {
    if (!empty($_GET['theme_id'])) {
        $query_posts = "SELECT posts.id, posts.cover, posts.title, posts.content, posts.views, posts.user_id, users.username FROM posts LEFT JOIN users ON users.id = posts.user_id WHERE theme_id = '$_GET[theme_id]'";
    } elseif (!empty($_GET['key_words'])) {
        $words = '+' . str_replace(' ', ' +', $_GET['key_words']);
        $query_posts = "SELECT posts.id, posts.cover, posts.title, posts.content, posts.views, posts.user_id, users.username FROM posts LEFT JOIN users ON users.id = posts.user_id WHERE MATCH (title, content) AGAINST ('$words')";
        $query_users = "SELECT users.id, users.name, users.surname, users.username, users.avatar FROM users WHERE MATCH (name, surname, username) AGAINST ('$words')";
    }
} else {
    $query_posts = 'SELECT posts.id, posts.cover, posts.title, posts.content, posts.views, posts.user_id, users.username FROM posts  LEFT JOIN users ON users.id = posts.user_id';
}

$res = mysqli_query($link, $query_posts) or die(mysqli_error($link));
for (; $row = mysqli_fetch_assoc($res); $data_posts[] = $row) ;

if (!empty($_POST['exist'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['status']);
    unset($_SESSION['id']);
}


ob_start();
?>
    <!-----уведомление----->
<?php if (!empty($_POST['exist'])) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Внимание!</strong> Вы вышли из аккаунта.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;
//    <!--контент---!>
echo '<ul class="list-group list-group-flush">';
if (!empty($query_users)):
    $res = mysqli_query($link, $query_users);
    $have_users = true;
    for (; $row = mysqli_fetch_assoc($res);) :
        ?>
        <li class="card mb-3 bg-light">
                <a href="/user/<?= $row['id'] ?>" class="d-block link-underline link-underline-opacity-0">
            <div class="row p-3">
                <div class="col-auto card-img mx-2 rounded-circle h-100px"
                     style="width: 100px; background-image: url('<?= $row['avatar'] ?>'); background-size: cover; background-position: center">
                </div>
                <div class="col text-black">
                    <h5 class="mb-2 fw-bold"><?= my_mb_ucfirst($row['name']) . ' ' . my_mb_ucfirst($row['surname']) ?></h5>
                    <p class="mb-2"><?= $row['username'] ?></p>
                    <?php
                    $query_likes = "SELECT id FROM posts WHERE user_id = '$row[id]'";
                    $count = mysqli_query($link, $query_likes)->num_rows;
                    echo "<p class='small text-black-50'>$count пост<p>";
                    ?>
                </div>
            </div>
                </a>
        </li>
    <?php
    endfor;
endif;
if (!empty($data_posts)) :
    foreach ($data_posts as $row) :
        ?>
        <li class="card mb-3 border-0">
            <a href="/main/<?= $row['id'] ?>" class="d-block link-underline link-underline-opacity-0 link-light">
                <?php if (!empty($row['cover'])) : ?>
                    <div class="card-image-top"
                         style="height: 150px; background-image: url('<?= $row['cover'] ?>'); background-position: center; background-size: cover"></div>
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title text-body"><?= $row['title'] ?> </h4>
                        <p class="small"><a href="/user/<?= $row['user_id'] ?>"
                                            class="link-underline link-underline-opacity-0 text-body-secondary">От
                                <?= $row['username'] ?></a></p>
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
                            echo mysqli_query($link, $query_likes)->num_rows;
                            ?>
                            лайк</p>
                    </div>
                </div>
            </a>
        </li>
        </ul>
    <?php
    endforeach;
endif;
if (empty($data_posts) && empty($have_users)) echo '<p>Ничего не найдено ¯\_(ツ)_/¯</p>';
$output = ob_get_clean();
echo template('layout.php', ['content' => $output, 'title' => 'Главная страница']);
