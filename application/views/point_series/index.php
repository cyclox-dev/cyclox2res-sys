<div id="main">
	<div class="point_series_index">
		<h2>ポイントシリーズ</h2>
		<p class="proviso">（* はU23以下の選手です。）</p>
		<div class="rankings">
			<?php
			$needs_grp_title = TRUE;
			$panel_number = 1;
			?>
			<?php foreach($rankings as $psg): ?>
			<?php
			//var_dump(json_encode($psg));

			if (isset($psg['season_id']))
			{
				if (!isset($season_id) || $season_id != $psg['season_id'])
				{
					echo '<h3>' . h($psg['season_name']) . 'シーズン</h3>';
					$season_id = $psg['season_id'];

					$needs_grp_title = TRUE;
				}
			}
			?>
			<div>
				<?php if ($needs_grp_title || $psg['psg_name'] != $psg_name): ?>
				<?php if (!$needs_grp_title && $psg['psg_name'] != $psg_name): ?>
					</div>
				</div>
				<?php endif; ?>
				<div class="panel-group">
					<div class="panel panel-default">
						<a data-toggle="collapse" href="#collapse<?php echo $panel_number; ?>">
							<h4>
							<div class="panel-heading">
								<?php
								{
									$needs_grp_title = FALSE;
									$psg_name = empty($psg['psg_name']) ? 'その他ランキング' : $psg['psg_name'];

									echo h($psg_name);
								}
								?>
									<span class="glyphicon glyphicon-chevron-down pull-right"></span>
							</div>
							</h4>
						</a>
						<div id="collapse<?php echo $panel_number; $panel_number++; ?>" class="panel-collapse collapse">
							<div class="panel-body">
				<?php endif; ?>

								<?php foreach($psg['list'] as $r): ?>
								<div class="ranking-box">
									<div class="ps_title">
										<h4><a href='<?= site_url('point_series/') . h($r[0]['ps_id']) ?>'><?= h($r[0]['ps_name']) ?></a></h4>
										<span><?php
											if (!empty($r[0]['modified']))
											{
												echo nice_date($r[0]['modified'], 'Y/m/d H:i') . '更新';
											}
										?></span>
									</div>
									<div class='point_series'>
									<?php $pre_rank = -1 ?>
									<?php foreach ($r as $psrs): ?>
										<div class="racers_row">
											<?php $pre_rank = $psrs['rank']; ?>
											<div>
												<?= h($psrs['rank']) . '位 ' ?>
												<a href="<?= site_url('racer/') . h($psrs['racer_code']) ?>"><?= h($psrs['psrs_name']) ?></a>
												<?php
													$ded = json_decode($psrs['sumup_json']);
													if (!empty($ded))
													{
														echo ' (' . $ded[0] . 'pt)';
													}
												?>
											</div>
											<div class="team"><?= h($psrs['team']) ?></div>
										</div>
									<?php endforeach; ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>