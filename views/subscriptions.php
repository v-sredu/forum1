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

$sql = 'SELECT users.username, users.avatar, COUNT(DISTINCT users_subscribers.id) as subscriber_count, COUNT(DISTINCT posts.id) as post_count
FROM users
LEFT JOIN users_subscribers ON users_subscribers.user_id = users.id
LEFT JOIN posts ON posts.user_id = users.id WHERE users_subscribers.subscriber_id = :user_id GROUP BY users.id';
$data = DB->query($sql, ['user_id' =>$user_data['id']])->getAll();
$post_all = count($data);
$data = array_slice($data, $page_slice, POST_COUNT);
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
					if (in_array($sort, [
							'subscribers',
							'posts'
						]))
					{
						switch ($sort)
						{
							case 'subscribers':
								usort($cards, function($a, $b)
								{
									return $b['subscriber_count']<=>$a['subscriber_count'];
								});
								break;
							case 'posts':
								usort($cards, function($a, $b)
								{
									return $b['post_count']<=>$a['post_count'];
								});
								break;
						}
					}
					foreach ($data as $card) : ?>
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
											<?=$card['subscriber_count'] ?>
											подписчиков, <?= $card['post_count'] ?>
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
