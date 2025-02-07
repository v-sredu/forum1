<?php
session_start();
require_once 'functions.php';
$link = require 'connect.php';
$id = $_SESSION['id'];

if (!empty($_POST['title'])) {
    list('title' => $title, 'content' => $content, 'theme' => $theme_id) = $_POST;
    $content = nl2br(htmlspecialchars($content));
    $query = "INSERT INTO posts (theme_id, cover, title, content, user_id, views) VALUES ('$theme_id', DEFAULT, '$title', '$content', '$id',  DEFAULT)";
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
        <input type="text" minlength="1" class="form-control mb-3" id="validationCustom03" name="title" required>
        <label for="themes" class="form-label">Выбрать тему</label>
        <select class="form-select light" id="themes" name="theme" aria-label="Default select example" required>
            <option value="1" selected>другое</option>
            <?php
            $query = "SELECT * FROM themes";
            $result = mysqli_query($link, $query);
            for ($row = mysqli_fetch_assoc($result); $row = mysqli_fetch_assoc($result);) : ?>
                <option value="<?= $row['id'] ?>"><?= $row['theme'] ?></option>
            <?php endfor; ?>
        </select>
        <label for="validationTextarea" class="form-label">Текст</label>
        <textarea class="form-control border-dark-subtle w-100 mb-3" id="validationTextarea" name="content" rows="20"
              maxlength="4000"  minlength="100"  placeholder="От НЛО спасают шапочки из фольги..." required></textarea>
        <input type="submit" value="Отправить" class="btn btn-info border-0 float-end">
    </form>
<?php
$output = ob_get_clean();
echo template('layout.php', ['content' => $output, 'title' => 'Создание поста']);
