<div id="main">
	<h2><?= h($meet['meet_name']); ?></h2>
	<p>
		日付：<?= h($meet['at_date']) ?></br>
		会場：<?= h($meet['location']) ?></br>
		主催：<?= h($meet['organized_by']) ?></br>
		大会HP：<a href="<?= $meet['meet_hp']; ?>"><?= h($meet['meet_hp']) ?></a></br>
		シリーズ：<a href="<?= site_url('meet_groups/' . h($meet['meet_group_code'])); ?>"><?= h($meet['mg_name']) ?></a></br>
	</p>
	<h3>レース</h3>
	<?php if (empty($ecats)): ?>
	<p>エントリー／リザルトがありません。</p>
	<?php else: ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>スタート</th>
				<th>レース</th>
				<th>エントリー</th>
				<th>Winner</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($ecats as $e): ?>
				<tr>
					<td><?= h($e['prepared_start_clock']) ?></td>
					<td><a href ="<?= site_url('race/' . h($e['ec_id'])) ?>"><?= h($e['ec_name']) ?></a></td>
					<td><?= h($e['count(*)']) . '名' ?></td>
					<td>
						<?php if (!empty($e['top'])): ?>
						<a href="<?= site_url('racer/' . h($e['top']['racer_code'])) ?>">
							<?= h($e['top']['name']) ?>
							<?php if (!empty($e['top']['team'])) echo '／' . $e['top']['team']; ?>
						</a>
						<?php endif; ?>
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
					<td><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['racer_code']) . '／' . h($r['name_at_race']) ?></a></td>
					<td><?= h($r['team_name']) ?></td>
					<td><a href ="<?= site_url('race/' . h($r['entry_category_id'])) ?>"><?= h($r['ec_name']) ?></a></td>
					<td><?= h($r['cr_cat_code']) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
</div>