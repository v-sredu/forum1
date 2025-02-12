<?php
if (empty($_COOKIE['user']))
{
	abort(404);
}
ob_start();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page_slice = ($page - 1) * POST_COUNT;
$user_data = $_COOKIE['user'] ?? 0;
$sort = $_GET['sort'] ?? 0;

$sql = 'SELECT users_subscribers.user_id as id, users.username, users.avatar FROM users_subscribers JOIN users ON users.id = users_subscribers.user_id
    WHERE users_subscribers.subscriber_id = :user_id
	 LIMIT :page_size OFFSET :page_slice';
$cards = DB->bind_value_int($sql, [
	'page_size' => POST_COUNT,
	'page_slice' => $page_slice,
	'user_id' => $user_data['id']
])->getAll();

$sql = 'SELECT COUNT(posts.id) as count, posts.user_id as id FROM posts GROUP BY posts.user_id';
$res = DB->query($sql)->getAll();
$posts_count = [];
foreach ($res as $post)
{
	$posts_count[$post['id']] = $post['count'];
}
$sql = 'SELECT COUNT(users_subscribers.subscriber_id) as count, users_subscribers.user_id as id FROM users_subscribers GROUP BY users_subscribers.user_id';
$res = DB->query($sql)->getAll();
$subscribers_count = [];
foreach ($res as $subscriber)
{
	$subscribers_count[$subscriber['id']] = $subscriber['count'];
}
$sql = 'SELECT COUNT(*) as count FROM users_subscribers WHERE users_subscribers.subscriber_id = :user_id';
$post_all = DB->query($sql, ['user_id' => $user_data['id']])->getOne()['count'];
foreach ($cards as &$card) {
	$card['subscribers_count'] = $subscribers_count[$card['id']] ?? 0;
	$card['posts_count'] = $posts_count[$card['id']] ?? 0;
}
?>
	<main class="col p-4">
		<?php if ($post_all>0): ?>
			<div class="cards-block">
				<?=get_component('buttons_sort.php', [
					'data' => [
						'subscribers' => 'По подписчикам',
						'posts' => 'По постам'
					]
				]);?>
				<div class="cards mb-4 d-flex flex-column gap-3">
					<?php
					if (!empty($sort) && in_array($sort, [
							'subscribers',
							'posts'
						]))
					{
						switch ($sort)
						{
							case 'subscribers':
								usort($cards, function($a, $b)
								{
									return $b['subscribers_count']<=>$a['subscribers_count'];
								});
								break;
							case 'posts':
								usort($cards, function($a, $b)
								{
									return $b['posts_count']<=>$a['posts_count'];
								});
								break;
						}
					}
					foreach ($cards as $card) : ?>
						<div class="cards mb-4 d-flex flex-column gap-3">
							<div class="card border-0 rounded-4 p-2 mb-1">
								<a href="/user/<?=$card['username']?>"
									class="text-decoration-none">
								<div class="card-body d-flex justify-content-start gap-3">
									<div class="small rounded-2"
											style="width: 40px; height: 40px; background: url('/public/img/avatars/<?=$card['avatar']?>') no-repeat transparent; background-size: cover;"></div>
									<div class="lh-2">
										<p class="m-0 text-body"><?=$card['username']?></p>
										<p class="m-0 text-body text-muted small">
											<?=$card['subscribers_count'] ?>
											подписчиков, <?= $card['posts_count'] ?>
											постов</p>
									</div>
								</div>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?=get_component('buttons_navigation.php', [
					'post_all' => $post_all,
					'page' => $page
				]);?>
			</div>
		<?php endif; ?>
	</main>
<?php
$content = ob_get_clean();
$title = 'Избранное';

return template([
	'content' => $content,
	'title' => $title,
	'user_data' => $user_data
]);
