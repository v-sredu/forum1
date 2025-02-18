<?php
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
$uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];
preg_match('#^/user/(?<slug>.+)$#', $uri, $match);
$username = $match['slug'];
$sql = 'SELECT * FROM users WHERE users.username = :username';
$account_data = DB->query($sql, ['username' => $username])->getOne();

if (empty($account_data))
{
	abort(404);
}

$sql = 'SELECT COUNT(DISTINCT posts.id) as post_count, COUNT(DISTINCT users_subscribers.id) as subscriber_count FROM users LEFT JOIN posts ON posts.user_id = users.id LEFT JOIN users_subscribers ON users_subscribers.user_id = users.id WHERE users.id = :user_id GROUP BY users.id';
$count = DB->query($sql, ['user_id' => $account_data['id']])->getOne();

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
							<?php if (!empty($user_data['auth']) && ($account_data['id'] != $user_data['id'])) : ?>
								<button class="subscribe <?=($signed) ? 'select' : ''?> btn btn-sm btn-info p-1 d-none d-sm-block" id="select"
										data-account-id="<?=$account_data['id']?>"
										data-type-post="subscribe"t>
									<?=($signed) ? 'Вы подписаны' : 'Подписаться'?>
								</button>
							<?php endif; ?>
						</div>
						<div class="d-flex d-sm-block justify-content-center">
							<h2 class="card-title fs-5"><?=$account_data['username']?></h2>
							<p class="text-muted ms-2 ms-sm-0"><?=$count['subscriber_count']?>
								подписчиков, <?=$count['post_count']?> поста</p>
						</div>
						<?php if (!empty($user_data['auth']) && ($account_data['id'] != $user_data['id'])) : ?>
							<button class="subscribe <?=$signed ? 'select' : ''?> btn btn-sm btn-info d-sm-none d-block ms-auto"
									data-account-id="<?=$account_data['id']?>" data-type-post="subscribe" id="select">
								<?=$signed ? 'Вы подписаны' : 'Подписаться'?>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php if (!empty($user_data['auth']) && ($account_data['id'] == $user_data['id'])) : ?>
			<a href="/post/create" class="btn btn-outline-secondary w-100">Создать пост</a>
		<?php
		endif;
		$sql = 'SELECT
posts.id,
posts.title,
posts.content,
posts.date,
posts.views,
users.username,
users.avatar,
COUNT(DISTINCT likes.id) AS like_count,
COUNT(DISTINCT comments.id) AS comment_count,
GROUP_CONCAT(DISTINCT tags.name SEPARATOR " ") AS tags,
    (
        SELECT
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    "name", tags.name,
                    "id", tags.id
                )
            )
        FROM
            tags 
        JOIN posts_tags ON posts_tags.tag_id = tags.id
            WHERE posts_tags.post_id = posts.id
    ) AS tags
FROM
posts
LEFT JOIN likes ON posts.id = likes.post_id
LEFT JOIN comments ON posts.id = comments.post_id
LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
LEFT JOIN tags ON posts_tags.tag_id = tags.id
JOIN users ON posts.user_id = users.id WHERE posts.user_id = :user_id GROUP BY posts.id';
		$data = DB->query($sql, ['user_id' => $account_data['id']])->getAll();
		?>
		<div class="wrapper d-flex p-3">
			<?=get_component('cards.php', [
				'user_data' => $user_data,
				'cards_data' => $data,
			]);?>
		</div>
	</main>

<?php
$content = ob_get_clean();
$title = $username;

return template([
	'content' => $content,
	'title' => $title,
	'user_data' => $user_data
]);
