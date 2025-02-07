<?php
$link = require 'connect.php';
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body>
<header class="p-1 bg-body-tertiary">
    <div class="container-xl mx-auto p-3">
        <div class="d-flex justify-content-between">
            <div class="col-1 main-page">
                <a href="/main" class="d-block h-100"
                   style="background: url('/img/icons/sun.svg') no-repeat; background-size: contain;"></a>
            </div>
            <div class="col-5">
                <form class="d-flex search my-auto" action="/main" method="get">
                    <input class="form-control me-1 border-info border-1" type="search" name="key_words"
                           placeholder="Поиск" aria-label="Search">
                    <button class="btn btn-info light " type="submit">
                        <img src="/img/icons/search.svg"/></button>
                </form>
            </div>
            <?php if (!empty($_SESSION['auth'])) {
            $id = $_SESSION['id'];
            $query = "SELECT avatar FROM users WHERE id='$id'";
            $result_avatar = mysqli_query($link, $query);
            $url_avatar = mysqli_fetch_assoc($result_avatar)['avatar'];
            ?>
            <div class="col-auto text-light">
                <a href="/user/<?= $id ?>"
                   class="d-block border border-1 border-light rounded-circle"
                   style="width: 40px; height: 40px; background-image: url('<?= $url_avatar ?>'); background-size: cover; background-position: center"></a> <?php } else { ?>
                    <div class="col-1 text-light small text-muted lh-1 align-self-center">
                        <a href="/auth" class="text-muted link-underline link-underline-opacity-0">Вход</a>
                        /
                        <a href="/reg" class="text-muted link-underline link-underline-opacity-0">Регистрация</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
<main class="main-page">
    <div class="container-xl mx-auto m-3">
        <div class="row gap-3">
            <div class="col-md-2 p-2 bg-body-tertiary overflow-y-scroll scroll-hidden">
                <ul class="list-group list-group-flush vh-100">
                    <?php
                    $query = "SELECT * FROM themes";
                    $result_themes = mysqli_query($link, $query);
                    for (; $row = mysqli_fetch_assoc($result_themes);) : ?>
                        <li class="list-group-item"><a href="/main?theme_id=<?= $row['id'] ?>"
                                                       class="link-underline link-underline-opacity-0 text-body w-100 h-100 d-block"><?= $row['theme'] ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <div class="col p-3 bg-body-tertiary">
                <?= $content ?>
            </div>
        </div>
    </div>

</main>

<footer id="footer" class="p-4"><p class="text-body fst-italic float-end text-body-tertiary">сделано с любовью</p>
</footer>
</body>
<script src="/js/bootstrap.bundle.min.js"></script>

</html>
