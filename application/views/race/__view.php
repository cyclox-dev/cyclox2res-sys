<div id="main">
	<div class="race_view">
		<p class="title_pop">
			<a href ="<?= site_url('meet/' . h($ecat['meet_code'])) ?>">
				<?= h($ecat['meet_name']) . '（' . h($ecat['meet_group_name']) . '）' ?>
			</a>
		</p>
		<h2 class="with_pop" id="ec_name"><?= h($ecat['ec_name']); ?></h2>
		<dl class="dl-horizontal dl-horizontal_al">
			<dt>スタート時刻</dt><dd><?= h($ecat['prepared_start_clock']) ?></dd>
			<dt>カテゴリー</dt><dd><?= h($ecat['races_category_code']) ?></dd>
			<?php if (!empty($ecat['race_lap'])): ?>
			<dt>距離・周回数</dt><dd><?= sprintf("%.1f", $ecat['sf_dist']) . '+' . sprintf("%.1f", $ecat['lap_dist']) . 'km×' . h($ecat['race_lap'] . 'Lap') ?></dd>
			<?php endif; ?>
			<dt>エントリー</dt><dd><?= h($entried) . '名' ?></dd>
			<dt>スタート</dt><dd><?= h($started) . '名' ?></dd>
			<?php if (!empty($started)): ?>
			<dt>完走</dt><dd><?= h($fin) . '名（完走率' . sprintf('%2.1f', $fin / $started * 100) . '%）' ?></dd>
			<?php endif; ?>
		</dl>
		<h3>リザルト</h3>
		<?php if (empty($results)): ?>
			<p>エントリー／リザルトがありません。</p>
		<?php else: ?>
			<table class="table table-striped table__result">
				<thead>
					<tr>
						<th class="cell__rank">順位</th>
						<th>選手</th>
						<th>チーム</th>
						<th class="cell__timegap">Time/Gap</th>
						<th class="cell__rankper">順位%</th>
						<?php if ($has_holdpoints): ?>
						<th class="cell__holdpt">残留Pt</th>
						<?php endif; ?>
						<?php if ($with_ajoccpt): ?>
						<th class="cell__ajoccpt">AjoccPt</th>
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
								if (!empty($r['hps']))
								{
									foreach ($r['hps'] as $hp)
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
							<?php if ($with_ajoccpt): ?>
							<td class="cell__ajoccpt">
								<?php
								if (!empty($r['ajocc_pt']))
								{
									echo h($r['ajocc_pt']) . 'pt/' . h($r['as_category']);
								}
								?>
							</td>
							<?php endif; ?>
							<?php
							for ($i = 0; $i < sizeof($ps_titles); $i++)
							{
								echo '<td class="cell__ptseries">';
								if (!empty($r['ps_points'][$i]))
								{
									echo $r['ps_points'][$i]['pt'];
									if (!empty($r['ps_points'][$i]['bonus']))
									{
										echo '+' . $r['ps_points'][$i]['bonus'];
									}
									echo 'pt';
								}
								echo '</td>';
							}
							?>
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
			<h3>ラップタイム</h3>
			<?php if (empty($has_laps)): ?>
				<p>表示できるラップデータがありません。</p>
			<?php else: ?>
			<table class="table table-striped table__laptime">
					<thead>
						<tr>
						<th class="cell__rank">順位</th>
						<th>選手</th>
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
							<?php endfor; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($results as $r): ?>
							<tr>
							<td class="cell__rank"><?= h($r['rank_exp']) ?></td>
							<td><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name_at_race']) ?></a></td>
								<?php 
									for ($i = $lap_min; $i <= $lap_max; $i++):
								?>
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
			<?php endif; ?>
			<p class="proviso">※選手名はレース時点のものを表示しています。</p>
		<?php endif; ?>
		<div><a type="button" name="aaa" value="aaa" id="download_lap_times" class="disabled">ラップタイムCSVダウンロード</a></div>

		<script src="<?= base_url('assets/js/component/csv.js'); ?>"></script>
		<script>
		$('#download_lap_times').click(function() {
			var data = [];
			var title = $(".title_pop a")[0].innerText + " " + $("#ec_name")[0].innerText;
			data.push([title]);
			$("#laptime-table thead tr").each(function(index, elem){
				row = [];
				row.push($("th:first-child", this).text());
				row.push($("th:nth-child(2)", this).text());
				$("th:gt(1)", this).children("div").each(function(i, e) {
					var txt = $(e)[0].innerText;
					row.push(txt);
				});
				data.push(row);
			});
			$("#laptime-table tbody tr").each(function(index, elem){
				row = [];
				row.push($("td:first-child", this).text());
				row.push($("td:nth-child(2)", this).children("a").text());
				$("td:gt(1)", this).children("div").each(function(i, e) {
					var txt = $(e)[0].innerText;
					row.push(txt);
				});
				data.push(row);
			});
			exportToCsv('bars.csv', data);
		});
		</script>
	</div>
</div>