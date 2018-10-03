<!DOCTYPE html>
<html lang="ja" xmlns:fb="https://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<title>
	<?php
	if (!empty($xsys_page_title))
	{
		echo h($xsys_page_title) . ' | ';
	}
	?>
	AJOCC 一般社団法人日本シクロクロス競技主催者協会
</title>
<meta name="keywords" content="北海道シクロクロス,東北CX Project,宇都宮シクロクロス,前橋シクロクロス,茨城シクロクロス,関東シクロクロス,スターライト幕張,シクロクロス東京,シクロクロス千葉,湘南シクロクロス,信州シクロクロス,シクロクロスミーティング,野辺山シクロクロス,シクロクロス富山,東海シクロクロス,関西シクロクロス,中国シクロクロス,山口シクロクロス,シクロクロス四国,シクロクロス,cyclocross,AJOCC,ajocc,ジャパンシクロクロスシリーズ,JCX Series,JCX,jcx">
<meta name="description" content="AJOCC 一般社団法人日本シクロクロス競技主催者協会オフィシャルサイト。日本国内のシクロクロス競技の普及発展、参加のための情報提供の場です。1995年11月に「Cyclocross in Japan」として大会情報の発信や日本からのオピニオンを海外に伝えるために始まり、以後AJOCC（日本シクロクロス競技主催者協会）として事業を継続。現在は全国各地にシクロクロス大会が広がりを見せています。気軽に参加できるシクロクロス大会の運営、競技レベルの向上、公平なルールと全国共通カテゴリー制度の実現のために活動しています。2016年8月より「一般社団法人日本シクロクロス競技主催者協会」として法人化し、発展的に継続していきます。">
<link rel="start" href="https://www.cyclocross.jp/" title="Home">

<!-- css -->
<link rel="stylesheet" type="text/css" href="https://www.cyclocross.jp/css/base2018.css" media="all">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://www.cyclocross.jp/css/owl.carousel.css" media="all">
<link rel="stylesheet" type="text/css" href="https://www.cyclocross.jp/css/this_year.css" media="all">
<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="/css/base.css" media="all">
<![endif]-->

<?php if (isset($xsys_header_css_files)): ?>
	<?php foreach ($xsys_header_css_files as $css): ?>
		<link rel="stylesheet" type="text/css" href="<?= $css ?>" media="all">
	<?php endforeach; ?>
<?php endif; ?>

<!-- script -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="https://www.cyclocross.jp/js/owl.carousel.js"></script>
<script type="text/javascript" src="https://www.cyclocross.jp/js/cmn2018.js"></script>

<?php if (isset($xsys_header_js_files)): ?>
	<?php foreach ($xsys_header_js_files as $js): ?>
		<link rel="stylesheet" type="text/javascript" href="<?= $js ?>" media="all">
	<?php endforeach; ?>
<?php endif; ?>

<!-- og -->
<meta property="og:image" content="https://www.cyclocross.jp/img/cmn/ogp2.png">
<meta property="og:title" content="AJOCC 一般社団法人日本シクロクロス競技主催者協会">
<meta property="og:url" content="https://www.cyclocross.jp/">
<meta property="og:description" content="AJOCC 一般社団法人日本シクロクロス競技主催者協会オフィシャルサイト。日本国内のシクロクロス競技の普及発展、参加のための情報提供の場です。1995年11月に「Cyclocross in Japan」として大会情報の発信や日本からのオピニオンを海外に伝えるために始まり、以後AJOCC（日本シクロクロス競技主催者協会）として事業を継続。現在は全国各地にシクロクロス大会が広がりを見せています。気軽に参加できるシクロクロス大会の運営、競技レベルの向上、公平なルールと全国共通カテゴリー制度の実現のために活動しています。2016年8月より「一般社団法人日本シクロクロス競技主催者協会」として法人化し、発展的に継続していきます。">

<!-- ga -->
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55596444-1', 'auto');
  ga('send', 'pageview');
</script>
</head>
<body>

