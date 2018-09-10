<div id="results_contents_race" class="result_list">
	<div class="result_list_inr">

		<h1 id='js__page_title'><?= h($ecat['meet_name']); ?>（<a href="<?= site_url('meet?meet_group=' . h($ecat['meet_group_code'])); ?>"><?= h($ecat['meet_group_name']) ?></a>）</h1>
		
		
		<h2 class="ttl_rankup "><i class="fas fa-level-up-alt"></i> 昇格者</h2>
		<?php if (empty($meet_rank_ups)): ?>
		<p>（昇格者なし）</p>
		<?php else: ?>
		<table class="table__rankup">
			<thead>
				<tr>
					<th>選手</th>
					<th>チーム</th>
					<th class="cell__races-category">レース</th>
					<th class="cell__rankup-to">昇格先カテゴリー</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($meet_rank_ups as $r): ?>
				<tr>
					<td class="rankup_rider"><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name_at_race']) ?></a></td>
					<td><?= h($r['team_name']) ?></td>
					<td class="cell__races-category"><a href ="<?= site_url('race/' . h($r['entry_category_id'])) ?>"><?= h($r['ec_name']) ?></a></td>
					<td class="cell__rankup-to"><?= h($r['cr_cat_code']) ?></td>
				</tr>
			<?php endforeach; ?>
			</tdoby>
		</table>
		<?php endif; ?><!-- empty($meet_rank_ups) -->
		
		<ul id="cat_tab" class="clearfix">
		<?php foreach ($meet_ecats as $e): ?>
			<?php if ($e['ec_id'] == $ecat_id): ?>
			<li class="selected"><span><?= h($e['ec_name']) ?></span></li>
			<?php else: ?>
			<li>
				<a href ="<?= site_url('race/' . h($e['ec_id'])) ?>">
				<?= h($e['ec_name']) ?>
				</a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
		<h2 id="ec_name" class="ttl_category"><i class="fas fa-bicycle"></i> <?= h($ecat['ec_name']) ?></h2>
		<dl class="clearfix">
			<dt>スタート時刻</dt><dd><?= h($ecat['prepared_start_clock']) ?></dd>
			<dt>距離・周回数</dt>
			<dd>
			<?php
			if (isset($ecat['race_lap']))
			{
				echo sprintf("%.1f", $ecat['sf_dist']) . '+' . sprintf("%.1f", $ecat['lap_dist']) . 'km×' . h($ecat['race_lap'] . 'Lap');
			}
			else
			{
				echo '---';
			}
			?>
			</dd>
			<dt>エントリー</dt><dd><?= h($entried) . '名' ?></dd>
			<dt>スタート</dt><dd><?= h($started) . '名' ?></dd>
			<dt>完走</dt>
			<dd>
			<?php
			echo h($fin) . '名';
			if ($started != 0)
			{
				echo '（完走率' . sprintf('%2.1f', $fin / $started * 100) . '%）';
			}
			?>
			</dd>
		</dl>
		
		<h3><i class="fas fa-trophy"></i> Result</h3>
		<div class="scroll_sp">
			<table class="table__result">
				<thead>
					<tr>
						<th class="cell__rank">順位</th>
						<th class="cell__rider">選手</th>
						<th class="cell__team">チーム</th>
						<th class="cell__timegap">Time/<br class="pc_none">Gap</th>
						<th class="cell__rankper">順位<br class="pc_none">%</th>
						<?php if ($has_holdpoints): ?>
						<th class="cell__holdpt">残留<br class="pc_none">Pt</th>
						<?php endif; ?>
						<?php if ($with_ajoccpt): ?>
						<th class="cell__ajoccpt">Ajocc<br class="pc_none">Pt</th>
						<?php endif; ?>
						<?php
						foreach ($ps_titles as $t)
						{
							echo '<th class="cell__ptseries"><a href="' . site_url('/point_series/') . $t['id'] . '">' . $t['name'] . '</a></th>';
						}
						?>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($results as $r): ?>
					<tr>
						<td class="cell__rank"><?= h($r['rank_exp']) ?></td>
						<td><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name_at_race']) ?></a></td>
						<td><?= h($r['team_name']) ?></td>
						<td class="cell__timegap">
							<?php if (!empty($r['time_gap'])): ?>
								<?= h($r['time_gap']); ?>
							<?php endif; ?>
						</td>
						<td class="cell__rankper"><?php if (!empty($r['rank_per'])) echo h($r['rank_per']) . '%'; ?></td>
						<?php if ($has_holdpoints): ?>
							<td class="cell__holdpt">
								<?php
								$exp = '';
								if (!empty($r['hps'])) {
									foreach ($r['hps'] as $hp) {
										if (!empty($exp)) {
											$exp .= ',';
										}

										$exp .= $hp['pt'] . 'pt/' . $hp['cat'];
									}
									echo h($exp);
								}
								?>
							</td>
							<?php endif; ?>
							<?php if ($with_ajoccpt): ?>
							<td class="cell__ajoccpt">
							<?php
							if (!empty($r['ajocc_pt'])) {
								echo h($r['ajocc_pt']) . 'pt/' . h($r['as_category']);
							}
							?>
							</td>
							<?php endif; ?>
							<?php
							for ($i = 0; $i < sizeof($ps_titles); $i++) {
								echo '<td class="cell__ptseries">';
								if (!empty($r['ps_points'][$i])) {
									echo $r['ps_points'][$i]['pt'];
									if (!empty($r['ps_points'][$i]['bonus'])) {
										echo '+' . $r['ps_points'][$i]['bonus'];
									}
									echo 'pt';
								}
								echo '</td>';
							}
							?>
						<td>
						<?php
						if (!empty($rankuppers[$r['rr_id']])) {
							$cr = $rankuppers[$r['rr_id']];
							echo h($cr['category_code']) . 'へ昇格';
						}
						?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		
		<h3><i class="fas fa-stopwatch"></i> Lap Time</h3>
		<?php if (empty($has_laps)): ?>
			<p>表示できるラップデータがありません。</p>
		<?php else: ?>
		<div class="scroll_sp">
			<table class="table__laptime">
				<thead>
					<tr>
						<th class="cell__rank">順位</th>
						<th class="cell__rider">選手</th>
						<?php for ($i = $lap_min; $i <= $lap_max; $i++): ?>
						<th class="cell__lapat">
							<?php
							if ($i == 0)
							{
								echo 'StartLoop';
							}
							else
							{
								echo $i . '周';
							}
							?>
						</th>
						<?php endfor; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($results as $r): ?>
					<tr>
					<td class="cell__rank"><?= h($r['rank_exp']) ?></td>
					<td class='cell__rider'><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name_at_race']) ?></a></td>
					<?php for ($i = $lap_min; $i <= $lap_max; $i++): ?>
					<td>
						<div class="text-right">
						<?php
							if (!empty($r['lap_times']) && !empty($r['lap_times'][$i]))
							{
								echo $r['lap_times'][$i];
							}
						?>
						</div>
					</td>
					<?php endfor; ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p>※選手名はレース時点のものを表示しています。</p>
		</div>
		<?php endif; ?>
						
		<div><a type="button" name="aaa" value="aaa" id="download_lap_times" class="disabled">ラップタイムCSVダウンロード</a></div>

		<script src="<?= base_url('assets/js/component/csv.js'); ?>"></script>
		<script>
		$('#download_lap_times').click(function() {
			var data = [];
			var title = $("#js__page_title")[0].innerText + " " + $("#ec_name")[0].innerText;
			data.push([title]);
			$(".table__laptime thead tr").each(function(index, elem){
				row = [];
				row.push($("th:first-child", this).text());
				row.push($("th:nth-child(2)", this).text());
				$("th:gt(1)", this).each(function(i, e) {
					var txt = $(e)[0].innerText;
					row.push(txt);
				});
				data.push(row);
			});
			$(".table__laptime tbody tr").each(function(index, elem){
				row = [];
				row.push($("td:first-child", this).text());
				row.push($("td:nth-child(2)", this).children("a").text());
				$("td:gt(1)", this).children("div").each(function(i, e) {
					var txt = $(e)[0].innerText;
					row.push(txt);
				});
				data.push(row);
			});
			exportToCsv('laptimes.csv', data);
		});
		</script>
	</div>
</div>