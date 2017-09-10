<div id="main">
	<h2 class="with_pop"><?= $racer['family_name'] . ' ' . $racer['first_name']; ?></h2>
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
	<dl class="dl-horizontal dl-horizontal_al">
		<dt>選手コード</dt><dd><?= h($racer['code']) ?></dd>
		<dt>ナマエ</dt><dd><?= h($racer['family_name_kana'] . ' ' . $racer['first_name_kana']) ?></dd>
		<dt>Name</dt><dd><?= h($racer['first_name_en'] . ' ' . $racer['family_name_en']) ?></dd>
		<dt>チーム</dt><dd><?= h($racer['team']) ?></dd>
		<dt>性別</dt><dd><?= h($racer['gender_exp']->express()) ?></dd>
		<dt>国籍</dt><dd><?= h($racer['nationality_code']) ?></dd>
		<dt>JCF No.</dt><dd><?= h($racer['jcf_number']) ?></dd>
	</dl>
	<div class="clearfix"></div>
	<h3>カテゴリー所属</h3>
	<?php if (!empty($cats['on'])): ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>カテゴリー</th>
					<th>所属期間</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cats['on'] as $oncat): ?>
				<tr>
					<td><?= h($oncat['category_code']) ?></td>
					<td><?= h($oncat['apply_date'] . '〜' . $oncat['cancel_date']) ?></td>
					<td>
						<?php
						if ($oncat['result_linkable'])
						{
							echo '関連する大会データを閲覧';
						}
						?>
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
					<a data-toggle="collapse" href="#collapse1">将来所属予定のカテゴリー</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>カテゴリー</th>
								<th>所属期間</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($cats['future'] as $fcut): ?>
								<tr>
									<td><?= h($fcut['category_code']) ?></td>
									<td><?= h($fcut['apply_date'] . '〜' . $fcut['cancel_date']) ?></td>
									<td></td>
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
					<a data-toggle="collapse" href="#collapse2">過去に所属したカテゴリー</a>
				</h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>カテゴリー</th>
								<th>所属期間</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($cats['old'] as $oldcat): ?>
								<tr>
									<td><?= h($oldcat['category_code']) ?></td>
									<td><?= h($oldcat['apply_date'] . '〜' . $oldcat['cancel_date']) ?></td>
									<td>
										<?php
										if ($oldcat['result_linkable']) {
											echo '関連する大会データを閲覧';
										}
										?>
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
</div>
