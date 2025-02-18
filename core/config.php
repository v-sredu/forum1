<?php
define("ROOT", dirname(__DIR__));
const VIEWS = ROOT . '/views';
const LAYOUT = VIEWS . '/layout';

const AVATARS = ROOT . '/public/img/avatars';
const COMPONENTS = VIEWS . '/components';
const DB_SETTINGS = [
	'host' => 'MySQL-8.2',
	'database' => 'forum1',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8mb4',
	'options' => [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	],
];

//количество выводимых постов на странице
const POST_COUNT = 3;
