<?php
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
$uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];
preg_match('#^/user/(?<slug>.+)$#', $uri, $match);
$username = $match['slug'];
$title = $username;

$sql = 'SELECT * FROM users WHERE users.username = :username';
$account_data = DB->query($sql, ['username' => $username])->getOne();

if (empty($account_data))
{
	abort(404);
}

$sql = 'SELECT COUNT(*) as count FROM posts WHERE posts.user_id = :user_id';
$posts_count = DB->query($sql, ['user_id' => $account_data['id']])->getOne()['count'];
$sql = 'SELECT COUNT(*) as count FROM users_subscribers WHERE users_subscribers.user_id = :user_id';
$users_subscribers_count = DB->query($sql, ['user_id' => $account_data['id']])->getOne()['count'];

if (!empty($user_data['auth']) && $account_data['id'] !== $user_data['id'])
{
	$sql = 'SELECT 1 FROM users_subscribers WHERE users_subscribers.user_id = :user_id AND users_subscribers.subscriber_id = :subscriber_id';
	$signed = DB->query($sql, [
		'subscriber_id' => $user_data['id'],
		'user_id' => $account_data['id']
	])->getOne();
}
else
{
	$signed = false;
}

?>
	<main class="col wrapper">

		<div class="profile mb-2 card border-0">
			<div class="card-image-top"
					style="background: url('/public/img/avatars/<?=$account_data['avatar']?>') no-repeat center;">
			</div>
			<div class="card-body p-2">
				<div class="d-flex flex-column align-items-center align-items-md-start flex-sm-row text-center text-sm-start">
					<div class="profile-avatar mx-4 mb-3 rounded-circle"
							style="width: 100px; height: 100px; background: url('/public/img/avatars/<?=$account_data['avatar']?>') no-repeat white center; background-size: cover;">
					</div>
					<div class="profile-info w-100">
						<div class="d-flex justify-content-around justify-content-sm-between w-100">
							<h2 class="fs-4"><?=$account_data['name'] . ' ' . $account_data['surname']?></h2>
							<?php if (!(!empty($user_data['auth']) && $account_data['id'] === $user_data['id'])) : ?>
								<button class="subscribe <?=($signed) ? 'select' : ''?> btn btn-sm btn-info p-1 d-none d-sm-block"
										data-account-id="<?=$account_data['id']?>"
										data-type-post="subscribe" data-select>
									<?=($signed) ? 'Вы подписаны' : 'Подписаться'?>
								</button>
							<?php endif; ?>
						</div>
						<div class="d-flex d-sm-block justify-content-center">
							<h2 class="card-title fs-5"><?=$account_data['username']?></h2>
							<p class="text-muted ms-2 ms-sm-0"><?=$users_subscribers_count?>
								подписчиков, <?=$posts_count?> поста</p>
						</div>
						<?php if (!(!empty($user_data['auth']) && $account_data['id'] === $user_data['id'])) : ?>
							<button class="subscribe <?=$signed ? 'select' : ''?> btn btn-sm btn-info d-sm-none d-block ms-auto"
									data-account-id="<?=$account_data['id']?>" data-type-post="subscribe" data-select>
								<?=$signed ? 'Вы подписаны' : 'Подписаться'?>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php if (!empty($user_data['auth']) && $account_data['id'] === $user_data['id']) : ?>
			<a href="/post/create" class="btn btn-outline-secondary w-100">Создать пост</a>
		<?php
		endif;
		$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
		$page_slice = ($page - 1) * POST_COUNT;
		$sort = $_GET['sort'] ?? 0;

		$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN likes ON likes.post_id = posts.id WHERE posts.user_id = :user_id GROUP BY posts.id';
		$res = DB->query($sql, ['user_id' => $account_data['id']])->getAll();
		foreach ($res as $row)
		{
			$likes[$row['post_id']] = $row['count'];
		}

		$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN comments ON comments.post_id = posts.id WHERE posts.user_id = :user_id GROUP BY posts.id';
		$res = DB->query($sql, ['user_id' => $account_data['id']])->getAll();
		foreach ($res as $row)
		{
			$comments[$row['post_id']] = $row['count'];
		}

		$sql = 'SELECT tags.name as tag, tags.id as tag_id, posts.id as post_id FROM tags JOIN posts_tags ON tags.id = posts_tags.tag_id JOIN posts ON posts.id = posts_tags.post_id WHERE posts.user_id = :user_id';
		$res = DB->query($sql, ['user_id' => $account_data['id']])->getAll();
		$tags = [];
		foreach ($res as $row)
		{
			$tags[$row['post_id']][$row['tag_id']] = $row['tag'];
		}

		$sql = 'SELECT users.username, users.avatar, users.id as user_id, posts.* FROM posts JOIN users ON users.id = posts.user_id WHERE users.id = :user_id LIMIT :page_size OFFSET :page_slice';
		$res = DB->bind_value_int($sql, [
			'page_slice' => $page_slice,
			'page_size' => POST_COUNT,
			'user_id' => $account_data['id']
		])->getAll();
		$sql = 'SELECT COUNT(*) as count FROM posts WHERE posts.user_id = :user_id';
		$post_all = DB->query($sql, ['user_id' => $account_data['id']])->getOne()['count'];

		$data = [];
		foreach ($res as $row)
		{
			$data[$row['id']]['id'] = $row['id'];
			$data[$row['id']]['cover'] = $row['cover'];
			$data[$row['id']]['title'] = $row['title'];
			$data[$row['id']]['content'] = mb_substr($row['content'], 0, 200) . '...';
			$data[$row['id']]['user_id'] = $row['user_id'];
			$data[$row['id']]['username'] = $row['username'];
			$data[$row['id']]['avatar'] = $row['avatar'] ?? 'none.jpg';
			$data[$row['id']]['views'] = $row['views'];
			$data[$row['id']]['date'] = $row['date'];
			$data[$row['id']]['likes'] = $likes[$row['id']] ?? 0;
			$data[$row['id']]['comments'] = $comments[$row['id']] ?? 0;
			$data[$row['id']]['tags'] = $tags[$row['id']] ?? [];
		}
		?>
		<div class="wrapper d-flex p-3">
			<?=get_component('cards.php', [
				'page' => $page,
				'page_slice' => $page_slice,
				'post_all' => $post_all,
				'sort' => $sort,
				'user_data' => $user_data,
				'cards_data' => $data,
			]);
			?>
		</div>
	</main>

<?php
$content = ob_get_clean();
$title = $username;
return template(['content' => $content, 'title' => $title, 'user_data' => $user_data]);
