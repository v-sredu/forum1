<div class="d-flex align-items-center mb-2">
	<div class="border-top w-100">
	</div>
	<div class="btn-group">
		<button class="btn dropdown-toggle btn-sm border-0" type="button" id="buttonSort">
			Сортировать по:
		</button>
		<ul class="dropdown-menu border-0 shadow-sm" id="modalSort">
			<?php foreach ($data as $key => $text) : ?>
				<li><a class="dropdown-item small"
						href="<?=link_create('sort', $key)?>"><?= $text ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
