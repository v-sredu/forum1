<?php
session_start();
require_once __DIR__ . '/../core/config.php';
require_once ROOT . '/helpers/helpers.php';
require_once ROOT . '/core/Database.php';

const DB = new Database();
$uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];
setcookie('auth', true, 0, '/');
setcookie('id', 2, 0, '/');

$user_data = [
	'auth' => $_COOKIE['auth'] ?? false,
	'theme' => 'light'
];

if ($user_data['auth'])
{
	$id = $_COOKIE['id'];
	$user_data += DB->query('SELECT * FROM users WHERE id = :id', ['id' => $id])->getOne();
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

//ajax
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);
		switch ($data['typePost'])
		{
			case 'post_like':
				$data = [
					'user_id' => (int)$data['userId'],
					'post_id' => (int)$data['postId']
				];
				$isSelect = DB->check('likes WHERE user_id = :user_id AND post_id = :post_id', $data);
				if ($isSelect)
				{
					$sql = 'DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id';
				}
				else
				{
					$sql = 'INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)';
				}
				DB->query($sql, $data);
				$sql = 'SELECT COUNT(*) as count FROM likes WHERE post_id = :post_id';
				echo DB->query($sql, ['post_id' => $data['post_id']])->getOne()['count'];
				break;
			case 'post_favorite_select':
				$params = [
					'user_id' => (int)$data['userId'],
					'post_id' => (int)$data['postId']
				];
				$isSelect = DB->check('posts_favorites WHERE user_id = :user_id AND post_id = :post_id', $params);
				if ($isSelect)
				{
					$sql = 'DELETE FROM posts_favorites WHERE user_id = :user_id AND post_id = :post_id';
				}
				else
				{
					$sql = 'INSERT INTO posts_favorites (post_id, user_id) VALUES (:post_id, :user_id)';
				}
				DB->query($sql, $params);
				break;
			case 'subscribe':
				$params = [
					'user_id' => (int)$data['accountId'],
					'subscriber_id' => (int)$data['userId']
					];
				$isSelect = DB->check('users_subscribers WHERE user_id = :user_id AND subscriber_id = :subscriber_id', $params);
				if ($isSelect)
				{
					$sql = 'DELETE FROM users_subscribers WHERE user_id = :user_id AND subscriber_id = :subscriber_id';
					echo 'Подписаться';
				}
				else
				{
					$sql = 'INSERT INTO users_subscribers (user_id, subscriber_id) VALUES (:user_id, :subscriber_id)';
					echo 'Вы подписаны';
				}
				DB->query($sql, $params);
		}
	}
	exit;
}

require_once get_page($pages, $uri);
