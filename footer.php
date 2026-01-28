<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Royal_Holidays_Adventures
 */
?>
	<footer id="footer">
		<div class="container">
			<div class="footer-top">
				<div class="row">
					<div class="col col-logo footer-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR.'/logo-white.png'); ?>" alt="Royal Holidays Adventures Pvt.Ltd" >
						</a>
						<p>We are <strong>Royal Holidays Adventures Pvt.Ltd.</strong> We create meaningful travel experiences and handle every detail so you can travel worry-free.</p>
					</div>

					<div class="col col-help">
						<?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
					</div>
				</div>
			</div>

			<div class="footer-menu">
				<div class="row">
					<div class="col col-contact">
						<div class="col-wrap">
							<strong class="title">Contact Us</strong>
							<div class="address">
								<ul>
									<li class="location">
										z-Street Thamel, Kathmandu 44600, Nepal
									</li>
									<li class="tel">
										<a href="tel:+9779860110433">+977 9860110433</a>
									</li>
									<li class="mail">
										<a href="mailto:info@holidaytravelpackage.com">info@holidaytravelpackage.com</a>
									</li>
								</ul>
							</div>
							<?php if (is_active_sidebar('footer-widget-1')): ?>
							<div class="social-networks">
								<strong class="title social-title">Follow us</strong>
								<?php dynamic_sidebar('footer-widget-1'); ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php if (is_active_sidebar('footer-widget-2')): ?>
					<div class="col col-menu">
						<?php dynamic_sidebar('footer-widget-2'); ?>
					</div>
					<?php endif; ?>

					<?php if (is_active_sidebar('footer-widget-3')): ?>
					<div class="col col-menu">
						<?php dynamic_sidebar('footer-widget-3'); ?>
					</div>
					<?php endif; ?>

					<?php if (is_active_sidebar('footer-widget-4')): ?>
					<div class="col col-menu">
						<?php dynamic_sidebar('footer-widget-4'); ?>
					</div>
					<?php endif; ?>

					<?php if (is_active_sidebar('footer-widget-5')): ?>
					<div class="col col-menu">
						<?php dynamic_sidebar('footer-widget-5'); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="footer-bottom">
				<div class="row">
					<div class="col col-copyright">
						<p>Copyright © 2016 - <?php echo date('Y'); ?> <?php echo bloginfo('name'); ?></p>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div class="footer-tab">
		<ul>
			<li>
				<a href="#">Book now</a>
			</li>
			<li>
				<a href="#">Customized Trip</a>
			</li>
		</ul>
	</div>
	<button class="scroll-top-btn" title="Scroll to top">↑</button>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
