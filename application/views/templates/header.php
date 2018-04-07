<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet">
		<link href="<?= base_url('assets/css/owl.carousel.css'); ?>" rel="stylesheet">
		
		<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous">
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
		<script src="<?= base_url('assets/js/owl.carousel.js'); ?>"></script>
		<script src="<?= base_url('assets/js/main.js'); ?>"></script>
		
		<title>AJOCC Cross System</title>
	</head>
	<body>
		<div class="container-fluid main_container">
			<!-- Header -->
			<header>
				<div class="header_inner clearfix">
					<h1 class="sp-logo"><a href="http://www.cyclocross.jp/"><img src="<?= base_url('img/sp/hdr-logo.svg'); ?>" alt="AJOCC 一般社団法人日本シクロクロス競技主催者協会" /></a><span class="align-bottom">DataSystem</span></h1>
					<span class="sp-menu" title="MENU OPEN" id="headerMenu"><img src="<?= base_url('img/sp/hdr-menu.png'); ?>" alt="MENU" /></span>
					<div class="sp-rankings"><a href="<?= base_url('point_series'); ?>"><img src="<?= base_url('img/sp/hdr-rankings.png'); ?>" alt="ランキング" /></a></div>
					<ul class="navi pull-right" id="headerMenuMain">
						<li class="home"><a href="http://www.cyclocross.jp/" class="mo"><img class="sp_none" src="<?= base_url('img/cmn/navi-home_off.gif'); ?>" alt="ホーム"></a></li>
						<li class="news"><a href="http://www.cyclocross.jp/news/" class="mo"><img src="<?= base_url('img/cmn/navi-news_off.gif'); ?>" alt="ニュース" class="sp_none"></a></li>
						<li class="about"><a href="http://www.cyclocross.jp/about/" class="mo"><img src="<?= base_url('img/cmn/navi-about_off.gif'); ?>" alt="AJOCCについて" class="sp_none"></a></li>
						<li class="rankings"><a href="<?= base_url('point_series'); ?>" class="mo"><img src="<?= base_url('img/cmn/navi-rankings_off.gif'); ?>" alt="ランキング" class="sp_none"></a></li>
						<li class="results"><a href="<?= base_url('meets'); ?>" class="mo"><img src="<?= base_url('img/cmn/navi-results_off.gif'); ?>" alt="リザルト" class="sp_none"></a></li>
						<li class="calendar"><a href="http://www.cyclocross.jp/calendar/" class="mo"><img src="<?= base_url('img/cmn/navi-calendar_off.gif'); ?>" alt="カレンダー" class="sp_none"></a></li>
						<li class="riders"><a href="<?= base_url('racers'); ?>" class="mo"><img src="<?= base_url('img/cmn/navi-riders_off.gif'); ?>" alt="選手検索" class="sp_none"></a></li>
						<li class="partners"><a href="http://www.cyclocross.jp/partners/" class="mo"><img src="<?= base_url('img/cmn/navi-partners_off.gif'); ?>" alt="オフィシャルパートナー" class="sp_none"></a></li>
						<!--
						<li class="sns"><span class="sns-youtube"><a href="https://www.youtube.com/channel/UCRN8-g9eqNBhmXhRF_EQ82g" class="out mo"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></span><span class="sns-tw"><a href="https://twitter.com/cyclocross_jp" class="out mo"><i class="fa fa-twitter" aria-hidden="true"></i></a></span><span class="sns-fb"><a href="https://www.facebook.com/cyclocross.jp" class="out mo"><i class="fa fa-facebook" aria-hidden="true"></i></a></span></li>
						-->
					</ul>
				</div>
			</header>
			<!-- END of Header -->
			
			<!-- PARTNERS LOGO -->
			<div class="ptnr_logo_head">
				<ul class="owl-carousel">
					<li><a href="http://www.rapha.cc/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_rapha.svg'); ?>" width="255" height="105" alt="Rapha"></a></li>
					<li><a href="http://www.champ-sys.jp/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_championsystem.svg'); ?>" width="255" height="105" alt="Champion System"></a></li>
					<li><a href="http://www.trekbikes.co.jp/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_trek.svg'); ?>" width="255" height="105" alt="TREK"></a></li>
					<li><a href="http://tsss.co.jp/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_tsss.jpg'); ?>" width="255" height="105" alt="OnebyESU"></a></li>
					<li><a href="http://www.irc-tire.com/ja/bc/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_irc.svg'); ?>" width="255" height="105" alt="IRC TIRE"></a></li>
					<li><a href="http://www.bs-supply.jp/sports-epa/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_nissui.jpg'); ?>" width="255" height="105" alt="ニッスイ SPORTS EPA"></a></li>
					<li><a href="https://www.canyon.com/ja/specials/takeflite/?utm_campaign=InfliteCFSLX-JP-Aug-2017&utm_medium=display&utm_source=cyclocross.jp&utm_content=&utm_term=" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_canyon.svg'); ?>" width="255" height="105" alt="Canyon"></a></li>
					<li><a href="http://www.giant.co.jp/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_giant.svg'); ?>" width="255" height="105" alt="GIANT"></a></li>
					<li><a href="https://www.wslc.co.jp/bike/northwave/" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_northwave.svg'); ?>" width="255" height="105" alt="Northwave"></a></li>
					<li><a href="https://www.santacruzbicycles.com/ja-JP/stigmata" target="_blank"><img src="<?= base_url('img/partners/ptnr_logo_santacruz.svg'); ?>" width="255" height="105" alt="Santa Cruz Bicycles"></a></li>
				</ul>
			</div>
			<!-- /PARTNERS LOGO -->
			
			<div id="flash_view">
				<?php
				if (isset($xsys_flash_error_list))
				{
					foreach ($xsys_flash_error_list as $e)
					{
						echo '<div class="alert alert-danger" role="alert">' . $e . '</div>';
					}
				}
				
				if (isset($xsys_flash_info_list))
				{
					foreach ($xsys_flash_info_list as $i)
					{
						echo '<div class="alert alert-info" role="alert">' . $i . '</div>';
					}
				}
				?>
			</div>
			<div class="convini_link">
				<span>便利Link:</span>
				<a href="<?= base_url('meets'); ?>">大会</a>
				<a href="<?= base_url('point_series'); ?>">PtSeries</a>
				<a href="<?= base_url('ajocc_ranking'); ?>">AjoccRanking</a>
				<a href="<?= base_url('racers'); ?>">選手検索</a>
			</div>