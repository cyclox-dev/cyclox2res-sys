<div id="main">
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
		<?php $r = $ranking[0]; ?>
		<p><?= $r['modified'] . '更新' ?></p>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>順位</th>
					<th><?= h($r['name']) ?></th>
					<th><?= h($r['team']) ?></th>
					<?php
						$titles = json_decode($r['point_json']);
						$point_count = count($titles);
						foreach ($titles as $t)
						{
							echo '<th><a href="';
							echo site_url('meet/' . h($t->code));
							echo '">' . $t->name . '</a></th>';
						}
					?>
					<?php
						$titles = json_decode($r['sumup_json']);
						$sumup_count = count($titles);
						foreach ($titles as $t)
						{
							echo '<th>' . $t . '</th>';
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php for ($i = 1; $i < count($ranking); $i++): ?>
				<?php $r = $ranking[$i]; ?>
					<tr>
						<td><?= h($r['rank']) ?></td>
						<td><a href="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name']) ?></a></td>
						<td><?= h($r['team']) ?></td>
						<?php
							$pts = json_decode($r['point_json'], TRUE);
							for ($j=0; $j < $point_count; $j++)
							{
								echo '<td>';
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
								echo '<td>';
								if (isset($pts[$j]))
								{
									echo $pts[$j];
								}
								echo '</td>';
							}
						?>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>