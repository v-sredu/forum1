<?php
//if ($post_all>0):
	$sort = $_GET['sort'] ?? 0;
	?>
	<div class="cards-block">
		<?=get_component('buttons_sort.php', [
			'data' => [
				'date' => 'По дате',
				'likes' => 'По лайкам',
				'views' => 'По просмотрам'
			]
		]);?>
		<div class="cards mb-4 d-flex flex-column gap-3">
			<?php
			if (in_array($sort, [
					'date',
					'likes',
					'views'
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
							return $b['like_count']<=>$a['like_count'];
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
			$post_all = count($cards_data);
			$page_slice = ($page - 1) * POST_COUNT;
			$cards_data = array_slice($cards_data, $page_slice, POST_COUNT);
			if (!empty($user_data['auth']))
			{
				$sql = 'SELECT post_id FROM likes WHERE user_id = :user_id';
				$posts_likes = DB->query($sql, [
					'user_id' => $user_data['id'],
				])->getColumn();
				$sql = 'SELECT post_id FROM posts_favorites WHERE user_id = :user_id';
				$posts_favorite = DB->query($sql, [
					'user_id' => $user_data['id'],
				])->getColumn();
			}
			else
			{
				$posts_likes = [];
				$posts_favorite = [];
			}
			foreach ($cards_data as $card) :
				$post_is_favorite = in_array($card['id'], $posts_favorite);
				$post_is_like = in_array($card['id'], $posts_likes);
				?>
				<div class="card border-0 rounded-4 p-3 mb-2">

					<div class="card-top d-flex gap-3">
						<a href="/user/<?=$card['username']?>" class="d-block text-decoration-none small rounded-2"
								style="width: 40px; height: 40px; background: url('/public/img/avatars/<?=$card['avatar']?>') no-repeat transparent; background-size: cover;"></a>
						<div class="lh-1">
							<p class="m-0 text-body"><?=$card['username']?></p>
							<p class="text-muted small mt-2"><?=$card['date']?></p>
						</div>
					</div>
					<a class="mb-3 text-decoration-none d-block text-body" href="/post/<?=$card['id']?>">
						<h3 class="card-title fs-5 text-break"><?=$card['title']?></h3>
						<p class="card-text text-break">
							<?=mb_substr($card['content'], 0,100)?>
						</p>
					</a>

					<div class="tag-group mb-3 d-flex flex-wrap gap-2">
						<?php
						$tags = json_decode($card['tags'] ?? '[]');
						foreach ($tags as $tag) :
							?>
							<a href="/?tag=<?=$tag->id?>"
									class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#<?=$tag->name?></a>
						<?php endforeach; ?>
					</div>

					<div class="d-flex gap-2 small">

						<button class="like <?=$post_is_like ? 'select' : ''?> btn border-0 p-0 text-muted d-flex align-items-center gap-1"  id="select"
								data-post-id="<?=$card['id']?>" data-type-post="post_like" type="button">
							<span><?=$card['like_count']?></span>
							<svg width="16" height="16"
									fill="currentColor" viewBox="0 0 16 16">
								<path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"></path>
							</svg>
						</button>

						<div class="text-decoration-none text-muted d-flex align-items-center gap-1">
							<span><?=$card['comment_count']?></span>
							<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
								<path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"></path>
							</svg>
						</div>
						<div class="text-muted d-flex align-items-center gap-1">
							<span><?=$card['views']?></span>
							<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
								<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
								<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
							</svg>
						</div>

						<button class="bookmark <?=$post_is_favorite ? 'select' : ''?> btn border-0 p-0 d-flex align-items-center gap-1 ms-auto" id="select"
								data-post-id="<?=$card['id']?>"
								data-type-post="post_favorite_select"
								type="button">
							<svg width="16" height="16"
									fill="currentColor" viewBox="0 0 16 16">
								<path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2"/>
							</svg>
						</button>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?=get_component('buttons_navigation.php', [
			'post_all' => $post_all,
			'page' => $page
		]);?>
	</div>
<?php //endif;
