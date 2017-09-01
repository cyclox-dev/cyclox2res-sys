<div id="main">
	<p class="title_pop"><?= h($ecat['meet_name']) . '（' . h($ecat['meet_group_name']) . '）' ?></p>
	<h2 class="with_pop"><?= h($ecat['ec_name']); ?></h2>
	<p>
		スタート：<?= h($ecat['prepared_start_clock']) ?></br>
		レースカテゴリー：<?= h($ecat['races_category_code']) ?></br>
		エントリー：<?= h($entried) . '名' ?></br>
		スタート：<?= h($started) . '名' ?></br>
		完走：<?= h($fin) . '名（完走率' . sprintf('%2.1f', $fin / $started * 100) . '%）' ?></br>
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
				<th>選手</th>
				<th>チーム</th>
				<th>周回数</th>
				<th>タイム</th>
				<th>順位%</th>
				<?php if ($has_holdpoints): ?>
				<th>残留Pt</th>
				<?php endif; ?>
				<th>AjoccPt</th>
				<th>Note</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $r): ?>
				<tr>
					<td><?= h($r['rank']) ?></td>
					<td><?= h($r['status_code']) ?></td>
					<td><?= h($r['body_number']) ?></td>
					<td><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name_at_race']) ?></a></td>
					<td><?= h($r['team_name']) ?></td>
					<td><?php if (!empty($r['lap'])) echo h($r['lap']); ?></td>
					<td><?php if (!empty($r['time'])) echo h($r['time']); ?></td>
					<td><?php if (!empty($r['rank_per'])) echo h($r['rank_per']) . '%'; ?></td>
					<?php if ($has_holdpoints): ?>
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
					<?php endif; ?>
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
	<p class="proviso">※選手名はレース時点のものを表示しています。</p>
</div>