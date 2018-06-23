<div id="main">
	<div id="ajocc_ranking_view">
		<h2><?= h($season['name']) . 'AJOCC ランキング '  . h($title_row['category_code']) ?></h2>
		<?php if (!empty($local_setting)): ?>
		<h3><?= h($local_setting['name']) ?></h3>
		<?php endif; ?>
		<?php if (empty($ranking)): ?>
			<p>ランキングデータがありません。</p>
		<?php else: ?>
			<p><?= $title_row['modified'] . '更新' ?></p>
			<table class="table table-striped table-bordered" id="ranking-table">
				<thead>
					<tr>
						<th>順位</th>
						<th><?= h($title_row['name']) ?></th>
						<th><?= h($title_row['team']) ?></th>
						<?php
							$titles = json_decode($title_row['point_json'], TRUE);
							$point_count = count($titles);
							foreach ($titles as $t)
							{
								echo '<th>';
								if (!empty($t['code']))
								{
									if (isset($t['entry_category_name']))
									{
										$path = site_url('race/' . h($t['code']) . '/' . h(rawurlencode($t['entry_category_name'])));
									}
									else
									{
										$path = site_url('meet/' . h($t['code']));
									}
									echo '<a href="' . $path . '">' . h($t['name']) . '</a>';
								}
								else
								{
									echo h($t['name']);
								}
								echo '</th>';
							}
						?>
						<?php
							$sumup_titles = json_decode($title_row['sumup_json'], TRUE);
							$sumup_count = count($sumup_titles);
							foreach ($sumup_titles as $t)
							{
								echo '<th>' . $t . '</th>';
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($ranking as $r): ?>
						<tr>
							<td align="center"><?= h($r['rank']) ?></td>
							<td>
								<a href="<?= site_url('racer/' . h($r['racer_code'])) ?>">
								<?php if (in_array($r['racer_code'], $rankupper)): ?>
								<?= '☆' ?>
								<?php endif;?>
								<?= h($r['name']) ?>
								</a>
							</td>
							<td><?= h($r['team']) ?></td>
							<?php
								$pts = json_decode($r['point_json'], TRUE);
								for ($j=0; $j < $point_count; $j++)
								{
									echo '<td align="center">';
									if (isset($pts[$j]))
									{
										echo $pts[$j];
									}
									echo '</td>';
								}
							?>
							<?php
								$pts = json_decode($r['sumup_json'], TRUE);
								for ($j=0; $j < $sumup_count; $j++)
								{
									echo '<td align="right">';
									if (isset($pts[$j]))
									{
										echo $pts[$j];
									}
									echo '</td>';
								}
							?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<script src="<?= base_url('assets/js/component/jquery.tablefix_1.0.1.js'); ?>"></script>
	<script>
		function setupTable() {
			var h = window.innerHeight * 0.75;
			var w = window.innerWidth - 80;
			//console.log("w:" + w + ' x h:' + h);
			$('#ranking-table').tablefix({width: w, height: h, fixRows: 1, fixCols: 2});
		}
		
		setupTable(); // at load
		
		// TODO: Window リサイズ時にリセット
	</script>
</div>