<div id="main">
	<div class="racer_index">
		<?= $rider_search_div ?>
		<?php if ($searches): ?>
			<?php if ($racers === FALSE): ?>
				<div class="alert alert-danger" role="alert">キーワードもしくはカテゴリーを入力し、検索して下さい。</div>
			<?php elseif (empty($racers)): ?>
				<p>対象となる選手が見つかりませんでした。</p>
				<p>※英数字の半角と全角は別物として検索されます。</br>※選手コードはすべて半角です。</p>
			<?php else: ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>選手コード</th>
						<th>氏名</th>
						<th>チーム</th>
						<th>性別</th>
						<th>国籍</th>
						<th>カテゴリー</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($racers as $r): ?>
					<tr>
						<td><?= anchor('racer/' . h($r['code']), h($r['code'])) ?></td>
						<td><?= anchor('racer/' . h($r['code']), h($r['family_name'] . ' ' . h($r['first_name']))) ?></td>
						<td><?= h($r['team']) ?></td>
						<td><?= h($r['gender_exp']) ?></td>
						<td><?= h($r['nationality_code']) ?></td>
						<td><?= h($r['cats']) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>