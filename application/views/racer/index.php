<div id="main">
	<div class="racer_index">
		<?= $rider_search_div ?>
		<?php if ($racers === FALSE): ?>
			<div class="alert alert-danger" role="alert">キーワードもしくはカテゴリーを入力し、検索して下さい。</div>
		<?php elseif (empty($racers)): ?>
			<p>対象となる選手が見つかりませんでした。</p>
			<p>※英数字の半角と全角は別物として検索されます。</br>※選手コードはすべて半角です。</p>
		<?php else: ?>
		<?php foreach ($racers as $r): ?>
			<?= $r['first_name']; ?>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>