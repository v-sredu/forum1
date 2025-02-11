<div class="d-none d-lg-block col-2 p-3 border-start">
	<div class="list-group list-group-flush text-center">
		<?php if ($user_data['auth']): ?>
			<a href="/posts/favourites" class="list-group-item rounded-3">избранное</a>
			<a href="/posts/favourites-users" class="list-group-item rounded-3">подписки</a>
			<a href="../../../public/index.php" class="list-group-item rounded-3">настройки</a>
		<?php endif; ?>
	</div>
</div>
</div>
</div>

<footer class="bg-body p-3">
	<p class="text-center text-body-secondary">сделано с любовью</p>
</footer>

<!--modal-->
<div class="modal fade bg-secondary bg-opacity-50 show invisible d-block" id="modalAuthWarning">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Сначала войдите в аккаунт</h1>
				<button type="button" class="btn-close" id="buttonAuthWarning" aria-label="Закрыть"></button>
			</div>
			<div class="modal-body">
				<a href="" class="text-muted text-decoration-none">Вход</a>
				/
				<a href="" class="text-muted text-decoration-none">Регистрация</a>
			</div>
		</div>
	</div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="modalNav">
	<div class="offcanvas-header">
		<button type="button" class="btn-close"  id="buttonNav"  aria-label="Закрыть"></button>
	</div>
	<div class="offcanvas-body">
		<div class="p-3">
			<div class="list-group list-group-flush mb-3">
				<?php if ($user_data['auth']): ?>
					<a href="/user/<?=$user_data['username']?>"
							class="list-group-item rounded-3">аккаунт</a>
					<a href="/posts/favourites" class="list-group-item rounded-3">избранное</a>
					<a href="/posts/favourites-users" class="list-group-item rounded-3">подписки</a>
					<a href="../../../public/index.php" class="list-group-item rounded-3">настройки</a>
				<?php else: ?>
					<a href="" class="list-group-item rounded-3">вход</a>
					<a href="" class="list-group-item rounded-3">регистрация</a>
				<?php endif; ?>
			</div>
			<div class="list-group list-group-flush d-block p-0 text-start">
				<?=$tags_link ?>
			</div>
		</div>
	</div>
</div>


<script src="/public/js/script.js"></script>
</body>
</html>
