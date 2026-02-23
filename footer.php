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
							<img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR.'/logo-white.png'); ?>" alt="<?php echo bloginfo('name'); ?>" >
						</a>
						<p>We are <strong><?php echo bloginfo('name'); ?></strong> We create meaningful travel experiences and handle every detail so you can travel worry-free.</p>
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
										<a href="tel:+9860472458">+977 9860472458</a>
									</li>
									<li class="mail">
										<a href="mailto:info@trekvera.com">info@trekvera.com</a>
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
			<?php if (get_field('rha_whatsapp_number', 'option')): ?>
				<div class="whats-app-box">
					<a href="https://wa.me/<?php echo esc_attr(get_field('rha_whatsapp_number', 'option')); ?>" class="whatsapp-link" target="_blank" rel="noopener">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"></rect><g fill="none" stroke="#25D366" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"></path><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"></path></g></svg> <span>Get Instant Response:<br> +<?php echo esc_attr(get_field('rha_whatsapp_number', 'option')); ?> (WhatsApp)</span>
					</a>
				</div>
			<?php endif; ?>
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
