<div id="main">
	<div>
		<h2>ポイントシリーズ</h2>
		<p class="proviso">（* はU23以下の選手です。）</p>
		<div>
			<?php foreach($rankings as $r): ?>
				<div>
					<h4><a href='<?= site_url('point_series/') . h($r[0]['ps_id']) ?>'><?= h($r[0]['ps_name']) ?></a></h4>
					<div class='row point_series'>
						<?php foreach ($r as $psrs): ?>
						<div class="col-sm-4 racers_row">
							<div>
								<?= h($psrs['rank']) . '位 ' . h($psrs['name']) ?>
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