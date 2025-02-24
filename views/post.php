<?php
ob_start();
$user_data = $_COOKIE['user'] ?? 0;
$uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];
preg_match('#^/post/(?<slug>.+)$#', $uri, $match);
$post_id = $match['slug'];

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
JOIN users ON posts.user_id = users.id WHERE posts.id = :id GROUP BY posts.id';
$post_data = DB->query($sql, ['id' => $post_id])->getOne();

$sql = 'UPDATE posts SET views=:views WHERE id=:id';
DB->query($sql, ['views' => $post_data['views'] + 1, 'id' => $post_id]);

if (!empty($user_data['auth']))
{
	$sql = 'SELECT 1 FROM likes WHERE post_id=:post_id AND user_id=:user_id';
	$post_is_like = DB->query($sql, [
		'post_id' => $post_id,
		'user_id' => $user_data['id']
	])->getOne();
	$sql = 'SELECT 1 FROM posts_favorites WHERE post_id=:post_id AND user_id=:user_id';
	$post_is_favorite = DB->query($sql, [
		'post_id' => $post_id,
		'user_id' => $user_data['id']
	])->getOne();
}
else
{
	$post_is_like = false;
	$post_is_favorite = false;
}

?>
	<main class="w-100 p-4">
		<div class="post bg-body p-4 mb-2 rounded-3">
			<div class="user d-flex gap-3">
				<a href="/user/<?= $post_data['username'] ?>" class="d-block text-decoration-none small rounded-2"
						style="width: 40px; height: 40px; background: url('/public/img/avatars/<?= $post_data['avatar'] ?>') no-repeat transparent center; background-size: cover;"></a>
				<div class="lh-1">
					<p class="m-0 text-body"><?= $post_data['username'] ?></p>
					<p class="text-muted small mt-2"><?= $post_data['date'] ?></p>
				</div>
			</div>
			<h2 class="mb-4 font-monospace fw-bold fs-2"><?= $post_data['title'] ?></h2>
			<div class="text mb-3">
				<?= $post_data['content'] ?>
			</div>
				<div class="tag-group mt-5 d-flex flex-wrap gap-2">
					<?php
					$tags = json_decode($post_data['tags'] ?? '[]');
					foreach ($tags as $tag) :
						?>
						<a href="/?tag=<?=$tag->id?>"
								class="text-decoration-none badge opacity-75 text-info-emphasis bg-info-subtle">#<?=$tag->name?></a>
					<?php endforeach; ?>
				</div>
			<div class="d-flex gap-2 mt-3">
				<button class="like <?=$post_is_like ? 'select' : ''?> btn border-0 p-0 text-muted d-flex align-items-center gap-1"
						id="select"
						data-post-id="<?=$post_data['id']?>" data-type-post="post_like" type="button">
					<span><?=$post_data['like_count']?></span>
					<svg width="16" height="16"
							fill="currentColor" viewBox="0 0 16 16">
						<path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"></path>
					</svg>
				</button>

				<div class="text-decoration-none text-muted d-flex align-items-center gap-1">
					<span><?=$post_data['comment_count']?></span>
					<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
						<path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"></path>
					</svg>
				</div>
				<div class="text-muted d-flex align-items-center gap-1">
					<span><?=$post_data['views']?></span>
					<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
						<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
						<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
					</svg>
				</div>

				<button class="bookmark <?=$post_is_favorite ? 'select' : ''?> btn border-0 p-0 d-flex align-items-center gap-1 ms-auto"
						id="select"
						data-post-id="<?=$post_data['id']?>"
						data-type-post="post_favorite_select"
						type="button">
					<svg width="16" height="16"
							fill="currentColor" viewBox="0 0 16 16">
						<path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2"/>
					</svg>
				</button>
			</div>

			<div class="comments bg-body p-4 rounded-3">
				<div class="w-100 btn btn-outline-secondary text-center small"
						data-bs-toggle="collapse"
						data-bs-target="#newCommentMain" role="button">
					ответить
				</div>
				<div class="collapse mt-4" id="newCommentMain">
					<form class="form-control border-0 p-0" action="" method="post">
						<input type="hidden" value="main" name="parent_id">
						<div class="form-floating">
                            <textarea class="form-control shadow-none" name="comment"
									maxlength="300" minlength="1" id="text"
									required style="height: 100px"></textarea>
							<label for="text">комментарий</label>
						</div>
						<div class="d-flex justify-content-end">
							<input type="submit" class="btn text-warning small p-1" value="отправить">
							<button class="btn text-secondary small p-1" type="button" data-bs-toggle="collapse"
									data-bs-target="#newCommentMain">
								отмена
							</button>
						</div>
					</form>
				</div>

				<div class="comments-list mt-4">
					<!--                        ///////////////////////////////-->
					<div class="comment mt-1">
						<div class="comment-header d-flex gap-3">
							<a href="" class="d-block text-decoration-none small rounded-2"
									style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
							<div class="lh-1">
								<p class="m-0 text-body">username </p>
								<p class="text-muted small mt-2">23:12 12 мая 2023</p>
							</div>
							<div class="ms-auto d-flex gap-1 align-items-center align-self-start">
								<button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
										data-bs-placement="top" data-bs-title="Пожаловаться">
									<img src="/img/icons/exclamation.svg" alt="complaint" width="20"
											height="20">
								</button>
							</div>
						</div>
						<div class="comment-body">
							<p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab deleniti
								dicta
								distinctio enim et explicabo molestias officia omnis ullam vel!</p>
						</div>
						<div class="comment-footer row align-items-center">
							<div class="col-6 col-sm-8 col-lg-10 border-bottom border-secondary-subtle"></div>
							<button class="col-auto btn btn-sm border-0" type="button"
									data-bs-toggle="collapse"
									data-bs-target="#newComment1">Ответить
							</button>
							<div class="col border-bottom border-secondary-subtle"></div>
						</div>

						<div class="comments-list mt-1 ms-4">
							<div class="comment mt-1">
								<div class="collapse" id="newComment1">
									<form class="form-control border-0 p-0" action="" method="post">
										<input type="hidden" value="1" name="parent_id">
										<div class="form-floating">
                                                         <textarea class="form-control shadow-none" name="comment"
																 maxlength="300" minlength="1" id="text"
																 required style="height: 100px">
                                                         </textarea>
											<label for="text">комментарий</label>
										</div>
										<div class="d-flex justify-content-end">
											<input type="submit" class="btn text-warning small p-1"
													value="отправить">
											<button class="btn text-secondary small p-1" type="button"
													data-bs-toggle="collapse"
													data-bs-target="#newComment1">
												отмена
											</button>
										</div>
									</form>
								</div>
							</div>
							<div class="comment mt-1">
								<div class="comment-header d-flex gap-3">
									<a href="" class="d-block text-decoration-none small rounded-2"
											style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
									<div class="lh-1">
										<p class="m-0 text-body">username </p>
										<p class="text-muted small mt-2">23:12 12 мая 2023</p>
									</div>
									<div class="ms-auto d-flex gap-1 align-items-center align-self-start">
										<button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
												data-bs-placement="top" data-bs-title="Пожаловаться">
											<img src="/img/icons/exclamation.svg" alt="complaint" width="20"
													height="20">
										</button>
									</div>
								</div>
								<div class="comment-body">
									<p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab
										deleniti
										dicta
										distinctio enim et explicabo molestias officia omnis ullam vel!</p>
								</div>
								<div class="comment-footer row align-items-center">
									<div class="col-6 col-sm-8 col-lg-10 border-bottom border-secondary-subtle"></div>
									<button class="col-auto btn btn-sm border-0" type="button"
											data-bs-toggle="collapse"
											data-bs-target="#newComment1">Ответить
									</button>
									<div class="col border-bottom border-secondary-subtle"></div>
								</div>
								<div class="comments-list">
									<div class="comment mt-1">
										<div class="collapse" id="newComment1">
											<form class="form-control border-0 p-0" action="" method="post">
												<input type="hidden" value="1" name="parent_id">
												<div class="form-floating">
                                                         <textarea class="form-control shadow-none" name="comment"
																 maxlength="300" minlength="1" id="text"
																 required style="height: 100px">
                                                         </textarea>
													<label for="text">комментарий</label>
												</div>
												<div class="d-flex justify-content-end">
													<input type="submit" class="btn text-warning small p-1"
															value="отправить">
													<button class="btn text-secondary small p-1" type="button"
															data-bs-toggle="collapse"
															data-bs-target="#newComment1">
														отмена
													</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!--                                ///////////////////////-->
							<div class="comment mt-1">
								<div class="comment-header d-flex gap-3">
									<a href="" class="d-block text-decoration-none small rounded-2"
											style="width: 40px; height: 40px; background: url('/img/avatars/none.jpg') no-repeat transparent; background-size: cover;"></a>
									<div class="lh-1">
										<p class="m-0 text-body">username </p>
										<p class="text-muted small mt-2">23:12 12 мая 2023</p>
									</div>
									<div class="ms-auto d-flex gap-1 align-items-center align-self-start">
										<button type="button" class="btn border-0 p-0" data-bs-toggle="tooltip"
												data-bs-placement="top" data-bs-title="Пожаловаться">
											<img src="/img/icons/exclamation.svg" alt="complaint" width="20"
													height="20">
										</button>
									</div>
								</div>
								<div class="comment-body">
									<p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab
										deleniti
										dicta
										distinctio enim et explicabo molestias officia omnis ullam vel!</p>
								</div>
								<div class="comment-footer row align-items-center">
									<div class="col-6 col-sm-8 col-lg-10 border-bottom border-secondary-subtle"></div>
									<button class="col-auto btn btn-sm border-0" type="button"
											data-bs-toggle="collapse"
											data-bs-target="#newComment1">Ответить
									</button>
									<div class="col border-bottom border-secondary-subtle"></div>
								</div>
								<div class="comments-list">
									<div class="comment mt-1">
										<div class="collapse" id="newComment1">
											<form class="form-control border-0 p-0" action="" method="post">
												<input type="hidden" value="1" name="parent_id">
												<div class="form-floating">
                                                         <textarea class="form-control shadow-none" name="comment"
																 maxlength="300" minlength="1" id="text"
																 required style="height: 100px">
                                                         </textarea>
													<label for="text">комментарий</label>
												</div>
												<div class="d-flex justify-content-end">
													<input type="submit" class="btn text-warning small p-1"
															value="отправить">
													<button class="btn text-secondary small p-1" type="button"
															data-bs-toggle="collapse"
															data-bs-target="#newComment1">
														отмена
													</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!--                            ///////////////////-->
						</div>
					</div>
					<!--                        //////////////////////-->
				</div>
			</div>
	</main>
<?php
$content = ob_get_clean();
$title = '';

return template([
	'content' => $content,
	'title' => $title,
	'user_data' => $user_data
]);
