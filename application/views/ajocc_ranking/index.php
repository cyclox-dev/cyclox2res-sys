<div id="main">
	<div class="ajocc_ranking_index">
		<h2>AJOCC ランキング</h2>
		<div class="rankings">
		<?php foreach($rankings as $ss_id => $season_r): ?>
			<h3><?= h($season_r['__name__']) ?></h3>
			<?php unset($season_r['__name__']); ?>
			<?php foreach ($season_r as $set_id => $setting_r): ?>
				<?php if (!empty($setting_r['__name__'])) echo '<h4>' . h($setting_r['__name__']) . '</h4>'; ?>
				<?php unset($setting_r['__name__']); ?>
				<?php foreach ($setting_r as $cat): ?>
					<?= anchor('ajocc_ranking/' . $ss_id . '/' . $set_id . '/' . h($cat['code']), h($cat['name'])); ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
		<?php endforeach; ?>
		</div>
	</div>
</div>