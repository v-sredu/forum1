<?php
function template($__view, $__data)
{
    extract($__data);
    ob_start();
    require $__view;
    return ob_get_clean();
}

function my_mb_ucfirst($str) {
    $fc = mb_strtoupper(mb_substr($str, 0, 1));
    return $fc.mb_substr($str, 1);
}

function DeleteCookie($name): void
{
    if (isset($_COOKIE[$name])) {
        setcookie($name, '', time());
        unset($_COOKIE[$name]);
    }
}
function CreateCookie($name, $text): void
{
    setcookie($name, $text, time() + 5);
    $_COOKIE[$name] = $text;
}
