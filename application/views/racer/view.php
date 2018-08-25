<?php require_once(APPPATH . 'etc/cyclox/Const/Gender.php'); ?>

<div id="results_contents_rider">
	<?php
	if ($racer['deleted'])
	{
		echo '<p>[！] この選手データは削除されています。</p>';
	}
	if (!empty($racer['united_to']))
	{
		echo '<p>[！] この選手は '
				. '<a href="' . site_url('racer/' . $racer['united_to']) . '">' . $racer['united_to'] . '</a>'
				. ' の選手データに統合されています。</p>';
	}
	?>
	<h1><i class="fas fa-user-circle"></i> <?= $racer['family_name'] . ' ' . $racer['first_name']; ?></h1>

	<dl class="individual_list">
		<dt>選手コード</dt><dd><?= h($racer['code']) ?></dd>
		<dt>フリガナ</dt><dd><?= h($racer['family_name_kana'] . ' ' . $racer['first_name_kana']) ?></dd>
		<dt>Name</dt><dd><?= h($racer['first_name_en'] . ' ' . $racer['family_name_en']) ?></dd>
		<dt>チーム</dt><dd><?= h($racer['team']) ?></dd>
		<dt>性別</dt><dd><?= h($racer['gender_exp']->express()) ?></dd>
		<dt>国籍</dt><dd><?= h($racer['nationality_code']) ?></dd>
		<dt>JCF No.</dt><dd><?= h($racer['jcf_number']) ?>&nbsp;</dd>
	</dl>
	
	<div id="series_ranking">
		<h2 class="ttl_individual"><i class="fas fa-trophy"></i> ランキング</h2>
		<?php if (empty($rankings)): ?>
		<p>取得ポイントがありません。</p>
		<?php else: ?>
		<dl class="individual_list">
			<?php foreach ($rankings as $ranking): ?>
			<dt>
				<a href="<?= site_url('point_series/' . h($ranking['point_series_id'])) ?>">
					<?= h($ranking['ps_name']) ?>
				</a>
			</dt>
			<dd><?php
				echo h($ranking['rank']) . '位';
				if (!empty($ranking['sumup_json']))
				{
					// 第1要素を表示する。
					$total = json_decode($ranking['sumup_json'])[0];
					echo '(' . $total . 'pt)';
				}
			?></dd>
			<?php endforeach; ?>
		</dl>
		<?php endif; ?>
	</div>
	
	<div id="ajocc_ranking">
		<h2 class="ttl_individual"><i class="fas fa-trophy"></i> AJOCC ポイント</h2>
		<?php if (empty($ajocc_rankings)): ?>
		<p>取得ポイントがありません。</p>
		<?php else: ?>
		<dl class="individual_list">
			<?php foreach ($ajocc_rankings as $ranking): ?>
			<dt>
				<?php
				$title = h($ranking['season_name']) . ' ' . h($ranking['category_code']);

				$als_id = 0;
				if (!empty($ranking['als_id']))
				{
					$title .= ' - ' . h($ranking['als_name']);
					$als_id = h($ranking['als_id']);
				}

				$link_to = 'ajocc_ranking/' . h($ranking['ss_id']) . '/' . $als_id
						. '/' . h($ranking['category_code']);

				echo anchor($link_to, $title);
				?>
			</dt>
			<dd><?php
				echo h($ranking['rank']) . '位';
				if (!empty($ranking['sumup_json']))
				{
					// 第1要素を表示する。
					$total = json_decode($ranking['sumup_json'])[0];
					echo '(' . $total . 'pt)';
				}
			?></dd>
			<?php endforeach; ?>
		</dl>
		<?php endif; ?>
	</div>
	
	<div id="ajocc_category">
		<?php if (!empty($cats['on'])): ?>
		<h2 class="ttl_individual">カテゴリー所属</h2>
		<table class="table table-striped categories">
			<thead>
				<tr>
					<th class="cell__category">カテゴリー</th>
					<th class="cell__term">所属期間</th>
					<th class="cell__other">備考</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cats['on'] as $oncat): ?>
				<tr>
					<td class="cell__category"><?= h($oncat['category_code']) ?></td>
					<td class="cell__term"><?= h($oncat['apply_date'] . '〜' . $oncat['cancel_date']) ?></td>
					<td class="cell__other">
						<?php if ($oncat['is_by_rankup']): ?>
						<a href="<?= site_url('meet/' . h($oncat['code'])) ?>">
						<?= h($oncat['season_short_name']) . h($oncat['meet_name']) ?>
						</a>で昇格
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
	
	<div id="ajocc_former-category"> <!-- TODO: class="future" -->
	<?php if (!empty($cats['future'])): ?>
	<h2 class="ttl_individual">将来所属予定のカテゴリー</h2>
		<table class="table table-striped categories">
			<thead>
				<tr>
					<th class="cell__category">カテゴリー</th>
					<th class="cell__term">所属期間</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cats['future'] as $fcut): ?>
					<tr>
						<td class="cell__category"><?= h($fcut['category_code']) ?></td>
						<td class="cell__term"><?= h($fcut['apply_date'] . '〜' . $fcut['cancel_date']) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
	</div>
	
	<div id="ajocc_former-category"> <!-- TODO: class="future" -->
		<?php if (!empty($cats['old'])): ?>
		<h2 class="ttl_individual">過去に所属したカテゴリー</h2>
		<table class="table table-striped categories">
			<thead>
				<tr>
					<th class="cell__category">カテゴリー</th>
					<th class="cell__term">所属期間</th>
					<th class="cell__other">備考</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cats['old'] as $oldcat): ?>
					<tr>
						<td class="cell__category"><?= h($oldcat['category_code']) ?></td>
						<td class="cell__term"><?= h($oldcat['apply_date'] . '〜' . $oldcat['cancel_date']) ?></td>
						<td class="cell__other">
							<?php if ($oldcat['is_by_rankup']): ?>
								<a href="<?= site_url('meet/' . h($oldcat['code'])) ?>">
									<?= h($oldcat['season_short_name']) . h($oldcat['meet_name']) ?>
								</a>で昇格
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
	
	<p class="proviso">※15-16シーズン以降のカテゴリー所属データのみを表示しています。</p>
	
	

	<h2 class="ttl_individual"><i class="fas fa-trophy"></i> リザルト</h2>
	<?php if (empty($results)): ?>
	<p>表示可能なリザルトがありません。</p>
	<?php else: ?>
	<table class="table table-striped results">
		<thead>
			<tr>
				<th class="cell__date">日付</th>
				<th class="cell__race">レース</th>
				<th class="cell__rank">順位</th>
				<th class="cell__rankper">順位<br class="pc_none">%</th>
				<th class="cell__holdpt">残留<br class="pc_none">Pt</th>
				<th class="cell__ajoccpt">Ajocc<br class="pc_none">Pt</th>
				<th>備考</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $r): ?>
				<tr>
					<td class="cell__date"><?= h(date('Y/m/d', strtotime($r['at_date']))) ?></td>
					<td class="cell__race">
						<a href="<?= site_url('race/' . h($r['ec_id'])) ?>">
							<?= h($r['meet_name'] . ' ' . $r['race_name']) ?>
						</a>
					</td>
					<td class="cell__rank"><?= h($r['rank_exp']) ?></td>
					<td class="cell__rankper"><?php
						if (!empty($r['rank_per']))
						{
							echo h($r['rank_per'] . '%');
						}
					?></td>
					<td class="cell__holdpt">
						<?php
						$exp = '';
						if (!empty($r['hps']))
						{
							foreach ($r['hps'] as $hp)
							{
								if (!empty($exp))
								{
									$exp .= ',';
								}

								$exp .= $hp['pt'] . 'pt/' . $hp['cat'];
							}
							echo h($exp);
						}
						?>
					</td>
					<td class="cell__ajoccpt"><?= h($r['ajocc_pt_exp']) ?></td>
					<td><?php
						if (!empty($r['rank_up_to']))
						{
							echo h($r['rank_up_to'] . 'へ昇格');
						}
					?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<p class="proviso">※17-18シーズン以降のリザルトのみを表示しています。</p>
	<?php endif; ?>
</div>