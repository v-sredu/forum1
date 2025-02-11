<?php
$total_page = ceil($post_all / POST_COUNT);
$start_page = max(1, $page - 2);
$end_page = min($total_page, $page + 2);
?>
<ul class="pagination justify-content-end">
	<li class="page-item <?=($page<=1) ? 'disabled' : ''?>">
		<a href="<?=link_create('page', $page - 1)?>"
			class="page-link text-body border-0 border-end">Назад</a>
	</li>
	<?php for ($i = $start_page; $i<=$end_page; $i++) : ?>
		<li class="page-item <?=($page === $i) ? 'active disabled' : ''?> "><a
				href="<?=link_create('page', $i)?>"
				class="page-link text-body border-top-0 border-bottom-0">
				<?=$i?>
			</a></li>
	<?php endfor; ?>
	<li class="page-item <?=($page>=$total_page) ? 'disabled' : ''?>">
		<a href="<?=link_create('page', $page + 1)?>"
			class="page-link text-body border-0 border-end">Вперед</a>
	</li>
</ul>
