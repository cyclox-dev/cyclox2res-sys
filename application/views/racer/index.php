<?php require_once(APPPATH . 'etc/cyclox/Const/Gender.php'); ?>

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
			<?php if ($paginates) echo $this->pagination->create_links(); ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>選手コード</th>
						<th>氏名</th>
						<th>チーム</th>
						<th class="cell__gender">性別</th>
						<th class="cell__nationality">国籍</th>
						<th class="cell__category">Category</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($racers as $r): ?>
					<tr>
						<td><?= anchor('racer/' . h($r['code']), h($r['code'])) ?></td>
						<td><?= anchor('racer/' . h($r['code']), h($r['family_name'] . ' ' . h($r['first_name']))) ?></td>
						<td><?= h($r['team']) ?></td>
						<td class="cell__gender">
							<?= ($r['gender_obj'] == Gender::$UNASSIGNED) ? '--' : h($r['gender_obj']->charExp()) ?>
						</td>
						<td class="cell__nationality"><?= h($r['nationality_code']) ?></td>
						<td class="cell__category"><?= h($r['cats']) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php if ($paginates) echo $this->pagination->create_links(); ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>