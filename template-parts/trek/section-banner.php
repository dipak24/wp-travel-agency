<?php
$gallery = get_field('rha_trek_gallery');

if (!empty($gallery) && is_array($gallery)) :
	// Get trek/package title for better context
	$trek_title = get_the_title();
	$gallery_count = count($gallery);
?>
<section class="banner-gallery-block" itemscope itemtype="https://schema.org/ImageGallery" aria-label="<?php echo esc_attr($trek_title); ?> photo gallery">

	<!-- Desktop Gallery -->
	<div class="banner-gallery-wrap">
		<?php
		$desktop_index = 0;
		foreach (array_slice($gallery, 0, 5) as $image) :
			$desktop_index++;

			// Safety checks
			if (empty($image['url']) || empty($image['ID'])) {
				continue;
			}

			// Get attachment metadata
			$image_id = $image['ID'];
			$image_meta = wp_get_attachment_metadata($image_id);
			
			// SEO-optimized alt text with context
			$alt = !empty($image['alt']) 
				? $image['alt'] 
				: (!empty($image['title']) 
					? $image['title'] . ' - ' . $trek_title 
					: $trek_title . ' - Image ' . $desktop_index);

			// Caption with SEO context
			$caption = !empty($image['caption'])
				? $image['caption']
				: (!empty($image['title']) 
					? $image['title'] 
					: $trek_title . ' - Photo ' . $desktop_index);

			// Get optimized image sizes
			$img_xl = wp_get_attachment_image_src($image_id, 'img_xl');
			$img_lg = wp_get_attachment_image_src($image_id, 'img_lg');
			$img_md = wp_get_attachment_image_src($image_id, 'img_md');
			$img_sm = wp_get_attachment_image_src($image_id, 'img_sm');
			
			// Fallback to URL if sizes don't exist
			$img_xl_url = $img_xl ? $img_xl[0] : $image['url'];
			$img_lg_url = $img_lg ? $img_lg[0] : $image['url'];
			$img_md_url = $img_md ? $img_md[0] : $image['url'];
			$img_sm_url = $img_sm ? $img_sm[0] : $image['url'];
			
			// Get dimensions for layout shift prevention
			$width = $img_md ? $img_md[1] : ($image_meta['width'] ?? 800);
			$height = $img_md ? $img_md[2] : ($image_meta['height'] ?? 500);
			
			// Eager load first image, lazy load rest
			$loading = ($desktop_index === 1) ? 'eager' : 'lazy';
			$fetchpriority = ($desktop_index === 1) ? 'high' : 'auto';
		?>
			<div class="img-wrap"
				data-src="<?php echo esc_url($img_lg_url); ?>"
				data-thumb="<?php echo esc_url($img_sm_url); ?>"
				data-fancybox="gallery-desktop"
				data-caption="<?php echo esc_attr($caption); ?>"
				itemprop="associatedMedia" 
				itemscope 
				itemtype="https://schema.org/ImageObject">

				<img
					src="<?php echo esc_url($img_md_url); ?>"
					srcset="
						<?php echo esc_url($img_sm_url); ?> 400w,
						<?php echo esc_url($img_md_url); ?> 800w,
						<?php echo esc_url($img_lg_url); ?> 1200w,
						<?php echo esc_url($img_xl_url); ?> 1920w
					"
					sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
					alt="<?php echo esc_attr($alt); ?>"
					title="<?php echo esc_attr($caption); ?>"
					width="<?php echo esc_attr($width); ?>"
					height="<?php echo esc_attr($height); ?>"
					loading="<?php echo esc_attr($loading); ?>"
					fetchpriority="<?php echo esc_attr($fetchpriority); ?>"
					decoding="async"
					itemprop="contentUrl"
				>
				
				<!-- Hidden metadata for structured data -->
				<meta itemprop="name" content="<?php echo esc_attr($caption); ?>">
				<meta itemprop="description" content="<?php echo esc_attr($alt); ?>">
			</div>
		<?php endforeach; ?>
	</div>

	<!-- Mobile Slider -->
	<div class="slider-wrap hide-desktop">
		<div class="swiper banner-gallery-slider-mobile" role="region" aria-label="<?php echo esc_attr($trek_title); ?> mobile gallery">
			<div class="swiper-wrapper">

				<?php
				$mobile_index = 0;
				foreach ($gallery as $image) :
					$mobile_index++;

					if (empty($image['url']) || empty($image['ID'])) {
						continue;
					}

					$image_id = $image['ID'];
					$image_meta = wp_get_attachment_metadata($image_id);

					// SEO-optimized alt text
					$alt = !empty($image['alt'])
						? $image['alt']
						: (!empty($image['title']) 
							? $image['title'] . ' - ' . $trek_title 
							: $trek_title . ' - Image ' . $mobile_index);

					$caption = !empty($image['caption'])
						? $image['caption']
						: (!empty($image['title']) 
							? $image['title'] 
							: $trek_title . ' - Photo ' . $mobile_index);

					// Get optimized image sizes
					$img_lg = wp_get_attachment_image_src($image_id, 'img_lg');
					$img_md = wp_get_attachment_image_src($image_id, 'img_md');
					$img_sm = wp_get_attachment_image_src($image_id, 'img_sm');
					
					$img_lg_url = $img_lg ? $img_lg[0] : $image['url'];
					$img_md_url = $img_md ? $img_md[0] : $image['url'];
					$img_sm_url = $img_sm ? $img_sm[0] : $image['url'];
					
					// Get dimensions
					$width = $img_md ? $img_md[1] : ($image_meta['width'] ?? 800);
					$height = $img_md ? $img_md[2] : ($image_meta['height'] ?? 500);
					
					// First 3 slides eager load for mobile
					$loading = ($mobile_index <= 3) ? 'eager' : 'lazy';
					$fetchpriority = ($mobile_index === 1) ? 'high' : 'auto';
				?>
					<div class="swiper-slide">
						<div class="img-wrap"
							data-src="<?php echo esc_url($img_lg_url); ?>"
							data-thumb="<?php echo esc_url($img_sm_url); ?>"
							data-fancybox="gallery-mobile"
							data-caption="<?php echo esc_attr($caption); ?>"
							itemprop="associatedMedia" 
							itemscope 
							itemtype="https://schema.org/ImageObject">

							<img
								src="<?php echo esc_url($img_md_url); ?>"
								srcset="
									<?php echo esc_url($img_sm_url); ?> 400w,
									<?php echo esc_url($img_md_url); ?> 800w,
									<?php echo esc_url($img_lg_url); ?> 1200w
								"
								sizes="100vw"
								alt="<?php echo esc_attr($alt); ?>"
								title="<?php echo esc_attr($caption); ?>"
								width="<?php echo esc_attr($width); ?>"
								height="<?php echo esc_attr($height); ?>"
								loading="<?php echo esc_attr($loading); ?>"
								fetchpriority="<?php echo esc_attr($fetchpriority); ?>"
								decoding="async"
								itemprop="contentUrl"
							>
							
							<!-- Hidden metadata for structured data -->
							<meta itemprop="name" content="<?php echo esc_attr($caption); ?>">
							<meta itemprop="description" content="<?php echo esc_attr($alt); ?>">
						</div>
					</div>
				<?php endforeach; ?>

			</div>
			
			<!-- Swiper Navigation -->
			<div class="swiper-button-next" aria-label="Next slide"></div>
			<div class="swiper-button-prev" aria-label="Previous slide"></div>
			
			<!-- Swiper Pagination -->
			<div class="swiper-pagination" role="tablist" aria-label="Gallery pagination"></div>
		</div>
	</div>

	<!-- Gallery Count Info (SEO Context) -->
	<div class="gallery-info" style="display: none;">
		<span itemprop="numberOfItems"><?php echo esc_html($gallery_count); ?></span>
		<span itemprop="about"><?php echo esc_html($trek_title); ?> Photo Gallery</span>
	</div>

