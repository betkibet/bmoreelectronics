<?php
$meta_keywords = 'Site Maintenance';
$meta_desc = 'Site Maintenance';
$meta_title = 'Site Maintenance';
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="IE=edge" >
	
	<meta name="keywords" content="<?=$meta_keywords?>" />
	<meta name="description" content="<?=$meta_desc?>" />
	<title><?=$meta_title?></title>

	<link rel="stylesheet" href="<?=SITE_URL?>css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?=SITE_URL?>css/main.css">
	<link rel="stylesheet" href="<?=SITE_URL?>css/main_media.css">
	<link rel="stylesheet" href="<?=SITE_URL?>css/custom.css">
</head>
<body class="inner">
	<section id="offline" class="d-flex align-items-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="block p-5 text-center">
						<div class="card">
							<div class="card-body">
								<h1>We’ll be back soon!</h1>
								<p>Sorry for the inconvenience but we’re performing some maintenance at the moment. You can still contact us at <a href="mailto:<?=$site_email?>"><?=$site_email?></a> or call us <a href="tel:<?=$site_phone?>"><?=$site_phone?></a>, otherwise we’ll be back online shortly!</p>
								<h5>&mdash; <?=SITE_NAME?></h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>