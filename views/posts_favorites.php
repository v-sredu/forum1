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

$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN likes ON likes.post_id = posts.id JOIN posts_favorites ON posts_favorites.post_id = posts.id WHERE posts_favorites.user_id = :user_id GROUP BY posts.id';
$res = DB->query($sql, ['user_id' => $user_data['id']])->getAll();
foreach ($res as $row)
{
	$likes[$row['post_id']] = $row['count'];
}

$sql = 'SELECT COUNT(posts.id) as count, posts.id as post_id FROM posts JOIN comments ON comments.post_id = posts.id JOIN posts_favorites ON posts_favorites.post_id = posts.id WHERE posts_favorites.user_id = :user_id GROUP BY posts.id';
$res = DB->query($sql, ['user_id' => $user_data['id']])->getAll();
foreach ($res as $row)
{
	$comments[$row['post_id']] = $row['count'];
}

$sql = 'SELECT tags.name as tag, tags.id as tag_id, posts.id as post_id FROM tags JOIN posts_tags ON tags.id = posts_tags.tag_id JOIN posts ON posts.id = posts_tags.post_id JOIN posts_favorites ON posts_favorites.post_id = posts.id WHERE posts_favorites.user_id = :user_id';
$res = DB->query($sql, ['user_id' => $user_data['id']])->getAll();
$tags = [];
foreach ($res as $row)
{
	$tags[$row['post_id']][$row['tag_id']] = $row['tag'];
}

$sql = 'SELECT users.username, users.avatar, users.id as user_id, posts.* FROM posts JOIN users ON users.id = posts.user_id JOIN posts_favorites ON posts_favorites.post_id = posts.id WHERE posts_favorites.user_id = :user_id LIMIT :page_size OFFSET :page_slice';
$res = DB->bind_value_int($sql, [
	'page_slice' => $page_slice,
	'page_size' => POST_COUNT,
	'user_id' => $user_data['id']
])->getAll();
$sql = 'SELECT COUNT(*) as count FROM posts';
$post_all = DB->query($sql)->getOne()['count'];

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
	<main class="col p-4">
		<?=get_component('cards.php', [
			'page' => $page,
			'page_slice' => $page_slice,
			'post_all' => $post_all,
			'sort' => $sort,
			'user_data' => $user_data,
			'cards_data' => $data,
		]);?>
	</main>
<?php
$content = ob_get_clean();
$title = 'Избранное';

return template([
	'content' => $content,
	'title' => $title,
	'user_data' => $user_data
]);
