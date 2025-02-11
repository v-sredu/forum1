<div class="cards-block">
	<div class="d-flex align-items-center mb-2">
		<div class="border-top w-100">
		</div>
		<div class="btn-group">
			<button class="btn dropdown-toggle btn-sm border-0" type="button" data-bs-toggle="dropdown"
					aria-expanded="false">
				Сортировать по:
			</button>
			<ul class="dropdown-menu border-0 shadow-sm">
				<li><a class="dropdown-item small"
							href="/?<?=link_create('sort', 'date')?>">По дате</a></li>
				<li><a class="dropdown-item small"
							href="/?<?=link_create('sort', 'likes')?>">По лайкам</a></li>
				<li><a class="dropdown-item small"
							href="/?<?=link_create('sort', 'views')?>">По просмотрам</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="cards mb-4 d-flex flex-column gap-3">
		<?php
		$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN likes ON likes.post_id = posts.id GROUP BY posts.id';
		$res = DB->query($sql)->getAll();
		foreach ($res as $row)
		{
			$likes[$row['post_id']] = $row['count'];
		}
		$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN comments ON comments.post_id = posts.id GROUP BY posts.id';
		$res = DB->query($sql)->getAll();
		foreach ($res as $row)
		{
			$comments[$row['post_id']] = $row['count'];
		}
		$sql = 'SELECT tags.name as tag, tags.id as tag_id, posts.id as post_id FROM tags JOIN posts_tags ON tags.id = posts_tags.tag_id JOIN posts ON posts.id = posts_tags.post_id';
		$res = DB->query($sql)->getAll();
		$tags = [];
		foreach ($res as $row)
		{
			$tags[$row['post_id']][$row['tag_id']] = $row['tag'];
		}

		if (!empty($sort) && in_array($sort, [
				'date',
				'likes',
				'views'
			]))
		{
			switch ($sort)
			{
				case 'date':
					usort($data, function($a, $b)
					{
						return new DateTime($b['date'])<=>new DateTime($a['date']);
					});
					break;
				case 'likes':
					usort($data, function($a, $b)
					{
						return $b['likes']<=>$a['likes'];
					});
					break;
				case 'views':
					usort($data, function($a, $b)
					{
						return $b['views']<=>$a['views'];
					});
					break;
			}
		}

		if ($user_data['auth'])
		{
			$sql = 'SELECT post_id FROM likes WHERE user_id = :user_id';
			$likes_select = DB->query($sql, [
				'user_id' => $user_data['id'],
			])->getColumn();
			$sql = 'SELECT post_id FROM posts_favorites WHERE user_id = :user_id';
			$posts_favorite = DB->query($sql, [
				'user_id' => $user_data['id'],
			])->getColumn();
		}
		else
		{
			$likes_select = [];
			$posts_favorite = [];
		}
		foreach ($cards_data as $id => $card) :
			$post_is_favorite = in_array($id, $posts_favorite);
			$like_is_select = in_array($id, $likes_select);
			?>
			<div class="card border-0 rounded-4 p-3 mb-2">

				<div class="card-top d-flex gap-3">
					<a href="/user/<?=$card['user_id']?>" class="d-block text-decoration-none small rounded-2"
							style="width: 40px; height: 40px; background: url('/public/img/avatars/<?=$card['avatar']?>') no-repeat transparent; background-size: cover;"></a>
					<div class="lh-1">
						<p class="m-0 text-body"><?=$card['username']?></p>
						<p class="text-muted small mt-2"><?=$card['date']?></p>
					</div>
				</div>
				<a class="mb-3 text-decoration-none d-block text-body" href="/post/<?=$card['id']?>">
					<h3 class="card-title fs-5"><?=$card['title']?></h3>
					<p class="card-text">
						<?=$card['content']?>
					</p>
				</a>

				<div class="tag-group mb-3 d-flex flex-wrap gap-2">
					<?php foreach ($card['tags'] as $tag_id => $tag_name) : ?>
						<a href="/?tag=<?=$tag_id?>"
								class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#<?=$tag_name?></a>
					<?php endforeach; ?>
				</div>

				<div class="d-flex gap-2 small">

					<button class="like btn border-0 p-0 text-muted d-flex align-items-center gap-1"
						<?=$like_is_select ? 'data-is-select' : ''?>
							data-post-id="<?=$card['id']?>" data-type-post="like_select" type="button">
						<span><?=$likes[$id] ?? 0?></span>
						<svg class="like <?=$like_is_select ? 'select' : ''?>" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
							<path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"></path>
						</svg>
					</button>

					<div class="text-decoration-none text-muted d-flex align-items-center gap-1">
						<span><?=$comments[$id] ?? 0?></span>
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

					<button class="favorite btn border-0 p-0 d-flex align-items-center gap-1 ms-auto"
						<?=$post_is_favorite ? 'data-is-select' : ''?>
							data-post-id="<?=$card['id']?>"
							data-type-post="post_favorite_select"
							type="button">
						<svg class="bookmark <?=$post_is_favorite ? 'select' : ''?>" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
							<path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2"/>
						</svg>
					</button>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<?php
	$total_page = ceil($post_all / POST_COUNT);
	$start_page = max(1, $page - 2);
	$end_page = min($total_page, $page + 2);
	?>
	<ul class="pagination justify-content-end">
		<li class="page-item <?=($page<=1) ? 'disabled' : ''?>">
			<a href="/?<?=link_create('page', $page - 1)?>"
					class="page-link text-body border-0 border-end">Назад</a>
		</li>
		<?php for ($i = $start_page; $i<=$end_page; $i++) : ?>
			<li class="page-item <?=($page === $i) ? 'active disabled' : ''?> "><a
						href="/?<?=link_create('page', $i)?>"
						class="page-link text-body border-top-0 border-bottom-0">
					<?=$i?>
				</a></li>
		<?php endfor; ?>
		<li class="page-item <?=($page>=$total_page) ? 'disabled' : ''?>">
			<a href="/?<?=link_create('page', $page + 1)?>"
					class="page-link text-body border-0 border-end">Вперед</a>
		</li>
	</ul>
</div>
