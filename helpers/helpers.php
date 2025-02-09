<?php
function template($view, $content): void
{
	extract($content);
	require LAYOUT . $view;
	echo ob_get_clean();
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

function get_page($pages, $uri): string
{
	foreach ($pages as $page => $pattern)
	{
		if (preg_match($pattern, $uri, $matches))
		{
			return PAGES  . $page;
		}
	}
	return PAGES  . '404.php';
}
