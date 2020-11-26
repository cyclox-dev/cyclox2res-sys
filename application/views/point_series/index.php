<div class="point_series_index">
	<h1 class="point_series_title"><?php if ($is_before) echo '過去の'; ?>ポイントシリーズランキング</h1>
	<?php
	$needs_grp_title = TRUE;
	?>
	<?php foreach($rankings as $psg): ?>
		<?php
		//var_dump(json_encode($psg));

		if (isset($psg['season_id']))
		{
			if (!isset($season_id) || $season_id != $psg['season_id'])
			{
				if (isset($season_id)) echo '</div>';

				echo '<h2 class="season_title"><i class="fas fa-tree"></i>' . h($psg['season_name']) . 'シーズン</h2>' . PHP_EOL;
				$season_id = $psg['season_id'];

				$needs_grp_title = TRUE;

				// ajocc ranking 出力
				if (isset($ajocc_rankings[$season_id]))
				{
					$season_r = $ajocc_rankings[$season_id];

					unset($season_r['__name__']);
					foreach ($season_r as $set_id => $setting_r) {
						echo "<div class='ranking_box'>" . PHP_EOL;

						if (empty($setting_r['__name__']))
						{
							echo '<h3 class="ranking_title">Ajocc ランキング</h3>' . PHP_EOL;
						}
						else
						{
							echo '<h3 class="ranking_title">' . h($setting_r['__name__']) . '</h3>' . PHP_EOL;
						}
						unset($setting_r['__name__']); // 次の foreach で読ませない。

						echo '<div class="ranking_list">' . PHP_EOL;

						echo '<ul>' . PHP_EOL;
						foreach ($setting_r as $cat)
						{
							echo '<li>' . anchor('ajocc_ranking/' . $season_id . '/' . $set_id . '/' . h($cat['code']), h($cat['name'])) . '</li>' . PHP_EOL;
						}
						echo '</ul>' . PHP_EOL;

						echo '</div>' . PHP_EOL;
						echo '</div>' . PHP_EOL;
					}
				}
			}
		}
		?>
		<?php if ($needs_grp_title || $psg['psg_name'] != $psg_name): ?>
			<?php if (!$needs_grp_title && $psg['psg_name'] != $psg_name): // 次が異なるグループならばエンドタグを出力 ?>
				</div>
			<?php endif; ?>
			<div class="ranking_box">
			<h3 class="ranking_title">
				<?php
				{
					$needs_grp_title = FALSE;
					$psg_name = empty($psg['psg_name']) ? 'その他ランキング' : $psg['psg_name'];

					echo h($psg_name);
				}
				?>
			</h3>

		<?php endif; ?>
		<div class="ranking_list">
			<ul>
			<?php foreach($psg['list'] as $r): ?>
				<li><a href='<?= site_url('point_series/') . h($r[0]['ps_id']) ?>'><?= h($r[0]['ps_name']) ?></a></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endforeach; ?>
	</div>
</div>
