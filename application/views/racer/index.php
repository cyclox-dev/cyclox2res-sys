<div id="main">
	<div class="racer_index">
		<?= $rider_search_div ?>
		<?php if (!is_array($racers)): ?>
			<div class="alert alert-danger" role="alert">
				<?= $racers ?>
			</div>
		<?php else: ?>
		検索リザルト
		
		<?php endif; ?>
	</div>
</div>