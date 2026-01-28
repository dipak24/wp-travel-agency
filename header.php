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

					<!-- <nav id="nav">
						<a href="#" class="nav-opener"><span>opener</span></a>
						<div class="drop">
							<div class="menu-header">
								<div class="logo">
									<?php the_custom_logo(); //width and height controll from fn ?>
								</div>

								<a href="#" class="nav-close"><span>Close</span></a>
							</div>
							<div class="drop-wrap">
								<ul>
									<li class="has-megamenu">
										<a href="#">Destination</a>
										<div class="menu-dropdown">
											<div class="menu-dropdown-wrap">
												<div class="left-content">
													<div class="tab-lists">
														<button data-target="dlabel1a">dLevel1a</button>
														<button data-target="dlabel1b">dLevel1b</button>
														<button data-target="dlabel1c">dLevel1c</button>
														<button data-target="dlabel1d">dLevel1d</button>
													</div>
												</div>
												<div class="right-content">
													<div class="tab-content" id="dlabel1a">
														<ul>
															<li><a href="#">Menu1a</a></li>
															<li><a href="#">Menu2a</a></li>
															<li><a href="#">Menu3a</a></li>
															<li><a href="#">Menu4a</a></li>
														</ul>
													</div>
													<div class="tab-content" id="dlabel1b">
														<ul>
															<li><a href="#">Menu1b</a></li>
															<li><a href="#">Menu2b</a></li>
															<li><a href="#">Menu3b</a></li>
															<li><a href="#">Menu4b</a></li>
														</ul>
													</div>
													<div class="tab-content" id="dlabel1c">
														<ul>
															<li><a href="#">Menu1c</a></li>
															<li><a href="#">Menu2c</a></li>
															<li><a href="#">Menu3c</a></li>
															<li><a href="#">Menu4c</a></li>
														</ul>
													</div>
													<div class="tab-content" id="dlabel1d">
														<ul>
															<li><a href="#">Menu1d</a></li>
															<li><a href="#">Menu2d</a></li>
															<li><a href="#">Menu3d</a></li>
															<li><a href="#">Menu4d</a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</li>
									<li class="has-megamenu">
										<a href="#">Travel Style</a>
										<div class="menu-dropdown">
											<div class="menu-dropdown-wrap">
												<div class="left-content">
													<div class="tab-lists">
														<button data-target="tlabel1a">tLevel1a</button>
														<button data-target="tlabel1b">tLevel1b</button>
														<button data-target="tlabel1c">tLevel1c</button>
														<button data-target="tlabel1d">tLevel1d</button>
													</div>
												</div>
												<div class="right-content">
													<div class="tab-content" id="tlabel1a">
														<ul>
															<li><a href="#">Menu1ta</a></li>
															<li><a href="#">Menu2ta</a></li>
															<li><a href="#">Menu3ta</a></li>
															<li><a href="#">Menu4ta</a></li>
														</ul>
													</div>
													<div class="tab-content" id="tlabel1b">
														<ul>
															<li><a href="#">Menu1tb</a></li>
															<li><a href="#">Menu2tb</a></li>
															<li><a href="#">Menu3tb</a></li>
															<li><a href="#">Menu4tb</a></li>
														</ul>
													</div>
													<div class="tab-content" id="tlabel1c">
														<ul>
															<li><a href="#">Menu1tc</a></li>
															<li><a href="#">Menu2tc</a></li>
															<li><a href="#">Menu3tc</a></li>
															<li><a href="#">Menu4tc</a></li>
														</ul>
													</div>
													<div class="tab-content" id="tlabel1d">
														<ul>
															<li><a href="#">Menu1td</a></li>
															<li><a href="#">Menu2td</a></li>
															<li><a href="#">Menu3td</a></li>
															<li><a href="#">Menu4td</a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</li>
									<li><a href="#">Heli Tours in Nepal</a></li>
									<li><a href="#">Day Tours</a></li>
									<li><a href="#">Royal Holiday Difference</a></li>
								</ul>
							</div>
						</div>
					</nav> -->
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