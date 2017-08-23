<div id="main">
	<h2><?= h($meet['name']); ?></h2>
	<p>
		日付：<?= h($meet['at_date']); ?></br>
		会場：<?= h($meet['location']); ?></br>
		主催：<?= h($meet['organized_by']); ?></br>
		大会HP：<?= h($meet['homepage']); ?></br>
		シーズン：<?= h($meet['season_id']); ?></br>
		シリーズ：<?= h($meet['meet_group_code']); ?></br>
	</p>
	
</div>