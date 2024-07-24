<?php require_once(APPPATH . 'etc/cyclox/Const/Gender.php'); ?>
<?php require_once(APPPATH . 'etc/cyclox/Util/AjoccCatConverter.php'); ?>

<h1 class="category-ttl bg_this_year_color">RIDERS</h1>

<!-- Page -->
<div class="page">
	<?= $rider_search_div ?>
	<div class="racer_index">
		<?php if ($searches): ?>
			<?php if ($racers === FALSE): ?>
				<div class="alert alert-danger" role="alert">キーワードもしくはカテゴリーを入力し、検索して下さい。</div>
			<?php elseif (empty($racers)): ?>
				<p>対象となる選手が見つかりませんでした。</p>
				<p>※英数字の半角と全角は別物として検索されます。</br>※AJOCCコードはすべて半角です。</p>
			<?php else: ?>
				<?php if ($paginates) echo $this->pagination->create_links(); ?>
				<h2 class="entry-ttl">検索結果</h2>
				<p>検索ワード：<?php if (isset($search_words)) echo $search_words . ' '; echo ($andor !== 'and') ? '(OR)' : '(AND)'; ?></p>
				<div class="search_result_wrap">
					<table class="search_result_table">
						<tr class="tr01">
							<th class="ajocc_code">AJOCCコード</th>
							<th class="ajocc_category" colspan="2">カテゴリー</th>
							<th class="rider_jcf_code">JCFライセンス</th>
							<th class="rider_team">チーム</th>
						</tr>
							<tr class="tr02">
							<th class="rider_name">氏名</th>
							<th class="rider_name_kana">フリガナ</th>
							<th class="rider_name_roman">ローマ字(姓名)</th>
							<th class="rider_gender">性別</th>
							<th class="rider_native_place">都道府県</th>
						</tr>
						<?php foreach ($racers as $r): ?>
						<tr class="tr01">
							<td class="ajocc_code"><?= anchor('racer/' . h($r['code']), h($r['code'])) ?></td>
							<td colspan="2" class="ajocc_category">
								<?php
								
								$cats = explode(',', str_replace(' ', '', $r['cats']));
								$new_cats = [];
								foreach ($cats as $c) {
									$new_cats[] = AjoccCatConverter::convert($c);
								}
								$new_cats = array_unique($new_cats);
								echo h(implode(', ', $new_cats));
								?>
							</td>
							<td class="rider_jcf_code"><?= empty($r['jcf_number']) ? '' : h($r['jcf_number']) ?></td>
							<td class="rider_team"><?= empty($r['team']) ? '' : h($r['team']) ?></td>
						</tr>
						<tr class="tr02">
							<td class="rider_name"><?= anchor('racer/' . h($r['code']), h($r['family_name']) . ' ' . h($r['first_name'])) ?></td>
							<td class="rider_name_kana"><?= h($r['family_name_kana']) . ' ' . h($r['first_name_kana']) ?></td>
							<td class="rider_name_roman"><?= h($r['family_name_en']) . ' ' . h($r['first_name_en']) ?></td>
							<td class="rider_gender"><?= ($r['gender_obj'] == Gender::$UNASSIGNED) ? '--' : h($r['gender_obj']->express() . '/' . $r['gender_obj']->expressEn()) ?></td>
							<td class="rider_native_place"><?= empty($r['prefecture']) ? '' : h($r['prefecture']) ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<?php if ($paginates) echo $this->pagination->create_links(); ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div> <!-- /.page -->