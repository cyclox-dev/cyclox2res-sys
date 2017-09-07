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
	
</div>
