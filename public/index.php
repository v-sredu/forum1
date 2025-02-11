<?php
session_start();
require_once __DIR__ . '/../core/config.php';
require_once ROOT . '/helpers/helpers.php';
require_once ROOT . '/core/Database.php';

const DB = new Database();
$uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];

//setcookie('auth', true);
setcookie('a', 2123);
setcookie('auth', true, time() - 100);

$user_data = [
	'auth' => $_COOKIE['auth'] ?? false,
	'theme' => 'light'
];

if ($user_data['auth'])
{
	$id = $_COOKIE['id'] ?? 2;
	$query = 'SELECT * FROM users WHERE id = :id';
	$vars = ['id' => $id];
	$user_data += DB->query($query, $vars)->getOne();
	if (empty($user_data['avatar']))
	{
		$user_data['avatar'] = 'none.jpg';
	}
}

$pages = [
	'index.php' => '#^/$#',
	'account.php' => '#^/user/(?<slug>.+)$#',
	'account_setting.php' => '#^/settings$#',
	'auth.php' => '#^/authorization$#',
	'post.php' => '#^/post/(?<slug>.+)$#',
	'post_create.php' => '#^/post/create$#',
	'post_setting.php' => '#^/post/setting$#',
	'reg.php' => '#^/registration$#',
	'404.php' => '#^/404$#',
	'500.php' => '#^/500$#'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		switch ($data['typePost'])
		{
			case 'like_select':
				$user_id = (int)$user_data['id'];
				$post_id = (int)$data['postId'];
				if ($data['isSelect'])
				{
					$sql = 'INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)';
				}
				else
				{
					$sql = 'DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id';
				}
				DB->query($sql, [
					'user_id' => $user_id,
					'post_id' => $post_id
				]);
				$sql = 'SELECT COUNT(*) as count FROM likes WHERE post_id = :post_id';
				echo DB->query($sql, ['post_id' => $post_id])->getOne()['count'];
				break;
			case 'post_favorite_select':
				$user_id = (int)$user_data['id'];
				$post_id = (int)$data['postId'];
				if ($data['isSelect']) {
					$sql = 'INSERT INTO posts_favorites (post_id, user_id) VALUES (:post_id, :user_id)';
				} else {
					$sql = 'DELETE FROM posts_favorites WHERE user_id = :user_id AND post_id = :post_id';
				}
				DB->query($sql, ['user_id' => $user_id, 'post_id' => $post_id]);
				break;
		}
	}
	exit;
}

require_once get_page($pages, $uri);
