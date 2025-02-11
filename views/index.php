<?php
$title = 'Главная страница';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page_slice = ($page - 1) * POST_COUNT;
$sort = $GET['sort'] ?? 0;
if (isset($_GET['tag']))
{
	$sql = 'SELECT users.username, users.avatar, users.id as user_id, posts.* FROM posts JOIN users ON users.id = posts.user_id JOIN posts_tags ON posts_tags.post_id = posts.id WHERE posts_tags.tag_id = :tag LIMIT :page_size OFFSET :page_slice';
	$res = DB->bind_value_int($sql, [
		'page_slice' => $page_slice,
		'page_size' => POST_COUNT,
		'tag' => $_GET['tag']
	])->getAll();
	$sql = 'SELECT COUNT(*) as count FROM posts_tags WHERE tag_id = :tag';
	$post_all = DB->query($sql, ['tag' => $_GET['tag']])->getOne()['count'];
}
else
{
	$sql = 'SELECT users.username, users.avatar, users.id as user_id, posts.* FROM posts JOIN users ON users.id = posts.user_id  LIMIT :page_size OFFSET :page_slice';
	$res = DB->bind_value_int($sql, [
		'page_slice' => $page_slice,
		'page_size' => POST_COUNT
	])->getAll();
	$sql = 'SELECT COUNT(*) as count FROM posts';
	$post_all = DB->query($sql)->getOne()['count'];
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
	$data[$row['id']]['tags'] = $tags[$row['id']] ?? [];
}

require_once LAYOUT . '/default/header.php';
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

require_once LAYOUT . '/default/footer.php';
