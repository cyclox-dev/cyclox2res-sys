<?php require_once(APPPATH . 'etc/cyclox/Const/MeetStatus.php'); ?>

<div id="results_contents_race" class="result_list">
	<div class="result_list_inr">

		<h1><?= h($meet['meet_name']); ?>（<a href="<?= site_url('meet?meet_group=' . h($meet['meet_group_code'])); ?>"><?= h($meet['mg_name']) ?></a>）</h1>
		
		<?php 
		if ($meet['meet_status'] != MeetStatus::$NORMAL->ID()) {
			echo '<p>※本大会は' . MeetStatus::statusAt($meet['meet_status']->doneMsg()) . '</p>';
		}
		?>
		
		<h2 class="ttl_rankup "><i class="fas fa-level-up-alt"></i> 昇格者</h2>
		<table class="table__rankup">
			<thead>
				<tr>
					<th>選手</th>
					<th>チーム</th>
					<th class="cell__races-category">レース</th>
					<th class="cell__rankup-to">昇格先カテゴリー</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($rank_ups as $r): ?>
				<tr>
					<td class="rankup_rider"><a href ="<?= site_url('racer/' . h($r['racer_code'])) ?>"><?= h($r['name_at_race']) ?></a></td>
					<td><?= h($r['team_name']) ?></td>
					<td class="cell__races-category"><a href ="<?= site_url('race/' . h($r['entry_category_id'])) ?>"><?= h($r['ec_name']) ?></a></td>
					<td class="cell__rankup-to"><?= h($r['cr_cat_code']) ?></td>
				</tr>
			<?php endforeach; ?>
			</tdoby>
		</table>
		
		<ul id="cat_tab" class="clearfix">
		<?php foreach ($ecats as $e): ?>
			<li><a href ="<?= site_url('race/' . h($e['ec_id'])) ?>"><?= h($e['ec_name']) ?></a></li>
		<?php endforeach; ?>
		</ul>
		<p>レースを選択してください。</p>
	</div>
</div>