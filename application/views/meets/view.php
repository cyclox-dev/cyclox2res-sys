<div id="main">
	<h2><?= h($meet['meet_name']); ?></h2>
	<p>
		日付：<?= h($meet['at_date']) ?></br>
		会場：<?= h($meet['location']) ?></br>
		主催：<?= h($meet['organized_by']) ?></br>
		大会HP：<a href="<?= $meet['homepage']; ?>"><?= h($meet['homepage']) ?></a></br>
		シーズン：<a href="<?= site_url('seasons/' . $meet['season_id']); ?>"><?= h($meet['ss_name']) ?></a></br>
		シリーズ：<a href="<?= site_url('meet_groups/' . $meet['meet_group_code']); ?>"><?= h($meet['mg_name']) ?></a></br>
	</p>
	<h3>レース</h3>
	<?php if (empty($entries)): ?>
	<p>エントリー／リザルトがありません。</p>
	<?php else: ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>スタート</th>
				<th>レース</th>
				<th>カテゴリー</th>
				<th>優勝者</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($entries as $e): ?>
				<tr>
					<td><?= h($e['start_clock']) ?></td>
					<td><a href ="<?= site_url('race/' . $e['ec_id']) ?>"><?= h($e['ec_name']) ?></a></td>
					<td><?= h($e['races_category_code']) ?></td>
					<td>
						<a href ="<?= site_url('racer/' . $e['racer_code']) ?>">
						<?= h($e['name_at_race']) ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	
	<?php if (!empty($rank_ups)): ?>
	<h3>昇格者</h3>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>選手Code／氏名</th>
				<th>チーム</th>
				<th>レース</th>
				<th>昇格先カテゴリー</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($rank_ups as $r): ?>
				<tr>
					<td><a href ="<?= site_url('racer/' . $r['racer_code']) ?>"><?= h($r['racer_code']) . '／' . h($r['name_at_race']) ?></a></td>
					<td><?= h($r['team_name']) ?></td>
					<td><a href ="<?= site_url('race/' . $r['entry_category_id']) ?>"><?= h($r['ec_name']) ?></a></td>
					<td><?= h($r['cr_cat_code']) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
</div>