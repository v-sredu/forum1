<?php
function template($data, $layout = 'default.php'): bool|string
{
	extract($data);
	ob_start();
	require_once LAYOUT . '/' . $layout;

	return ob_get_clean();
}

function abort($error): void
{
	http_response_code($error);
	header("Location: " . '/' . $error);
	die;
}

function checkForm($avatar, $name, $surname, $username, $password, $repeat_password): bool|string
{
	if (empty($name) || empty($surname) || empty($username) || empty($password) || empty($repeat_password))
	{
		return 'Не все поля заполнены';
	}

	$isExist = DB->check('users WHERE username = :username', ['username' => $username]);
	if ($isExist)
	{
		return 'Данный username существует';
	}

	if (!preg_match('/^[-+0-9a-zA-Z!@#_$%^&*(),.?":{}|<=>]+$/', $password))
	{
		return 'Пароль должен содержать только буквы латинского алфавита, цифры и специальные символы';
	}

	if (8>strlen($password) || strlen($password)>20)
	{
		return "Длина пароля должна быть от 8 до 20 символов";
	}

	if (!preg_match('/[A-Z]/', $password))
	{
		return "Пароль должен содержать хотя бы одну заглавную букву";
	}

	if (!preg_match('/[a-z]/', $password))
	{
		return "Пароль должен содержать хотя бы одну строчную букву.";
	}

	if (!preg_match('/\d/', $password))
	{
		return "Пароль должен содержать хотя бы одну цифру.";
	}

	if (!preg_match('/[-+!@#_$%^&*(),.?":{}|<=>]/', $password))
	{
		return "Пароль должен содержать хотя бы один специальный символ.";
	}
	if ($password !== $repeat_password)
	{
		return 'Пароли не совпадают';
	}
	if (!empty($avatar) && $avatar['size']>102400)
	{
		return 'Размер изображения должен быть меньше 100кб';
	}
	return false;
}

function get_page($pages, $uri): string
{
	foreach ($pages as $page => $pattern)
	{
		if (preg_match($pattern, $uri))
		{
			return require_once VIEWS . '/' . $page;
		}
	}
	return require_once VIEWS . '/404.php';
}

function get_component(string $component_file, $data): string
{
	extract($data);
	ob_start();
	require_once COMPONENTS . '/' . $component_file;

	return ob_get_clean();
}

function link_create($key, $var): string
{
	unset($_GET['page']);
	$uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
	$uri = explode('?', $uri)[0];

	return $uri . '?' . http_build_query(array_merge($_GET, [$key => $var]));
}
