<?php
function buildTree($comments, $main_id, $current_username, $parent_id = null): string
{
	$result = '';
	foreach ($comments as $comment)
	{
		if ($comment['parent_id'] == $parent_id)
		{
			$children = buildTree($comments, $main_id, $current_username, $comment['id']);
			$button_delete = ($current_username == $comment['username']) ? "<button class='flex-grow-0 btn btn-sm border-0 comment-delete' data-post-id='$main_id' type='button' data-comment='$comment[id]'>Удалить</button>" : '';
			$result .= "
				<div class='comment mt-1 w-100'>
		<div class='comment-header d-flex gap-2'>
			<a href='/user/$comment[username]' class='d-block text-decoration-none small rounded-2'
				style='width: 30px; height: 30px; background: url(/public/img/avatars/$comment[avatar]) no-repeat transparent center; background-size: cover;'></a>
			<div class='lh-1'>
				<p class='m-0'>$comment[username]</p>
				<p class='text-muted small mt-1 mb-0'>$comment[date]</p>
			</div>
		</div>
		<div class='comment-body mt-1'>
			<p class='m-0 text-break'>$comment[text]</p>
		</div>
		<div class='comment-footer d-flex align-items-center'>
			<div class='flex-grow-1 border-bottom border-secondary-subtle'></div>
			<button class='flex-grow-0 btn btn-sm border-0 comment-reply main' type='button' data-comment='$comment[id]'>Ответить</button>
			$button_delete
		</div>
		<div class='comment-list ms-3'>
		<div class='reply mt-1 d-none' id='newComment' data-comment='$comment[id]'>
					<form class='form-control border-0 p-0' action='' method='post' id='commentForm'>
						<input type='hidden' name='parent_id' value='$comment[id]'>
						<input type='hidden' name='post_id' value='$main_id'>
<textarea class='form-control shadow-none' name='text'
		maxlength='300' minlength='1' id='text'
		required style='height: 100px'></textarea>
<div class='d-flex justify-content-end'>
	<input type='submit' class='btn text-warning small p-1' value='отправить'>
	<button class='btn text-secondary small p-1 comment-reply' data-comment='$comment[id]' type='button'>
		отмена
	</button>
</div>
</form>
</div>$children</div></div>";
		}
	}
	return $result;
}
 ?>
<div class="comments-list mt-1">
	<div class="reply" id="newComment" data-comment="main">
		<form class="form-control border-0 p-0" action="" method="post" id="commentForm">
			<input type="hidden" name="parent_id" value="null">
			<input type="hidden" name="post_id" value="<?=$main_id?>">
			<textarea class="form-control shadow-none" name="text"
				maxlength="300" minlength="1"
				required style="height: 80px"></textarea>
			<div class="d-flex justify-content-end">
				<input type="submit" class="btn text-warning small p-1" value="отправить">
			</div>
		</form>
	</div>
	<?=buildTree($comments,  $main_id, $current_username)?>
</div>
