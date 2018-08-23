<?php require_once(APPPATH . 'etc/cyclox/Const/Gender.php'); ?>

<div id="main">
	<div class="racer_view">
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
		<div class="row">
			<div class="col-sm-6 racer">
				<h2><?= $racer['family_name'] . ' ' . $racer['first_name']; ?></h2>
				<dl class="dl-horizontal">
					<dt>選手コード</dt><dd><?= h($racer['code']) ?></dd>
					<dt>フリガナ</dt><dd><?= h($racer['family_name_kana'] . ' ' . $racer['first_name_kana']) ?></dd>
					<dt>Name</dt><dd><?= h($racer['first_name_en'] . ' ' . $racer['family_name_en']) ?></dd>
					<dt>チーム</dt><dd><?= h($racer['team']) ?></dd>
					<dt>性別</dt><dd><?= h($racer['gender_exp']->express()) ?></dd>
					<dt>国籍</dt><dd><?= h($racer['nationality_code']) ?></dd>
					<dt>JCF No.</dt><dd><?= h($racer['jcf_number']) ?></dd>
				</dl>
				<div class="clearfix"></div>
			</div>
			<?php if (!empty($rankings)): ?>
			<div class="col-sm-6 ranking">
				<div id="series_ranking">
					<h3>ランキング</h3>
					<?php if (empty($rankings)): ?>
					<p>取得ポイントがありません。</p>
					<?php else: ?>
					<dl class="dl-horizontal">
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
					<h3>AJOCC ポイント</h3>
					<?php if (empty($ajocc_rankings)): ?>
					<p>取得ポイントがありません。</p>
					<?php else: ?>
					<dl class="dl-horizontal">
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
				<div class="clearfix"></div>
			</div>
			<?php endif; ?>
		</div>
		<h3>カテゴリー所属</h3>
		<?php if (!empty($cats['on'])): ?>
			<table class="table table-striped categories">
				<thead>
					<tr>
						<th class="cell__category">カテゴリー</th>
						<th>所属期間</th>
						<th>備考</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($cats['on'] as $oncat): ?>
					<tr>
						<td class="cell__category"><?= h($oncat['category_code']) ?></td>
						<td><?= h($oncat['apply_date'] . '〜' . $oncat['cancel_date']) ?></td>
						<td>
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
		<?php if (!empty($cats['future'])): ?>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse1">
							将来所属予定のカテゴリー
							<span class="glyphicon glyphicon-chevron-down pull-right"></span>
						</a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse">
					<div class="panel-body">
						<table class="table table-striped categories">
							<thead>
								<tr>
									<th class="cell__category">カテゴリー</th>
									<th>所属期間</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cats['future'] as $fcut): ?>
									<tr>
										<td class="cell__category"><?= h($fcut['category_code']) ?></td>
										<td><?= h($fcut['apply_date'] . '〜' . $fcut['cancel_date']) ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php if (!empty($cats['old'])): ?>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse2">
							過去に所属したカテゴリー
							<span class="glyphicon glyphicon-chevron-down pull-right"></span>
						</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
					<div class="panel-body">
						<table class="table table-striped categories">
							<thead>
								<tr>
									<th class="cell__category">カテゴリー</th>
									<th>所属期間</th>
									<th>備考</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cats['old'] as $oldcat): ?>
									<tr>
										<td class="cell__category"><?= h($oldcat['category_code']) ?></td>
										<td><?= h($oldcat['apply_date'] . '〜' . $oldcat['cancel_date']) ?></td>
										<td>
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
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<p class="proviso">※15-16シーズン以降のカテゴリー所属データのみを表示しています。</p>
		<h3>リザルト</h3>
		<?php if (empty($results)): ?>
			<?php echo '表示可能なリザルトがありません。'; ?>
		<?php else: ?>
			<table class="table table-striped results">
				<thead>
					<tr>
						<th>日付</th>
						<th>レース</th>
						<th class="cell__rank">順位</th>
						<th class="cell__rankper">順位%</th>
						<th class="cell__holdpt">残留Pt</th>
						<th class="cell__ajoccpt">AjoccPt</th>
						<th>備考</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($results as $r): ?>
						<tr>
							<td><?= h(date('Y/m/d', strtotime($r['at_date']))) ?></td>
							<td>
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
</div>
<script>
	(function($) {
		'use strict';
		$('#collapse1, #collapse2').on({
			// 折り畳み開く処理
			'show.bs.collapse': function () {
				$('a[href="#' + this.id + '"] span.glyphicon-chevron-down')
						.removeClass('glyphicon-chevron-down')
						.addClass('glyphicon-chevron-up');
			},
			// 折り畳み閉じる処理
			'hide.bs.collapse': function () {
				$('a[href="#' + this.id + '"] span.glyphicon-chevron-up')
						.removeClass('glyphicon-chevron-up')
						.addClass('glyphicon-chevron-down');
			}
		});
	})(jQuery);
</script>
