<div id="main">
	<div class="racer_index">
		<?= $rider_search_div ?>
		<?php if ($racers === FALSE): ?>
			<div class="alert alert-danger" role="alert">キーワードもしくはカテゴリーを入力し、検索して下さい。</div>
		<?php elseif (empty($racers)): ?>
			<p>対象となる選手が見つかりませんでした。</p>
			<p>※英数字の半角と全角は別物として扱われます。</br>※登録されていないデータは表示されません。</p>
		<?php else: ?>
		検索！
		
		<?php endif; ?>
	</div>
</div>