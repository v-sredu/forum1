<?php
define("ROOT", dirname(__DIR__) . '\\');
const LAYOUT = ROOT . 'layout\\';
const PAGES = ROOT . 'pages\\';
const HOSTNAME = 'MySQL-8.2';
const DATABASE = 'forum1';
const USERNAME = 'root';
const PASSWORD = '';
const CHARSET = 'utf8';

const OPTIONS = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];

//количество выводимых постов на странице
const PAGE_SIZE = 3;
