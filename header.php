<?php 
$company_phones = ACF_class::getList('company_phones');
$company_links = ACF_class::getList('company_links');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- VUE.JS -->
	<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<!-- BOOTSTRAP -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<!-- FONT AWESSOME -->
	<script src="https://use.fontawesome.com/e8a42d7e14.js"></script>
	<!-- MASKEDINPUT -->
	<script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js" type="text/javascript"></script>
	<!-- favicon -->
	<link rel="shortcut icon" href="<?php echo  get_site_icon_url();?>">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo  get_site_icon_url();?>">

	<title>Document</title>
</head>
<body>

	<div class="container">
		<div class="row justify-content-between align-items-center">
			<div class="col-lg-2 col-md-3 col-sm-6 col-6 pt-1">
				<a href="/" class="d-block">
					<img class="w-100" src="<?php echo wp_get_attachment_url(get_theme_mod('custom_logo')); ?>" alt="">
				</a>
			</div>			
			<div class="d-flex col-lg-4 col-md-4 col-sm-6 col-6 pt-1 text-end">
				<?php foreach ($company_links as $key => $value): ?>
					<a href="<?php echo $value['post_content'] ?>" 
						class="text-decoration-none p-1" 
						data-bs-toggle="tooltip"
						data-bs-placement="bottom"
						data-bs-title="<?php echo $value['post_title'] ?>"
						target="_blank">
						<?php if (isset($value['image'])): ?>
							<img src="<?php echo $value['image'] ?>" alt="">
						<?php endif ?>
					</a><br>
				<?php endforeach ?>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-12 col-12 pt-1">
				<?php foreach ($company_phones as $key => $value): ?>
					<a href="tel:<?php echo $value['post_content'] ?>" class="text-decoration-none">
						<?php if (isset($value['image'])): ?>
							<img width="20" src="<?php echo $value['image'] ?>" alt="">
						<?php endif ?>
						<?php echo $value['post_title'] ?>
						<?php echo $value['post_content'] ?>
					</a><br>
				<?php endforeach ?>
			</div>
		</div>
