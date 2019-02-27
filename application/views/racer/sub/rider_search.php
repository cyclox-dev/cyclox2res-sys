<?php echo form_open('racers', ['method' => 'GET']); ?>
	<h2 class="entry-ttl">AJOCC 選手検索</h2>
	<div class="entry-share clear-fix">
		<ul class="clear-fix">
			<!-- Twitter -->
			<li class="tw"><a href="https://twitter.com/share" class="twitter-share-button" data-via="cyclocross_jp" data-size="large" data-hashtags="cxjp" data-count="vertical" data-dnt="true" data-size="large" target="_blank">Tweet</a></li>
			<!-- Facebook -->
			<li class="fb"><div class="fb-share-button" data-size="large" data-layout="button_count"></div></li>
			<!-- LINE -->
			<li class="ln"><a href="http://line.me/R/msg/text/?http://www.cyclocross.jp/about/" target="_blank"><img src="https://data.cyclocross.jp/img/cmn/share_line.png" width="115" height="28" alt="LINEで送る"></a></li>

		</ul>
	</div>
	<p>選手コード、選手名、カナ名、ローマ字名、チーム名で検索ができます。<br>複数キーワード検索する場合は、単語をスペース（半角あるいは全角）で区切って下さい。</p>
	<div class="input_area">
		<span class="input_keywords">検索ワード　<input type="input" class="form-control" name="search_words" value="<?php if (isset($search_words)) echo $search_words; ?>" placeholder="キーワード"></span>
		<span class="input_select">上記検索ワードの…　<br class="sp_only"><input type="radio" name="andor" value="and" <?php echo ($andor === 'and') ? 'checked="checked"' : ''; ?>> 全てを含む (AND)　<input type="radio" name="andor" value="or" <?php echo ($andor !== 'and') ? 'checked="checked"' : ''; ?>> いずれかを含む (OR)</span>
		<span class="input_btn"><input type="submit" id="search_send" value="検索"></span>
	</div>

	<ul class="input_data_info">
		<li>※ローマ字名やチーム名など、データ自体が登録されていない場合には候補に表示されない場合があります。</li>
		<li>※選手データはレース申込時の情報を表示しています。</li>
	</ul>
<?php echo form_close(); ?>