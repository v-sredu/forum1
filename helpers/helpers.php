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
