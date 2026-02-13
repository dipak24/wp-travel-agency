<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<?php
if (is_front_page()) {
	$body_classes = 'has-banner';
} else {
	$body_classes = '';
}
?>

<body <?php body_class($body_classes); ?>>
	<?php wp_body_open(); ?>
	<div id="wrapper">
		<header id="header">
			<div class="container">
				<div class="header-wrap">
					<div class="logo">
						<?php the_custom_logo(); //width and height controll from fn ?>
					</div>
					<nav id="nav">
						<a href="#" class="nav-opener"><span>opener</span></a>

						<div class="drop">
							<div class="menu-header">
								<div class="logo"><?php the_custom_logo(); ?></div>
								<a href="#" class="nav-close"><span>Close</span></a>
							</div>

							<div class="drop-wrap">
								<?php 
								if (has_nav_menu('primary')) {
									display_megamenu('primary');
								}
								?>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</header>