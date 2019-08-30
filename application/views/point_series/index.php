<div id="main">
	<div class="point_series_index">
		<h2>ポイントシリーズ</h2>
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
				if (isset($season_id)) echo '</div></div>';

				echo '<h3>' . h($psg['season_name']) . 'シーズン</h3>';
				$season_id = $psg['season_id'];

				$needs_grp_title = TRUE;
			}
		}
		?>
		<?php if ($needs_grp_title || $psg['psg_name'] != $psg_name): ?>
		<?php if (!$needs_grp_title && $psg['psg_name'] != $psg_name): ?> <!-- 次が異なるグループならばエンドタグを出力 -->
			</div>
		</div>
		<?php endif; ?>
		<div class="panel-group">
			<h4>
			<div class="panel-heading">
				<?php
				{
					$needs_grp_title = FALSE;
					$psg_name = empty($psg['psg_name']) ? 'その他ランキング' : $psg['psg_name'];

					echo '<h5>' . h($psg_name) . '</h5>';
				}
				?>
					<span class="glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
			</h4>
			<div class="panel-body">
	<?php endif; ?>

				<?php foreach($psg['list'] as $r): ?>
				<div class="ranking-box">
					<div class="ps_title">
						<h4><a href='<?= site_url('point_series/') . h($r[0]['ps_id']) ?>'><?= h($r[0]['ps_name']) ?></a></h4>
					</div>
				</div>
				<?php endforeach; ?>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>