</section>

<?php 
	// Add structured data script for better SEO
	if ($gallery_count > 0) :
		$image_list = array();
		foreach (array_slice($gallery, 0, 10) as $index => $image) {
			if (!empty($image['url']) && !empty($image['ID'])) {
				$image_id = $image['ID'];
				$img_lg = wp_get_attachment_image_src($image_id, 'img_lg');
				$alt = !empty($image['alt']) ? $image['alt'] : $trek_title . ' - Image ' . ($index + 1);
				$caption = !empty($image['caption']) ? $image['caption'] : $alt;
				
				$image_list[] = array(
					'@type' => 'ImageObject',
					'contentUrl' => $img_lg ? $img_lg[0] : $image['url'],
					'name' => $caption,
					'description' => $alt,
					'thumbnailUrl' => $image['sizes']['img_sm'] ?? $image['url']
				);
			}
		}
		
		if (!empty($image_list)) :
			$schema = array(
				'@context' => 'https://schema.org',
				'@type' => 'ImageGallery',
				'name' => $trek_title . ' Photo Gallery',
				'description' => 'Photo gallery showcasing ' . $trek_title,
				'numberOfItems' => $gallery_count,
				'image' => $image_list
			);
?>
<script type="application/ld+json">
<?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
<?php 
		endif;
	endif;
endif; 
?>