<div id="main">
	<div id="point_series_view">
		<h2><?= h($series['ps_name']) ?></h2>
		<?php /* 情報は表示しない（タイトルのみ）
		<dl class="dl-horizontal dl-horizontal_al">
			<dt></dt><dd><?= h($series['']) ?></dd>
			<dt></dt><dd><?= h($series['']) ?></dd>
			<dt></dt><dd><?= h($series['']) ?></dd>
		</dl>
		<div class="clearfix"></div>
		*/ ?>
		<?php if (empty($ranking)): ?>
			<p>ランキングデータがありません。</p>
		<?php else: ?>
			<p><?= $series['published_at'] . '更新' ?></p>
			<p class="proviso">（* はU23以下の選手です。）</p>
			<table class="table table-striped table-bordered" id="ranking-table">
				<thead>
					<tr>
						<th>順位</th>
						<th><?= h($title_row['name']) ?></th>
						<th><?= h($title_row['team']) ?></th>
						<?php
							$titles = $title_row['pt_titles'];
							$point_count = count($titles);
							foreach ($titles as $t)
							{
								echo '<th class="meet">';
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
							$sumup_titles = $title_row['sumup_titles'];
							$sumup_count = count($sumup_titles);
							foreach ($sumup_titles as $t)
							{
								echo '<th class="sumups">' . $t . '</th>';
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($ranking as $r): ?>
						<tr>
							<td align="center"><?= h($r['rank']) ?></td>
							<td><a href="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name']) ?></a></td>
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
</div>