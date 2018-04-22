<div id="main">
	<h2>
		<?php if (!empty($meet_group)): ?>
			<?= h($meet_group['name']) ?>
		<?php else: ?>
			大会リスト
		<?php endif; ?>
	</h2>
	<?php if (empty($meets)): ?>
		<p>表示する大会がありません。</p>
	<?php else: ?>
		<?php $season_id = NULL; ?>
		<?php for ($i=0; $i < count($meets); $i++): ?>
		<?php $mt = $meets[$i]; ?>
		<?php if ($i == 0 || $season_id != $mt['season_id']): ?>
			<?php
				if ($i != 0) {
					echo '</tbody></table>';
				}
				echo '<h2>' . h($mt['season_name']) . '</h2>';
				$season_id = $mt['season_id'];
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>開催日</th>
						<?php if (empty($meet_group)): ?>
							<th>シリーズ</th>
						<?php endif; ?>
						<th>大会名</th>
						<th>会場</th>
					</tr>
				</thead>
				<tbody>
		<?php endif; ?>
					<tr>
						<td><?= h($mt['at_date']); ?></th>
						<?php if (empty($meet_group)): ?>
							<td><a href="<?php echo site_url('meets/' . h($mt['meet_group_code'])); ?>"><?= h($mt['mg_short_name']); ?></a></td>
						<?php endif; ?>
						<td><a href="<?php echo site_url('meet/' . h($mt['mt_code'])); ?>"><?= h($mt['mt_name']); ?></a></th>
						<td><?= h($mt['location']); ?></th>
					</tr>
		<?php endfor; ?>
				</tbody>
			</table>
	<?php endif; ?>
</div>