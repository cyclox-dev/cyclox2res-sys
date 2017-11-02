<div id="rider_search">
	<h3>選手検索</h3>
	<p>
		選手コード、選手名、カナ名、ローマ字名、チーム名で検索ができます。</br>
		複数キーワード検索する場合は、単語をスペースで区切って下さい。
	</p>
	<?php echo form_open('racers/search', array('class' => 'form-horizontal')); ?>
		<div class="form-group">
			<div class="col-sm-5">
				<select class="form-control" name="category">
					<option value="empty">カテゴリー指定なし</option>
					<?php foreach ($cats as $cat): ?>
					<option value="<?= h($cat['code']) ?>"<?php if (isset($cat_code) && $cat['code'] == $cat_code) echo ' selected="true"'; ?>><?= h($cat['name']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="input" class="form-control" name="search_words" value="<?php if (isset($search_words)) echo $search_words; ?>" placeholder="キーワード">
			</div>
		</div>
		<div class="form-group">
			<div class="text-center">
				<label class="radio-inline">
					<input type="radio" name="andor" value="and" <?php echo ($andor === 'and') ? 'checked="checked"' : ''; ?>>AND検索
				</label>
				<label class="radio-inline">
					<input type="radio" name="andor" value="or" <?php echo ($andor !== 'and') ? 'checked="checked"' : ''; ?>>OR検索
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