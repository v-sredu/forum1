<?php
if (empty($_COOKIE['auth']))
{
	abort(404);
}
ob_start();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page_slice = ($page - 1) * POST_COUNT;
$user_data = $_COOKIE['user'] ?? 0;
$sort = $_GET['sort'] ?? 0;

$sql = 'SELECT * FROM users_subscribers WHERE users_subscribers.user_id = :user_id';

//var_dump($res);
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
							case 'date':
								usort($cards_data, function($a, $b)
								{
									return new DateTime($b['date'])<=>new DateTime($a['date']);
								});
								break;
							case 'likes':
								usort($cards_data, function($a, $b)
								{
									return $b['likes']<=>$a['likes'];
								});
								break;
							case 'views':
								usort($cards_data, function($a, $b)
								{
									return $b['views']<=>$a['views'];
								});
								break;
						}
					}
					foreach ($cards as $card) :?>
						<div class="cards mb-4 d-flex flex-column gap-3">
							<div class="card border-0 rounded-4 p-2 mb-1">
								<div class="card-body d-flex justify-content-between">
									<a href="" class="user d-flex gap-3 text-decoration-none">
										<div class="small rounded-2"
												style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></div>
										<div class="lh-2">
											<p class="m-0 text-body">username </p>
											<p class="m-0 text-body text-muted small">12 постов, 20 подписчиков</p>
										</div>
									</a>
								</div>
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
