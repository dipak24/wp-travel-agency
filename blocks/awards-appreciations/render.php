<?php
/**
 * Awards & Appreciations – Render
 */

// Preview image (editor)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="">';
    return;
}

// Enable check
if (!get_field('awards_enable_section')) {
    return;
}

// ID
$section_id = !empty($block['anchor'])
    ? esc_attr($block['anchor'])
    : 'awards-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// Fields
$description = get_field('rha_awards_short_descritpon');
$button      = get_field('awards_button_link');
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section awards-with-description <?php echo esc_attr($section_padding); ?>">
    <div class="container">
        <div class="row">

            <!-- Awards List -->
            <?php if (have_rows('rha_awards_list', 'options')): ?>
            <div class="col col-award-lists">
                <div class="col-wrap">
                    <ul class="award-list">
                        <?php while (have_rows('rha_awards_list', 'options')) : the_row();
                            $image_id = get_sub_field('award_certification_image');
                            $link     = get_sub_field('certification_url');
                        ?>
                            <li>
                                <a href="<?php echo !empty($link) ? esc_url($link) : '#'; ?>" target="_blank" rel="nofollow noopener">

                                <?php
                                if ($image_id) {
                                    echo wp_get_attachment_image(
                                        $image_id,
                                        'img_sm',
                                        false,
                                        [
                                            'loading' => 'lazy',
                                            'decoding'=> 'async',
                                            'alt'     => esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', true)),
                                        ]
                                    );
                                }
                                ?>

                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- Description -->
            <div class="col col-description">
                <div class="col-wrap">
                    <?php if ($description): ?>
                        <h3 class="h5"><?php echo esc_html($description); ?></h3>
                    <?php endif; ?>

                    <?php if (!empty($button['url'])): ?>
                        <a href="<?php echo esc_url($button['url']); ?>"
                           class="btn"
                           target="<?php echo esc_attr($button['target'] ?? '_self'); ?>">
                            <?php echo esc_html($button['title'] ?? 'More'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>
