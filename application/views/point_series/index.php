<div id="main">
	<div class="point_series_index">
		<h2>ポイントシリーズ</h2>
		<p class="proviso">（* はU23以下の選手です。）</p>
		<div class="rankings">
			<?php foreach($rankings as $r): ?>
				<div>
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
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>