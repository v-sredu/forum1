<?php
function my_mb_ucfirst($str) {
	$fc = mb_strtoupper(mb_substr($str, 0, 1));
	return $fc.mb_substr($str, 1);
}

//function DeleteCookie($name): void
//{
//	if (isset($_COOKIE[$name])) {
//		setcookie($name, '', time());
//		unset($_COOKIE[$name]);
//	}
//}
//function CreateCookie($name, $text): void
//{
//	setcookie($name, $text, time() + 5);
//	$_COOKIE[$name] = $text;
//}

function get_page($pages, $uri): string
{
	foreach ($pages as $page => $pattern)
	{
		if (preg_match($pattern, $uri, $matches))
		{
			return VIEWS  . '/' . $page;
		}
	}
	return VIEWS  . '/404.php';
}

function get_component(string $component_file, $data): string
{
	extract($data);
	ob_start();
	require_once COMPONENTS . '/' . $component_file;
	return ob_get_clean();
}

function link_create($key, $var):string
{
	return http_build_query(array_merge($_GET, [$key => $var]));
}
