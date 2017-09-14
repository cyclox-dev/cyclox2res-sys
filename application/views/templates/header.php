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

		<title>AJOCC Cross System [Beta-Version]</title>
	</head>
	<body>
		<div class="container">
			<header>
				<div><a href="<?= site_url() ?>">AJOCC Cross System [Beta-Version]</a></div>
			</header>
			<div id="flash_view">
				<?php
				if (isset($xsys_flash_error_list))
				{
					foreach ($xsys_flash_error_list as $e)
					{
						echo '<div class="flash_error">' . $e . '</div>';
					}
				}
				
				if (isset($xsys_flash_info_list))
				{
					foreach ($xsys_flash_info_list as $i)
					{
						echo '<div class="flash_info">' . $i . '</div>';
					}
				}
				?>
			</div>