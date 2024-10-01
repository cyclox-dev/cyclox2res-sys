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
		<dt>AJOCCコード</dt><dd><?= h($racer['code']) ?>&nbsp;</dd>
		<dt>カテゴリー</dt>
		<dd>
			<?php
			require_once(APPPATH . 'etc/cyclox/Const/CategoryReason.php');
			require_once(APPPATH . 'etc/cyclox/Util/AjoccCatConverter.php');
			
			$ucats = ['C1', 'C2', 'C3', 'CL1', 'CM1', 'CM2'];
			$dcats = ['C2', 'C3', 'C4', 'CL2', 'CM2', 'CM3'];
			$ctgs = [];
			foreach ($cats['on'] as $oncat)
			{
				$catcode = $oncat['category_code'];
				$plus_str = '';
				
				// シーズン残留or降格
				if ($shows_rankdown_exp)
				{
					$ts = strtotime($oncat['apply_date']);
					
					if (in_array($catcode, $dcats))
					{
						if (date('Y/m/d', $ts) == date('' . date('Y') . '/04/01')
								&& $oncat['reason_id'] == CategoryReason::$SEASON_DOWN->ID())
						{
							$plus_str .= '（20' . date('y') . '-' . (date('y') + 1) . '）※20' .  (date('y') - 1) . '-' . date('y') . 'リザルトで降格';
						}
					}
					
					if (in_array($catcode, $ucats))
					{
						if (date('Y/m/d', $ts) < date('' . date('Y') . '/04/01'))
						{
							$plus_str .= '（20' . date('y') . '-' . (date('y') + 1) . '）※20' .  (date('y') - 1) . '-' . date('y') . 'リザルトで残留';
						}
					}
					
					if (in_array($catcode, ['C1', 'C2', 'C3']))
					{
						if (date('Y/m/d', $ts) == date('' . date('Y') . '/04/01')
								&& $oncat['reason_id'] == CategoryReason::$SEASON_UP->ID())
						{
							$plus_str .= '（' . (date('y') - 1) . '-' . date('y') . '昇格）';
						}
					}
				}
					
				$catcode = AjoccCatConverter::convert($catcode) . $plus_str;
				
				if (!in_array($catcode, $ctgs))
				{
					$ctgs[] = $catcode;
				}
			}
			$cstr = "";
			foreach ($ctgs as $c)
			{
				if (strlen($cstr) == 0)
				{
					$cstr = $c;
				}
				else
				{
					$cstr .= ', ' . $c;
				}
			}
			
			echo $cstr;
			?>
			&nbsp;
		</dd>
		<dt>フリガナ</dt><dd><?= h($racer['family_name_kana'] . ' ' . $racer['first_name_kana']) ?>&nbsp;</dd>
		<dt>Name</dt><dd><?= h($racer['first_name_en'] . ' ' . $racer['family_name_en']) ?>&nbsp;</dd>
		<dt>性別</dt><dd><?= h($racer['gender_exp']->express()) ?>&nbsp;</dd>
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
				$tail = substr($ranking['season_name'], 2, 2); // 2023-24からカテゴリー表示名変更
				$cat_code = $ranking['category_code'];
				
				$title = h($ranking['season_name']) . ' ' . h(AjoccCatConverter::convert($cat_code, '20'.$tail.'-04-01'));

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
						if ($r['at_date'] >= '2018-04-01')
						{
							echo '---';
						}
						else if (!empty($r['hps']))
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
							echo h(AjoccCatConverter::convert($r['rank_up_to'], $r['at_date']) . 'へ昇格');
						}
					?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<p class="proviso">※17-18シーズン以降のリザルトのみを表示しています。</p>
	<?php endif; ?>
</div>