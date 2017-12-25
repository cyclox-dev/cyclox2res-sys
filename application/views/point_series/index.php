<div id="main">
	<div class="point_series_index">
		<h2>ポイントシリーズ</h2>
		<p class="proviso">（* はU23以下の選手です。）</p>
		<div class="rankings">
			<?php $needs_grp_title = TRUE; ?>
			<?php foreach($rankings as $psg): ?>
				<div>
					<?php
					//var_dump(json_encode($psg));
					
					if (isset($psg['season_id']))
					{
						if (!isset($season_id) || $season_id != $psg['season_id'])
						{
							echo '<h3> /// ' . h($psg['season_name']) . ' /// </h3>';
							$season_id = $psg['season_id'];
							
							$needs_grp_title = TRUE;
						}
					}
					
					if ($needs_grp_title || $psg['psg_name'] != $psg_name)
					{
						$needs_grp_title = FALSE;
						$psg_name = empty($psg['psg_name']) ? 'その他ランキング' : $psg['psg_name'];
						
						echo '<h3>' . h($psg_name) . '</h3>';
					}
					?>
					<?php foreach($psg['list'] as $r): ?>
						<div class="ps_title">
							<h4><a href='<?= site_url('point_series/') . h($r[0]['ps_id']) ?>'><?= h($r[0]['ps_name']) ?></a></h4>
							<span><?php
								if (!empty($r[0]['modified']))
								{
									echo nice_date($r[0]['modified'], 'Y/m/d H:i') . '更新';
								}
							?></span>
						</div>
						<div class='row point_series'>
							<?php $pre_rank = -1 ?>
							<?php foreach ($r as $psrs): ?>
							<?php if ($psrs['rank'] != $pre_rank): ?>
								<?php if ($pre_rank != -1): ?>
						</div>
								<?php endif; ?>
								<div class="col-sm-4 racers_row">
								<?php $pre_rank = $psrs['rank']; ?>
							<?php endif; ?>
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
							<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>