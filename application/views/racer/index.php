<div id="main">
	<div class="racer_index">
		<?= $rider_search_div ?>
		<?php if ($racers === FALSE): ?>
			<div class="alert alert-danger" role="alert">キーワードもしくはカテゴリーを入力し、検索して下さい。</div>
		<?php else: ?>
		検索リザルト
		
		<?php endif; ?>
	</div>
</div>