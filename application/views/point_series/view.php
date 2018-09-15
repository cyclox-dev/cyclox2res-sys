<div class="ranking_list">
	<div class="ranking_list_inr">

		<h1><?= h($series['ps_name']) ?></h1>
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
		<?php if (!empty($series['published_at'])): ?>
		<p><?= $series['published_at'] . '更新' ?></p>
		<?php endif; ?>
		<p class="proviso">（* はU23以下の選手です。）</p>
		<ul id="cat_tab" class="clearfix">
			<?php foreach ($ps_grouped as $gedps): ?>
			<?php if ($gedps['ps_id'] == $ps_id): ?>
			<li class="selected"><span><?= h($gedps['ps_short_name']) ?></span></li>
			<?php else: ?>
			<li><a href ="<?= site_url('point_series/' . h($gedps['ps_id'])) ?>"><?= h($gedps['ps_short_name']) ?></a></li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>

		<table class="ranking_table" id="jcx_ranking_table">
			<thead>
				<tr>
					<th>順位</th>
					<th><?= h($title_row['name']) ?></th>
					<th><?= h($title_row['team']) ?></th>
					
					<?php
						$sumup_titles = $title_row['sumup_titles'];
						$sumup_count = count($sumup_titles);
						foreach ($sumup_titles as $t)
						{
							echo '<th>' . $t . '</th>';
						}
						
						$titles = $title_row['pt_titles'];
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
						
						$sumup_titles = $title_row['sumup_titles'];
						$sumup_count = count($sumup_titles);
						foreach ($sumup_titles as $t)
						{
							echo '<th>' . $t . '</th>';
						}
					?>
				</tr>
			</thead>
			<tbody class="ranking_data">
				<?php foreach ($ranking as $r): ?>
				<tr>
					<td><?= h($r['rank']) ?></td>
					<td><a href="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name']) ?></a></td>
					<td><?= h($r['team']) ?></td>
					<?php
					$pts = json_decode($r['sumup_json'], TRUE);
					for ($j = 0; $j < $sumup_count; $j++) {
						echo '<td>';
						if (isset($pts[$j])) {
							echo $pts[$j];
						}
						echo '</td>';
					}
					
					$pts = json_decode($r['point_json'], TRUE);
					for ($j = 0; $j < $point_count; $j++) {
						echo '<td>';
						if (isset($pts[$j])) {
							echo $pts[$j];
						}
						echo '</td>';
					}
					
					$pts = json_decode($r['sumup_json'], TRUE);
					for ($j = 0; $j < $sumup_count; $j++) {
						echo '<td>';
						if (isset($pts[$j])) {
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
</div>