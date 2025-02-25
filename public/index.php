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
	'post_create.php' => '#^/post/create$#',
	'post.php' => '#^/post/(?<slug>.+)$#',
	'posts_favorites.php' => '#^/posts/favorite$#',
	'subscriptions.php' => '#^/subscriptions$#',
	'reg.php' => '#^/reg$#',
	'404.php' => '#^/404$#',
];

//ajax
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	switch ($_POST['typePost'])
	{
		case 'post_like':
			$data = [
				'user_id' => (int)$_COOKIE['user']['id'],
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
			exit;
		case 'post_favorite_select':
			$params = [
				'user_id' => (int)$_COOKIE['user']['id'],
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
			exit;
		case 'subscribe':
			$params = [
				'user_id' => (int)$_POST['accountId'],
				'subscriber_id' => (int)$_COOKIE['user']['id']
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
			exit;
		case 'reg':
			$avatar = $_FILES['file'];
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$repeat_password = $_POST['repeatPassword'];
			$message = checkForm($avatar, $name, $surname, $username, $password, $repeat_password);
			if ($message)
			{
				echo $message;
				exit;
			}
			$isExist = DB->check('users WHERE username = :username', ['username' => $username]);
			if ($isExist)
			{
				return 'Данный username существует';
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
			exit;
		case 'setting':
			$avatar = $_FILES['file'];
			$id = $_COOKIE['user']['id'];
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$repeat_password = $_POST['repeatPassword'];
			$message = checkForm($avatar, $name, $surname, $username, $password, $repeat_password);
			if ($message)
			{
				echo $message;
				exit;
			}
			$password = password_hash($password, PASSWORD_DEFAULT);
			$sql = 'UPDATE users SET name=:name, surname=:surname, username=:username, password=:password WHERE id=:id';
			DB->query($sql, [
				'id' => $id,
				'name' => $name,
				'surname' => $surname,
				'username' => $username,
				'password' => $password
			]);
			setcookie('user[username]', $username, 0, '/');

			if (!empty($avatar))
			{
				$avatar_name = $id . ($avatar['type'] === 'image/jpeg' ? '.jpg' : '.png');
				if (move_uploaded_file($avatar['tmp_name'], AVATARS . '/' . $avatar_name))
				{
					DB->query($sql, [
						'id' => $id,
						'avatar' => $avatar_name
					]);
					setcookie('user[avatar]', $avatar_name, 0, '/');
				}
			}
			echo 'abort';
			exit;
		case 'auth':
			$username = $_POST['username'];
			$password = $_POST['password'];

			$sql = 'SELECT password, id, avatar FROM users WHERE username = :username';
			$user = DB->query($sql, ['username' => $username])->getOne();
			if (empty($user))
			{
				echo 'Данного пользователя не существует';
				exit;
			}
			if (password_verify($password, $user['password']))
			{
				{
					setcookie('user[auth]', true, 0, '/');
					setcookie('user[id]', $user['id'], 0, '/');
					setcookie('user[avatar]', $user['avatar'], 0, '/');
					setcookie('user[username]', $username, 0, '/');
					echo 'abort';
					exit;
				}
			}
			else
			{
				echo 'Неверный пароль';
			}
			exit;
		case 'sendComment':
			$parent_id = $_POST['parent_id'] == 'null' ? null : ((int)$_POST['parent_id']);
			$post_id = (int)$_POST['post_id'];
			$text = htmlspecialchars($_POST['text']);
			$user_id = (int)$_COOKIE['user']['id'];
			$date = date('Y-m-d');
			$sql = 'INSERT INTO comments SET user_id=:user_id, parent_id=:parent_id, post_id=:post_id, text=:text, date=:date';
			DB->query($sql, [
				'parent_id' => $parent_id,
				'post_id' => $post_id,
				'user_id' => $user_id,
				'text' => $text,
				'date' => $date
			]);
			$sql = 'SELECT comments.id, comments.parent_id, comments.user_id, comments.text, comments.date, users.username, users.avatar FROM comments LEFT JOIN users ON users.id = comments.user_id WHERE comments.post_id = :post_id';
			$comments = DB->query($sql, ['post_id' => $post_id])->getAll();
			echo get_component('comments.php', [
				'comments' => $comments,
				'main_id' => $post_id,
				'auth' => true,
				'current_username' => $_COOKIE['user']['username']
			]);
			exit;
		case 'deleteComment':
			$post_id = $_POST['post_id'];
			$sql = 'DELETE FROM comments WHERE id=:id';
			DB->query($sql, ['id' => $_POST['comment_id']]);
			$sql = 'SELECT comments.id, comments.parent_id, comments.user_id, comments.text, comments.date, users.username, users.avatar FROM comments LEFT JOIN users ON users.id = comments.user_id WHERE comments.post_id = :post_id';
			$comments = DB->query($sql, ['post_id' => $post_id])->getAll();
			echo get_component('comments.php', [
				'comments' => $comments,
				'main_id' => $post_id,
				'auth' => true,
				'current_username' => $_COOKIE['user']['username']
			]);
			exit;
		case 'deletePost':
			$post_id = $_POST['post_id'];
			$sql = 'DELETE FROM posts WHERE id=:id';
			DB->query($sql, ['id' => $post_id]);
			exit;
		case 'createPost':
			$user_id = $_COOKIE['user']['id'];
			$title = mb_substr(htmlspecialchars($_POST['title']), 0, 99);
			$content = mb_substr(nl2br(htmlspecialchars($_POST['content'])), 0, 999);
			$date = date('Y-m-d');
			$sql = 'INSERT INTO posts SET user_id=:user_id, title=:title, content=:content, date=:date';
			DB->query($sql, [
				'user_id' => $user_id,
				'title' => $title,
				'content' => $content,
				'date' => $date
			]);
			$post_id = DB->getLastId();

			$tags = array_slice(explode(',', $_POST['tags']), 0, 6);
			$sql = 'SELECT name FROM tags';
			$tags_all = DB->query($sql)->getAll();
			$tags_new = array_diff($tags, array_column($tags_all, 'name'));
			$sql = 'INSERT INTO tags (name) VALUES (:tag)';
			$res = DB->prepare($sql);
			foreach ($tags_new as $tag)
			{
				$res->execute(['tag' => $tag]);
			}

			$sql = 'SELECT id, name FROM tags';
			$tags_all = DB->query($sql)->getAll();

			$sql = 'INSERT INTO posts_tags (post_id, tag_id) VALUES (:post_id, :tag_id)';
			$res = DB->prepare($sql);
			$values = '';
			foreach ($tags as $tag)
			{
				foreach ($tags_all as $tag_array)
				{
					if ($tag_array['name'] == $tag)
					{
						$res->execute([
							'post_id' => $post_id,
							'tag_id' => $tag_array['id']
						]);
					}
				}
			}
	}
}

echo get_page($pages, $uri);
