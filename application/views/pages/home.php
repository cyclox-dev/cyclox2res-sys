<div id="main">
	<div id="page_home">
		<?= $rider_search_div; ?>
		<h3>大会</h3>
		<?php if (empty($meets)): ?>
			<p>表示する大会がありません。</p>
		<?php else: ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>開催日</th>
						<th>シリーズ</th>
						<th>大会名</th>
						<th>会場</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($meets as $mt): ?>
						<tr>
							<td><?= h($mt['at_date']); ?></th>
							<td><a href="<?php echo site_url('meets/' . h($mt['meet_group_code'])); ?>"><?= h($mt['mg_short_name']); ?></a></td>
							<td><a href="<?php echo site_url('meet/' . h($mt['mt_code'])); ?>"><?= h($mt['mt_name']); ?></a></th>
							<td><?= h($mt['location']); ?></th>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p><?= anchor('meets', '> 大会一覧'); ?>
		<?php endif; ?>
		<p><?= anchor('point_series', '> ポイントシリーズ一覧'); ?>
		<p><?= anchor('ajocc_ranking', '> AJOCC Point ランキング'); ?> </p>
	</div>
</div>