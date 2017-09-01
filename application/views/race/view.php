<div id="main">
	<p><?= h($ecat['meet_name']) . '（' . h($ecat['meet_group_name']) . '）' ?></p>
	<h2><?= h($ecat['ec_name']); ?></h2>
	<p>
		スタート：<?= h($ecat['prepared_start_clock']) ?></br>
		レースカテゴリー：<?= h($ecat['races_category_code']) ?></br>
		<?php
		echo $entried. ' Entried／' . $started . ' Started／' . $fin . ' Finished(' . sprintf('%2.1f', $fin / $started * 100) . '%)';
		?>
	</p>
	<h3>リザルト</h3>
	<?php if (empty($results)): ?>
	<p>エントリー／リザルトがありません。</p>
	<?php else: ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>順位</th>
				<th>Status</th>
				<th>Bib</th>
				<th>選手名</th>
				<th>周回数</th>
				<th>タイム</th>
				<th>順位%</th>
				<th>残留Pt</th>
				<th>AjoccPt</th>
				<th>備考</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $r): ?>
				<tr>
					<td><?= h($r['rank']) ?></td>
					<td><?= h($r['status_code']) ?></td>
					<td><?= h($r['body_number']) ?></td>
					<td><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name_at_race']) ?></a></td>
					<td><?= h($r['lap']) ?></td>
					<td><?php if (!empty($r['time'])) echo h($r['time']); ?></td>
					<td><?php if (!empty($r['rank_per'])) echo h($r['rank_per']) . '%'; ?></td>
					<td>
						<?php
						$exp = '';
						if (!empty($r['hold_points_exp']))
						{
							foreach ($r['hold_points_exp'] as $hp)
							{
								if (!empty($exp))
								{
									$exp .= ',';
								}

								$exp .= $hp['pt'] . 'pt/' . $hp['cat'];
							}
							echo h($exp);
						}
						?>
					</td>
					<td>
						<?php
						if (!empty($r['ajocc_pt']))
						{
							echo h($r['ajocc_pt']) . 'pt/' . h($r['as_category']);
						}
						?>
					</td>
					<td>
						<?php
						if (!empty($rankuppers[$r['rr_id']]))
						{
							$cr = $rankuppers[$r['rr_id']];
							echo h($cr['category_code']) . 'へ昇格';
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
</div>