<?php
/**
 * Assocation With Block Template.
 */

// Preview image (editor)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="">';
    return;
}

// Enable check
if (!get_field('association_enable_section')) {
    return;
}

// ID
$section_id = !empty($block['anchor'])
    ? esc_attr($block['anchor'])
    : 'association-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// Fields
$title = get_field('rha_association_section_title');
$sub_title = get_field('rha_association_section_subtitle');
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section associate-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">
        <div class="row">

           <div class="container">
                <?php if ($title || $sub_title): ?>
                <div class="heading-block text-center">
                    <?php if ($sub_title): ?>
                        <p class="sub-title h5"><?php echo esc_html($sub_title); ?></p>
                    <?php endif; ?>
                    <h2><?php echo esc_html($title); ?></h2>    
                </div>
                <?php endif; ?>

                <?php if (have_rows('rha_orgination_lists', 'option')) : ?>
                <div class="row">
                    <?php while (have_rows('rha_orgination_lists', 'option')): the_row();
                        $image_id   = get_sub_field('orgination_logo');
                        $a_title    = get_sub_field('orgination_name');
                        $url        = get_sub_field('orgination_url');
                    ?>

                        <div class="col card-associate">
                            <div class="card-wrap">
                                <div class="icon-wrap">
                                    <?php
                                    if ($image_id) {
                                        echo wp_get_attachment_image(
                                            $image_id,
                                            'img_xs',
                                            false,
                                            [
                                                'loading' => 'lazy',
                                                'decoding'=> 'async',
                                                'alt'     => esc_attr(
                                                    get_post_meta($image_id, '_wp_attachment_image_alt', true)
                                                    ?: $a_title
                                                ),
                                            ]
                                        );
                                    }
                                    ?>
                                </div>

                                <?php if ($a_title): ?>
                                    <div class="text-wrap">
                                        <h3 class="h6"><?php echo esc_html($a_title); ?></h3>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
