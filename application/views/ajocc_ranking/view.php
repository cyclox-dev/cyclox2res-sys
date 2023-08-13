<?php
	$redlined = FALSE;
?>
<?php require_once(APPPATH . 'etc/cyclox/Util/AjoccCatConverter.php'); ?>

<div class="ranking_list">
	<div class="ranking_list_inr">

		<?php
			$tail = substr($season['name'], 2, 2);
			$cat_date = '20' . $tail . '-04-01';
		?>
		<h1><?= h($season['name']) . 'AJOCC ランキング ' . h(AjoccCatConverter::convert($category_code, $cat_date)) ?></h1>
		
		<?php if (!empty($local_setting)): ?>
		<h3><?= h($local_setting['name']) ?></h3>
		<?php endif; ?>
		
		<?php if (empty($ranking)): ?>
		<p>ランキングデータがありません。</p>
		<?php else: ?>
		<p><?= $title_row['modified'] . '更新' ?></p>
		<ul id="cat_tab" class="clearfix">
			<?php foreach ($cat_codes as $cat_code): ?>
			<?php if ($cat_code == $title_row['category_code']): ?>
			<li class="selected"><span><?= h(AjoccCatConverter::convert($cat_code, $cat_date)) ?></span></li>
			<?php else: ?>
			<li><a href="<?= site_url('ajocc_ranking/' . $season_id . '/' . $local_setting_id . '/' . $cat_code) ?>"><?= h(AjoccCatConverter::convert($cat_code, $cat_date)) ?></a></li>
			<?php endif; ?> <!-- ($cat_code == $title_row('category_code')): ?> -->
			<?php endforeach; ?> <!-- $cat_codes -->
		</ul>
		<table class="ranking_table" id="jcx_ranking_table">
			<thead>
					<tr>
						<th>順位</th>
						<th><?= h($title_row['name']) ?></th>
						<th><?= h($title_row['team']) ?></th>
						<?php
						$sumup_titles = json_decode($title_row['sumup_json'], TRUE);
						$sumup_count = count($sumup_titles);
						foreach ($sumup_titles as $t) {
							echo '<th>' . $t . '</th>';
						}
						
						$titles = json_decode($title_row['point_json'], TRUE);
						$point_count = count($titles);
						foreach ($titles as $t) {
							echo '<th>';
							if (!empty($t['code'])) {
								if (isset($t['entry_category_name'])) {
									$path = site_url('race/' . h($t['code']) . '/' . h(rawurlencode($t['entry_category_name'])));
								} else {
									$path = site_url('meet/' . h($t['code']));
								}
								echo '<a href="' . $path . '">' . h($t['name']) . '</a>';
							} else {
								echo h($t['name']);
							}
							echo '</th>';
						}
						
						$sumup_titles = json_decode($title_row['sumup_json'], TRUE);
						$sumup_count = count($sumup_titles);
						foreach ($sumup_titles as $t) {
							echo '<th>' . $t . '</th>';
						}
						?>
					</tr>
				</thead>
				<tbody class="ranking_data">
					<?php 
						for ($i = 0; $i < count($ranking); $i++): 
					?>
					<?php
						$r = $ranking[$i];
						
						if (!$redlined)
						{
							$exec_red = FALSE;
						
							if ($red_line_rank > 0 && isset($ranking[$i + 1]))
							{
								if ($ranking[$i + 1]['rank'] > $red_line_rank)
								{
									$exec_red = TRUE;
									$redlined = TRUE;
								}
							}

							echo $exec_red ? '<tr class="red_line">' : '<tr>';
						}
					?>
						<td><?= h($r['rank']) ?></td>
						<td>
							<a href="<?= site_url('racer/' . h($r['racer_code'])) ?>">
								<?php if (in_array($r['racer_code'], $rankupper)): ?>
									<?= '☆' ?>
								<?php endif; ?>
								<?= h($r['name']) ?>
							</a>
						</td>
						<td><?= h($r['team']) ?></td>
						<?php
						$pts = json_decode($r['sumup_json'], TRUE);
						for ($j = 0; $j < $sumup_count; $j++) {
							echo '<td>';
							if (is_float($pts[$j]))
							{
								echo sprintf('%.2f', $pts[$j]);
							}
							else
							{
								echo $pts[$j];
							}
							echo '</td>';
						}
						
						$pts = json_decode($r['point_json'], TRUE);
						for ($j = 0; $j < $point_count; $j++) {
							echo '<td align="center">';
							if (isset($pts[$j])) {
								if (is_array($pts[$j])) {
									$ptstr = $pts[$j][0];
									for ($k = 1; $k < count($pts[$j]); $k++)
									{
										$ptstr .= ',' . $pts[$j][$k];
									}

									echo $ptstr;
								}
								else
								{
									// 旧版データ形式への対応のため、残しておく。
									echo $pts[$j];
								}
							}
							echo '</td>';
						}

						$pts = json_decode($r['sumup_json'], TRUE);
						for ($j = 0; $j < $sumup_count; $j++) {
							echo '<td>';
							if (isset($pts[$j])) {
								if (is_float($pts[$j]))
								{
									echo sprintf('%.2f', $pts[$j]);
								}
								else
								{
									echo $pts[$j];
								}
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
</div>