<!-- Header -->
<div id="hdr">
	<div class="hdr_inner clearfix">
		<div class="logo"><a href="https://www.cyclocross.jp/"><img src="https://www.cyclocross.jp/img/cmn/hdr-logo.svg" alt="AJOCC 一般社団法人日本シクロクロス競技主催者協会" class="sp_none"><img src="https://www.cyclocross.jp/img/sp/hdr-logo.svg" alt="AJOCC 一般社団法人日本シクロクロス競技主催者協会" class="pc_none tb_none"></a></div>
		<span class="sp-menu" title="MENU OPEN" id="headerMenu"><img src="https://www.cyclocross.jp/img/sp/hdr-menu.png" alt="MENU"></span>
		<div class="sp-rankings"><a href="#JcxRankingTop3"><img src="https://www.cyclocross.jp/img/sp/hdr-rankings.png" alt="ランキング"></a></div>
		<ul class="navi" id="headerMenuMain">
			<li class="home"><a href="https://www.cyclocross.jp/" class="mo"><img src="https://www.cyclocross.jp/img/cmn/navi-home_off.gif" alt="ホーム" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-home.png" width="50" height="50" alt="ホーム"><span class="txt">HOME</span></div></a></li>
			<li class="news"><a href="https://www.cyclocross.jp/news/" class="mo"><img src="https://www.cyclocross.jp/img/cmn/navi-news_off.gif" alt="ニュース" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-news.png" width="50" height="50" alt="ニュース"><span class="txt">NEWS</span></div></a></li>
			<li class="about"><a href="https://www.cyclocross.jp/about/" class="mo"><img src="https://www.cyclocross.jp/img/cmn/navi-about_off.gif" alt="AJOCCについて" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-about.png" width="50" height="50" alt="AJOCCについて"><span class="txt">ABOUT</span></div></a></li>
			 <li class="rankings"><img src="https://www.cyclocross.jp/img/cmn/navi-rankings_off.gif" alt="ランキング" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-rankings.png" width="50" height="50" alt="ランキング"><span class="txt">RANKINGS</span></div>
				 <ul class="clearfix">
					 <li><a href="<?= base_url('point_series/108'); ?>">JCX</a></li>
					 <li><a href="<?= base_url('ajocc_ranking/9/0/C1'); ?>">AJOCC</a></li>
					 <!-- <li><a href="">東北</a></li> -->
					 <li><a href="<?= base_url('ajocc_ranking/9/4/C1'); ?>">関東</a></li>
					 <li><a href="<?= base_url('point_series/110'); ?>">信州</a></li>
					 <li><a href="<?= base_url('ajocc_ranking/9/2/C1'); ?>">東海</a></li>
					 <li><a href="<?= base_url('ajocc_ranking/9/3/C1'); ?>">関西</a></li>
					 <li><a href="https://www.cyclocross.jp/rankings/about-rankings.html">種類と解説</a></li>
				 </ul>
			 </li>
			<li class="results"><a href="<?= base_url('meet'); ?>" class="mo"><img src="https://www.cyclocross.jp/img/cmn/navi-results_off.gif" alt="リザルト" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-results.png" width="50" height="50" alt="リザルト"><span class="txt">RESULTS</span></div></a></li>
			<li class="calendar"><a href="https://www.cyclocross.jp/calendar/" class="mo"><img src="https://www.cyclocross.jp/img/cmn/navi-calendar_off.gif" alt="カレンダー" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-calendar.png" width="50" height="50" alt="カレンダー"><span class="txt">CALENDAR</span></div></a></li>
			<li class="riders"><a href="https://www.cyclocross.jp/rider_search/" class="mo"><img src="https://www.cyclocross.jp/img/cmn/navi-riders_off.gif" alt="選手検索" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-riders.png" width="50" height="50" alt="選手検索"><span class="txt">RIDERS</span></div></a></li>
			<li class="partners"><a href="https://www.cyclocross.jp/partners/" class="mo"><img src="https://www.cyclocross.jp/img/cmn/navi-partners_off.gif" alt="オフィシャルパートナー" class="sp_none"><div class="nav_sp"><img src="https://www.cyclocross.jp/img/sp/navi-partners.png" width="50" height="50" alt="オフィシャルパートナー"><span class="txt">PARTNERS</span></div></a></li>
			<li class="sns"><span class="sns-youtube"><a href="https://www.youtube.com/channel/UCRN8-g9eqNBhmXhRF_EQ82g" class="out mo"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></span><span class="sns-tw"><a href="https://twitter.com/cyclocross_jp" class="out mo"><i class="fa fa-twitter" aria-hidden="true"></i></a></span><span class="sns-fb"><a href="https://www.facebook.com/cyclocross.jp" class="out mo"><i class="fa fa-facebook" aria-hidden="true"></i></a></span></li>
		</ul>
	</div>
</div>
<!-- /Header -->

<!-- PARTNERS LOGO -->
<div id="ptnr_logo_list01">
	<ul class="clearfix">
		<li><a href="http://www.rapha.cc/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_rapha.svg" width="255" height="105" alt="Rapha"></a></li>
		<li><a href="http://www.champ-sys.jp/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_championsystem.svg" width="255" height="105" alt="Champion System"></a></li>
		<li><a href="http://www.trekbikes.co.jp/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_trek.svg" width="255" height="105" alt="TREK"></a></li>
		<li><a href="http://tsss.co.jp/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_tsss.jpg" width="255" height="105" alt="OnebyESU"></a></li>
		<li><a href="http://www.irc-tire.com/ja/bc/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_irc.svg" width="255" height="105" alt="IRC TIRE"></a></li>
		<li><a href="http://www.bs-supply.jp/sports-epa/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_nissui.jpg" width="255" height="105" alt="ニッスイ SPORTS EPA"></a></li>
		<li><a href="https://www.canyon.com/ja/specials/takeflite/?utm_campaign=InfliteCFSLX-JP-Aug-2017&utm_medium=display&utm_source=cyclocross.jp&utm_content=&utm_term=" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_canyon.svg" width="255" height="105" alt="Canyon"></a></li>
		<li><a href="http://www.giant.co.jp/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_giant.svg" width="255" height="105" alt="GIANT"></a></li>
		<li><a href="https://www.wslc.co.jp/bike/northwave/" target="_blank"><img src="https://www.cyclocross.jp/img/partners/ptnr_logo_northwave.svg" width="255" height="105" alt="Northwave"></a></li>
	</ul>
</div>
<!-- /PARTNERS LOGO -->

<div id="contents">


<div id="main">