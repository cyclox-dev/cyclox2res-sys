<div class="result_list">
	<div class="ranking_list_inr">
		<div id="results_sort" class="clearfix">
			<p class="sort_ttl" id="sort_on"><i class="fa fa-filter fa-2x fa-fw" aria-hidden="true"></i><span>絞込み</span></p>
			<p class="sort_all"><a href="/results/results_all.html">全リザルト</a></p>
			<form name="form1" id="target">
				<select name="select2" id="season_list">
					<option value="">シーズン別</option>
					<option value="9/">2018-19</option>
					<option value="8/">2017-18</option>
				</select>
				<select name="select1" id="area_list">
					<option value="">シリーズ別</option>
					<option value="jcx/">JCX シリーズ</option>
					<option value="hkd/">北海道 (HKD)</option>
					<option value="tcx/">東北 (TCX)</option>
					<option value="ucx/">宇都宮 (UCX)</option>
					<option value="mbs/">前橋 (MBS)</option>
					<option value="cxk/">茨城 (CXK)</option>
					<option value="xtk/">お台場・幕張 (XTK)</option>
					<option value="chb/">千葉 (CHB)</option>
					<option value="shn/">湘南 (SHN)</option>
					<option value="ccm/">信州 (CCM)</option>
					<option value="tki/">東海 (TKI)</option>
					<option value="kns/">関西 (KNS)</option>
					<option value="cch/">中国 (CCH)</option>
					<option value="ccs/">四国 (CCS)</option>
					<option value="jpn/">全日本・マスターズ選手権</option>
				</select>
				<input type="button" onClick="location.href = 'http://www.cyclocross.jp/?meet_group=' + select1.value + select2.value" value="表示" class="btn_sort">
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
							<td class="results_area"><a href="<?php echo site_url('meet?meet_group=' . h($mt['meet_group_code'])); ?>"><?= h($mt['mg_short_name']); ?></a></td>
						<?php endif; ?>
						<td class="resuts_race"><a href="<?php echo site_url('meet/' . h($mt['mt_code'])); ?>"><?= h($mt['mt_name']); ?></a></td>
						<td class="resuts_place"><?= h($mt['location']); ?></td>
					</tr>
			<?php endfor; ?> <!-- $i<count($meets) -->
				</tbody>
			</table>
		<?php endif; ?> <!--  if (!empty($meet_group) -->
		</div>
	</div>
</div>