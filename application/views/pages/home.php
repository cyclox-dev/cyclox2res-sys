<div id="main">
	<div id="page_home">
		<div class="rider_search">
			<h3>選手検索</h3>
			<p>
				選手コード、選手名、カナ名、ローマ字名、チーム名で検索ができます。</br>
				複数キーワード検索する場合は、単語をスペースで区切って下さい。</br>
				（登録されていないキーワードでは検索できません。）
			</p>
			<?php echo form_open('racers/search', array('class' => 'form-horizontal')); ?>
				<div class="form-group">
					<div class="col-sm-5">
						<select class="form-control">
							<option value="empty">カテゴリー指定なし</option>
							<?php foreach ($cats as $cat): ?>
							<option value="<?= h($cat['code']) ?>"><?= h($cat['short_name']) ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div id="contains_noentry" class="col-sm-7 checkbox">
						<label>
							<input type="checkbox" checked="checked" value="contains_noentry">15-16シーズン以降に活動している選手のみ検索する
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="input" class="form-control" name="search_words" placeholder="キーワード">
					</div>
				</div>
				<div class="form-group">
					<div class="text-center">
						<label class="radio-inline">
							<input type="radio" name="andor" value="and" checked="checked">AND検索
						</label>
						<label class="radio-inline">
							<input type="radio" name="andor" value="or">OR検索
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" id="search_send" class="btn btn-default center-block">検索</button>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
		<h3>大会</h3>
		<?php if (empty($meets)): ?>
			<p>表示する大会がありません。</p>
		<?php else: ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>開催日</th>
						<th>シリーズ</th>
						<th>大会名</th>
						<th>会場</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($meets as $mt): ?>
						<tr>
							<td><?= h($mt['at_date']); ?></th>
							<td><a href="<?php echo site_url('meets/' . h($mt['meet_group_code'])); ?>"><?= h($mt['mg_short_name']); ?></a></td>
							<td><a href="<?php echo site_url('meet/' . h($mt['mt_code'])); ?>"><?= h($mt['mt_name']); ?></a></th>
							<td><?= h($mt['location']); ?></th>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	
	
	</div>
</div>