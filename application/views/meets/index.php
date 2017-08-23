<div id="main">
	<h2>{title}</h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>開催日</th>
				<th>主催</th>
				<th>大会名</th>
				<th>会場</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($meets as $mt): ?>
				<tr>
					<td><?= h($mt['at_date']); ?></th>
					<td><?= h($mt['meet_group_code']); ?></th>
					<td><a href="<?php echo site_url('meets/' . $mt['code']); ?>"><?= h($mt['name']); ?></a></th>
					<td><?= h($mt['location']); ?></th>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>