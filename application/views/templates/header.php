<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet">
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
		<script src="<?= base_url('assets/js/main.js'); ?>"></script>

		<title>AJOCC Cross System</title>
	</head>
	<body>
		<div class="container-fluid main_container">
			<!-- Header -->
			<header>
				<div class="header_inner clearfix">
					<h1 class="sp-logo pull-left"><a href="/index.html"><img src="<?= base_url('img/sp/hdr-logo.svg'); ?>" alt="AJOCC 一般社団法人日本シクロクロス競技主催者協会" /></a><span class="align-bottom">DataSystem</span></h1>
					<ul class="navi pull-right" id="headerMenuMain">
						<li class="home"><a href="http://www.cyclocross.jp/" class="mo"><img class="sp_none" src="<?= base_url('img/cmn/navi-home_off.gif'); ?>" alt="ホーム"></a></li>
						<li class="news"><a href="/news/" class="mo"><img src="<?= base_url('img/cmn/navi-news_off.gif'); ?>" alt="ニュース" class="sp_none"></a></li>
						<li class="about"><a href="/about/" class="mo"><img src="<?= base_url('img/cmn/navi-about_off.gif'); ?>" alt="AJOCCについて" class="sp_none"></a></li>
						<li class="rankings"><a href="/rankings/" class="mo"><img src="<?= base_url('img/cmn/navi-rankings_off.gif'); ?>" alt="ランキング" class="sp_none"></a></li>
						<li class="results"><a href="/results/" class="mo"><img src="<?= base_url('img/cmn/navi-results_off.gif'); ?>" alt="リザルト" class="sp_none"></a></li>
						<li class="calendar"><a href="/calendar/" class="mo"><img src="<?= base_url('img/cmn/navi-calendar_off.gif'); ?>" alt="カレンダー" class="sp_none"></a></li>
						<li class="riders"><a href="/rider_search/" class="mo"><img src="<?= base_url('img/cmn/navi-riders_off.gif'); ?>" alt="選手検索" class="sp_none"></a></li>
						<li class="partners"><a href="/partners/" class="mo"><img src="<?= base_url('img/cmn/navi-partners_off.gif'); ?>" alt="オフィシャルパートナー" class="sp_none"></a></li>
						<!--
						<li class="sns"><span class="sns-youtube"><a href="https://www.youtube.com/channel/UCRN8-g9eqNBhmXhRF_EQ82g" class="out mo"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></span><span class="sns-tw"><a href="https://twitter.com/cyclocross_jp" class="out mo"><i class="fa fa-twitter" aria-hidden="true"></i></a></span><span class="sns-fb"><a href="https://www.facebook.com/cyclocross.jp" class="out mo"><i class="fa fa-facebook" aria-hidden="true"></i></a></span></li>
						-->
					</ul>
				</div>
			</header>
			<!-- END of Header -->
			
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