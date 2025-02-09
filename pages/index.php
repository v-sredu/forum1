<?php
ob_start();
$title = 'Главная страница';
$page_slice = isset($_GET['page']) ? (intval($_GET['page']) - 1) * PAGE_SIZE : 1;
require_once LAYOUT . '/default/header.php';
?>
	<main class="col p-4">
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
								href="/?<?=http_build_query(array_merge($_GET, ['s' => 'date']))?>">По дате</a></li>
					<li><a class="dropdown-item small"
								href="/?<?=http_build_query(array_merge($_GET, ['s' => 'likes']))?>">По лайкам</a></li>
					<li><a class="dropdown-item small"
								href="/?<?=http_build_query(array_merge($_GET, ['s' => 'views']))?>">По просмотрам</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="cards mb-4 d-flex flex-column gap-3">
			<?php
			$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN likes ON likes.post_id = posts.id GROUP BY posts.id';
			$res = $pdo->query($sql);
			foreach ($res as $row)
			{
				$likes[$row['post_id']] = $row['count'];
			}
			$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN comments ON comments.post_id = posts.id GROUP BY posts.id';
			$res = $pdo->query($sql);
			foreach ($res as $row)
			{
				$comments[$row['post_id']] = $row['count'];
			}
			$sql = 'SELECT tags.name as tag, tags.id as tag_id, posts.id as post_id FROM tags JOIN posts_tags ON tags.id = posts_tags.tag_id JOIN posts ON posts.id = posts_tags.post_id';
			$res = $pdo->query($sql);
			$tags = [];
			foreach ($res as $row)
			{
				$tags[$row['post_id']][$row['tag_id']] = $row['tag'];
			}

			if (isset($_GET['tag']))
			{
				$sql = 'SELECT users.username, users.avatar, users.id as user_id, posts.* FROM posts_tags JOIN posts ON posts.id = posts_tags.post_id JOIN users ON users.id = posts.user_id  WHERE posts_tags.tag_id = :tag LIMIT :page_size OFFSET :page';
				$res = $pdo->query($sql, [
					'page_slice' => $page_slice,
					'page_size' => PAGE_SIZE,
					'tag' => $_GET['tag']
				]);
			}
			else
			{
				$sql = 'SELECT users.username, users.avatar, users.id as user_id, posts.* FROM posts JOIN users ON users.id = posts.user_id LIMIT :page_size OFFSET :page_slice';
				$res = $pdo->query($sql, [
					'page_slice' => $page_slice,
					'page_size' => PAGE_SIZE
				]);
			}
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

			if (!empty($_GET['s']) && in_array($_GET['s'], [
					'date',
					'likes',
					'views'
				]))
			{
				switch ($_GET['s'])
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

			foreach ($data as $id => $card) :
				if ($user_data['auth'])
				{
					$sql = 'SELECT 1 FROM likes WHERE user_id = :user_id AND post_id = :post_id';
					$like_is_select = $pdo->query($sql, [
						'user_id' => $user_data['id'],
						'post_id' => $card['id']
					]);
					$sql = 'SELECT 1 FROM posts_favorites WHERE user_id = :user_id AND post_id = :post_id';
					$post_is_favorite = $pdo->query($sql, [
						'user_id' => $user_data['id'],
						'post_id' => $card['id']
					]);
				}
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
							<span><?=$card['likes']?></span>
							<svg class="like <?=$like_is_select ? 'select' : ''?>" width="16" height="16">
								<use xlink:href="#like"></use>
							</svg>
						</button>

						<div class="text-decoration-none text-muted d-flex align-items-center gap-1">
							<span><?=$card['comments']?></span>
							<svg width="16" height="16">
								<use xlink:href="#chat"></use>
							</svg>
						</div>
						<div class="text-muted d-flex align-items-center gap-1">
							<span><?=$card['views']?></span>
							<svg width="16" height="16">
								<use xlink:href="#views"></use>
							</svg>
						</div>

						<button class="favorite btn border-0 p-0 d-flex align-items-center gap-1 ms-auto"
							<?=$post_is_favorite ? 'data-is-select' : ''?>
								data-post-id="<?=$card['id']?>"
								data-type-post="post_favorite_select"
								type="button">
							<svg class="bookmark <?=$post_is_favorite ? 'select' : ''?>" width="16" height="16">
								<use xlink:href="#bookmark"></use>
							</svg>
						</button>
						<span></span>
					</div>

				</div>
			<?php endforeach; ?>
		</div>

		<nav>
			<ul class="pagination justify-content-end">
				<li class="page-item disabled">
					<a class="page-link text-body border-0 border-end">Назад</a>
				</li>
				<li class="page-item"><a class="page-link text-body border-top-0 border-bottom-0">1</a>
				</li>
				<li class="page-item"><a class="page-link text-body border-top-0 border-bottom-0">2</a>
				</li>
				<li class="page-item"><a class="page-link text-body border-top-0 border-bottom-0">3</a>
				</li>
				<li class="page-item">
					<a class="page-link text-light bg-warning border-0 border-start">Вперед</a>
				</li>
			</ul>
		</nav>

	</main>
<?php

require_once LAYOUT . '/default/footer.php';
echo ob_get_clean();
