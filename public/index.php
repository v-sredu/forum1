<?php
session_start();

require_once __DIR__ . '/../core/config.php';
require_once ROOT . '/helpers/helpers.php';
require_once ROOT . '/core/Database.php';

const DB = new Database();
$uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];

setcookie('user', 0, time() - 23);
$pages = [
	'index.php' => '#^/$#',
	'account.php' => '#^/user/(?<slug>.+)$#',
	'account_setting.php' => '#^/settings$#',
	'auth.php' => '#^/auth$#',
	//	'post.php' => '#^/post/(?<slug>.+)$#',
	//	'post_create.php' => '#^/post/create$#',
	//	'post_setting.php' => '#^/post/setting$#',
	'posts_favorites.php' => '#^/posts/favorite$#',
	'subscriptions.php' => '#^/subscriptions$#',
	'reg.php' => '#^/reg$#',
	'404.php' => '#^/404$#',
	//	'500.php' => '#^/500$#'
];
//ajax
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
	{
		switch ($_POST['typePost'])
		{
			case 'post_like':
				$data = [
					'user_id' => (int)$_POST['userId'],
					'post_id' => (int)$_POST['postId']
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
					'user_id' => (int)$_POST['userId'],
					'post_id' => (int)$_POST['postId']
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
					'user_id' => (int)$_POST['accountId'],
					'subscriber_id' => (int)$_POST['userId']
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
				break;
			case 'reg':
				$avatar = $_FILES['file'];
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$repeat_password = $_POST['repeatPassword'];
				$message =checkForm($avatar, $name, $surname, $username, $password, $repeat_password);
				if ($message) {
					echo $message;
					break;
				}
				$password = password_hash($password, PASSWORD_DEFAULT);
				$sql = 'INSERT INTO users SET name=:name, surname=:surname, username=:username, password=:password';
				DB->query($sql, [
					'name' => $name,
					'surname' => $surname,
					'username' => $username,
					'password' => $password
				]);
				if (!empty($avatar))
				{
					$id = DB->query('SELECT id FROM users WHERE username = :username', ['username' => $username])
						->getOne()['id'];
					$avatar_name = $id . ($avatar['type'] === 'image/jpeg' ? '.jpg' : '.png');
					if (move_uploaded_file($avatar['tmp_name'], AVATARS . '/' . $avatar_name))
					{
						DB->query('UPDATE users SET avatar=:avatar WHERE id=:id', [
							'avatar' => $avatar_name,
							'id' => $id
						]);
					}
				}
				setcookie('user[auth]', true, 0, '/');
				setcookie('user[id]', $id, 0, '/');
				setcookie('user[avatar]', $avatar_name ?? 'none.jpg', 0, '/');
				setcookie('user[username]', $username, 0, '/');
				echo 'abort';
				die;
		}
	}
	exit;
}

echo get_page($pages, $uri);
