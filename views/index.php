<?php
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
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
JOIN users ON posts.user_id = users.id
GROUP BY posts.id';
$data = DB->query($sql)->getAll();
?>
	<main class="col p-4">
		<?=get_component('cards.php', [
			'user_data' => $user_data,
			'cards_data' => $data,
		]);?>
	</main>
<?php
$content = ob_get_clean();
$title = 'Главная страница';
return template(['content' => $content, 'title' => $title, 'user_data' => $user_data]);
