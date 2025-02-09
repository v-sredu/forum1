<?php
$id = $_SESSION['id'];

preg_match('#user/(?<id>[0-9]+)/setting_post#', $_SERVER['REQUEST_URI'], $params);
$post_id = $params['id'];
$query = "SELECT * FROM posts WHERE id = '$post_id'";
$post = mysqli_fetch_assoc(mysqli_query($link, $query));

if (!empty($_POST['title'])) {
    ['title' => $title, 'content' => $content, 'theme' => $theme_id] = $_POST;
    $content = nl2br(htmlspecialchars($content));
    $query = "UPDATE posts SET
    theme_id = '$theme_id',
    title = '$title',
    content = '$content'
    WHERE id = '$post_id'";
    if (!empty($_FILES) && $_FILES['cover']['size'] > 0) {
        if ($_FILES['cover']['size'] > 1048576) {
            CreateCookie('is_invalid_file', true);
            CreateCookie('error_file', 'максимальный размер файла 1мб');
        } else if ($_FILES['cover']['type'] !== 'image/jpeg' && $_FILES['cover']['type'] !== 'image/png') {
            CreateCookie('is_invalid_file', true);
            CreateCookie('error_file', 'допустимый тип файла .jpg и .png');
        } else {
            DeleteCookie('is_invalid_file');
            DeleteCookie('error_file');

            mysqli_query($link, $query) or die(mysqli_error($link));
            $id_posts = mysqli_insert_id($link);

            $name_file = $_FILES['cover']['type'] === 'image/jpeg' ? $id_posts . '.jpg' : $id_posts . '.png';
            $url = 'img/covers/' . $name_file;
            move_uploaded_file($_FILES['cover']['tmp_name'], $url);

            $add_file = "UPDATE posts SET cover = '/$url' WHERE id = '$id_posts'";
            mysqli_query($link, $add_file) or die(mysqli_error($link));

            header("Location: /user/$id");
            die();
        }
    } else {
        mysqli_query($link, $query) or die(mysqli_error($link));
        header("Location: /user/$id");
        die();
    }
}

ob_start();
?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="formFile" class="form-label">Обложка поста</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
        <input class="form-control <?= !empty($_COOKIE['is_invalid_file']) ? 'is-invalid' : '' ?>" type="file"
               name="cover" accept=".jpg,.png" id="formFile">
        <div class="invalid-feedback">
            <?= $_COOKIE['error_file'] ?>
        </div>
        <label for="validationCustom03" class="form-label mt-3">Заголовок</label>
        <input type="text" minlength="1" class="form-control mb-3" id="validationCustom03" name="title" value="<?= $post['title'] ?>" required>
        <label for="themes" class="form-label">Выбрать тему</label>
        <select class="form-select light" id="themes" name="theme" aria-label="Default select example" required>
            <?php
            $query = "SELECT * FROM themes";
            $result = mysqli_query($link, $query);
            for ($row = mysqli_fetch_assoc($result); $row = mysqli_fetch_assoc($result);) : ?>
                <option value="<?= $row['id'] ?>" <?= ($row['id'] === $post['theme_id']) ? 'selected' : '' ?>><?= $row['theme'] ?></option>
            <?php endfor; ?>
        </select>
        <label for="validationTextarea" class="form-label">Текст</label>
        <textarea class="form-control border-dark-subtle w-100 mb-3" id="validationTextarea" name="content" rows="20"
                  maxlength="4000"  minlength="100" placeholder="От НЛО спасают шапочки из фольги..." required><?= $post['content'] ?></textarea>
        <input type="submit" value="Отправить" class="btn btn-info border-0 float-end">
    </form>
<?php
$output = ob_get_clean();
echo template('layout.php', ['content' => $output, 'title' => 'Изменение поста']);
