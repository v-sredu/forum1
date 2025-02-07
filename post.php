<?php
session_start();
require_once 'functions.php';
$link = require 'connect.php';

preg_match('#main/(?<id>[0-9]+)#', $_SERVER['REQUEST_URI'], $params);
$post_id = $params['id'];
$query = "SELECT * FROM posts WHERE id = '$post_id'";
$post = mysqli_fetch_assoc(mysqli_query($link, $query));
if (!$post) {
    header('Location: /404');
    die();
}

$auth = !empty($_SESSION['auth']);
if ($auth) {
    $user_id = $_SESSION['id'];
    $query = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
    $have_like = !empty(mysqli_fetch_assoc(mysqli_query($link, $query)));
}

$query = "UPDATE posts SET views = views + 1 WHERE id = '$post_id'";
mysqli_query($link, $query);
$query = "SELECT * FROM likes WHERE post_id = '$post_id'";
$likes = mysqli_query($link, $query)->num_rows;

//--------comments---
$query = "SELECT comments.id, comments.parent_id, comments.user_id, comments.text, users.username, users.avatar FROM comments LEFT JOIN users ON users.id = comments.user_id WHERE comments.post_id = '$post_id'";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
for (; $row = mysqli_fetch_assoc($res); $data[] = $row);

if (!empty($data)) {
    foreach ($data as $item) {
        $arr_comments[(int)$item['id']] = $item;
    }
    foreach ($arr_comments as $id => $item) {
        if (isset($item['parent_id'], $arr_comments[(int)$item['parent_id']])) {
            $arr_comments[(int)$item['parent_id']]['children'][] =& $arr_comments[$id];
        }
    }
    foreach ($arr_comments as $id => $item) {
        if (isset($item['parent_id'])) {
            unset($arr_comments[$id]);
        }
    }
    function createComments($arr, $auth, $this_user = -1)
    {
        foreach ($arr as $item) {
            $id = $item['id'];
            $user_id = $item['user_id'];
            $avatar = $item['avatar'];
            $username = $item['username'];
            $text = $item['text'];
            if ($auth) {
                $buttonSubmit = "<a class='text-info small link-underline link-underline-opacity-0' data-bs-toggle='collapse'
                   href='#collapseExample$id' role='button' aria-expanded='false' aria-controls='collapseExample$id'>ответить</a>";
            } else {
                $buttonSubmit = "<a class='text-info small link-underline link-underline-opacity-0'
                    role='button' data-bs-toggle='modal' data-bs-target='#auth' >
                ответить</a>";
            }
            $delete = ($user_id === $this_user) ? "
                <form action='' method='post' class='d-inline'>
                    <input type='hidden' value='$id' name='id'>
                    <input class='bg-transparent border-0 small text-danger-emphasis opacity-50' type='submit' value='удалить' name='delete'>
                </form>" : '';
            echo "
<div class='ps-2 border-start border-secondary-subtle'>
    <div class='d-flex gap-3'>
        <a href='/user/$user_id' class='d-block rounded-circle'
           style='width: 40px; height: 40px; background-image: url($avatar); background-size: cover; background-position: center'>
        </a>
        <div class='mb-3 w-100'>
            <p><a href='/user/$user_id' class='text-body-secondary small link-underline link-underline-opacity-0'>$username</a>
            </p>
            <p class='mb-2 small'>$text</p>
            <div class='d-flex justify-content-between'>
                <div>
                    $buttonSubmit
                </div>
                    $delete
            </div>
        </div>
    </div>
    <div class='ps-5'>
        <div class=' collapse' id='collapseExample$id'>
            <form action='' method='post'>
                <input type='hidden' value='$id' name='parent_id'>
                <label for='exampleFormControlTextarea$id' class='form-label'>Мое всем нужное
                    мнение</label>
                <textarea class='form-control border-dark-subtle w-100 mb-2 small' maxlength='300'
                          id='exampleFormControlTextarea$id' rows='5' name='comment' required></textarea>
                <div class='d-flex justify-content-end'>
                    <input type='submit' class='btn text-warning small p-1' value='отправить'>
                    <button class='btn text-secondary small p-1' type='button' data-bs-toggle='collapse'
                            data-bs-target='#collapseExample$id' aria-expanded='false'
                            aria-controls='collapseExample$id'>
                        отмена
                    </button>
                </div>
            </form>
        </div>";
            if (!empty($item['children'])) {
                $item['children'] = createComments($item['children'], $auth, $this_user);
            }
            echo "</div></div>";
        }
        return $arr;
    }
}

    if (!empty($_POST['comment'])) {
        $text = nl2br(htmlspecialchars($_POST['comment']));
        $parent_id = $_POST['parent_id'];
        if ($parent_id === 'main') {
            $query = "INSERT INTO comments (post_id, user_id, text, parent_id) VALUES ('$post_id', '$user_id', '$text', DEFAULT)";
        } else {
            $query = "INSERT INTO comments (post_id, user_id, text, parent_id) VALUES ('$post_id', '$user_id', '$text', '$parent_id')";
        }
        mysqli_query($link, $query);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        die();
    }

    if (!empty($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM comments WHERE id = '$id'";
        mysqli_query($link, $query);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        die();
    }
//----------------------------

if (!empty($_POST['like'])) {
    $query = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
    $have_like = mysqli_fetch_assoc(mysqli_query($link, $query));
    if ($have_like) {
        $query = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
    } else {
        $query = "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')";
    }
    mysqli_query($link, $query);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die();
}

ob_start();
?>
    <div class="col">
        <?php if (!empty($post['cover'])) : ?>
            <div class="mb-4"
                 style="height: 150px; background-image: url('<?= $post['cover'] ?>'); background-position: center; background-size: cover"></div>
        <?php endif; ?>
        <h4 class="mb-4"><?= $post['title'] ?></h4>
        <p><?= $post['content'] ?></p>
        <div class="d-flex justify-content-end align-items-center gap-3 mb-3  text-muted">
            <div><?= $post['views'] ?> просмотр</div>
            <?php if ($auth) : ?>
                <form action="" method="post">
                    <input type="hidden" value="click" name="like">
                    <button class="bg-transparent  border-0 text-muted" type="submit">
                        <img src="/img/icons/<?= $have_like ? 'heart_fill.svg' : 'heart.svg' ?>" class="" alt=""
                             width="20" height="20"/>
                        <?= $likes ?>
                    </button>
                </form>
            <?php else: ?>
                <button class="bg-transparent  border-0" role="button" data-bs-toggle="modal" data-bs-target="#auth">
                    <img src="/img/icons/heart.svg" class="" alt="" width="20" height="20"/>
                    <?= $likes ?>
                </button>
            <?php endif; ?>
        </div>
        <?php if ($auth) : ?>
            <a class="w-100 light btn btn-outline-secondary text-center mb-3 small"
               data-bs-toggle="collapse"
               href="#newCommentMain" role="button"
               aria-expanded="false"
               aria-controls="collapseExample">
                ответить
            </a>
        <?php else: ?>
            <button class="w-100 light btn btn-outline-secondary text-center mb-3 small"
                    role="button"
                    data-bs-toggle="modal" data-bs-target="#auth"
            >
                ответить
            </button>
        <?php endif; ?>

        <!--                comments-->
        <section class="comments p-3 bg-body">
            <div class="collapse" id="newCommentMain">
                <form action="" method="post">
                    <input type="hidden" value="main" name="parent_id">
                    <label for="exampleFormControlTextareaMain" class="form-label">Мое всем нужное мнение</label>
                    <textarea class="form-control border-dark-subtle w-100 mb-2 small" name="comment"
                              maxlength="300" minlength="1" id="exampleFormControlTextareaMain" rows="5"
                              required></textarea>
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn text-warning small p-1" value="отправить">
                        <button class="btn text-secondary small p-1" type="button" data-bs-toggle="collapse"
                                data-bs-target="#newCommentMain" aria-expanded="false"
                                aria-controls="collapseExample">
                            отмена
                        </button>
                    </div>
                </form>
            </div>
            <?php !empty($data) ?  ($auth  ? createComments($arr_comments, $auth, $user_id) : createComments($arr_comments, $auth)) : 'пока комментариев нет ¯\_(ツ)_/¯'?>
        </section>
    </div>

    <!------modal----->
    <div class="modal fade" id="auth" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Сначала войдите в аккаунт</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="/auth" class="text-muted link-underline link-underline-opacity-0">Вход</a>
                    /
                    <a href="/reg" class="text-muted link-underline link-underline-opacity-0">Регистрация</a>
                </div>
            </div>
        </div>
    </div>
<?php
$output = ob_get_clean();

echo template('layout.php', ['content' => $output, 'title' => $post['title']]);
