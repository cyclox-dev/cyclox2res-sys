<div class="result_list">
	<div class="result_list_inr">
		<div id="results_sort" class="clearfix">
			<p class="sort_ttl" id="sort_on"><i class="fa fa-filter fa-2x fa-fw" aria-hidden="true"></i><span>絞込み</span></p>
			<p class="sort_all"><a href="<?= site_url("/meet") ?>">全リザルト</a></p>
			<form name="form1" id="target">
				<select name="select2" id="season_list">
					<option value="">シーズン</option>
					<?php foreach($seasons as $ss): ?>
					<option value="<?= h($ss['id']); ?>"
					<?php
					if (!empty($selected_season_id) && $ss['id'] == $selected_season_id)
					{
						echo ' selected';
					}
					?>	
							><?= h($ss['name']); ?></option>
					<?php endforeach; ?>
				</select>
				<select name="select1" id="area_list">
					<option value="">シリーズ</option>
					<?php foreach($meet_groups as $mg): ?>
					<option value="<?= h($mg['code']) ?>"
					<?php
					if (!empty($meet_group) && $mg['code'] == $meet_group['code'])
					{
						echo ' selected';
					}
					?>
							><?= h($mg['name']) ?></option>
					<?php endforeach; ?>
					<!--
					<option value="jcx/">JCX シリーズ</option>
					<option value="jpn/">全日本・マスターズ選手権</option>
					-->
				</select>
				<input type="button" onClick="location.href = '<?= site_url('meet?meet_group=') ?>' + select1.value + '&season=' + select2.value" value="表示" class="btn_sort">
			</form>
		</div>

		<div id="results_contents_all">
			<h2>
				<?php if (!empty($meet_group)): ?>
					<?= h($meet_group['name']) ?>
				<?php else: ?>
					全リザルト
				<?php endif; ?>
			</h2>
			<?php if (empty($meets)): ?>
			<p>表示する大会がありません。</p>
			<?php else: ?>
			<?php $season_id = NULL; ?>
			<?php for ($i=0; $i < count($meets); $i++): ?>
			<?php $mt = $meets[$i]; ?>

			<!-- >>> season exp and title-row -->
			<?php if ($i == 0 || $season_id != $mt['season_id']): ?>
			<?php
				if ($i != 0) {
					echo '</tbody></table>';
				}
				echo '<h2>' . h($mt['season_name']) . '</h2>';
				$season_id = $mt['season_id'];
			?>
			<table>
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
				<!-- <<< season exp and title-row -->
				
					<tr>
						<td class="resuts_date"><?= h($mt['at_date']); ?></td>
						<?php if (empty($meet_group)): ?>
							<td class="results_area"><a href="<?= site_url('meet?meet_group=' . h($mt['meet_group_code'])); ?>"><?= h($mt['mg_short_name']); ?></a></td>
						<?php endif; ?>
						<td class="resuts_race"><a href="<?= site_url('meet/' . h($mt['mt_code'])); ?>"><?= h($mt['mt_name']); ?></a></td>
						<td class="resuts_place"><?= h($mt['location']); ?></td>
					</tr>
			<?php endfor; ?> <!-- $i<count($meets) -->
				</tbody>
			</table>
		<?php endif; ?> <!--  if (!empty($meet_group) -->
		</div>
	</div>
</div>