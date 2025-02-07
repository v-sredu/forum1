<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//error_reporting(0);
//ini_set('display_errors', 'off');

$host = 'MySQL-8.2';
$user ='root';
$pass = '';
$db = 'forum1';

$link = mysqli_connect($host, $user, $pass, $db);
return $link;
