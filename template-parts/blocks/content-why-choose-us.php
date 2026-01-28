<?php
/**
 * Block Name: Why Choose Us Block
 */

// Block preview image (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Section enable check
if (!get_field('is_enabled_why_choose_us_block')) {
    return;
}

// Unique ID
$section_id      = 'why-choose-us-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$main_title       = get_field('rha_why_choose_us_title');
$description_main = get_field('rha_why_choose_us_description');
$button       = get_field('rha_why_choose_us_button');
$btnUrl       = !empty($button['url']) ? $button['url'] : '#';
$btnTitle     = !empty($button['title']) ? $button['title'] : 'Learn More';
$btnTarget    = !empty($button['target']) ? $button['target'] : '_self';
$bgImage      = get_field('rha_why_choose_us_bg_image'); // Get image attachment Id
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section why-with-us-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">
        <div class="row">
            <div class="col col-content">
                <div class="col-wrap">
                    <?php if (!empty($main_title)) : ?>
                        <h2><?php echo esc_html($main_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($description_main)) : ?>
                        <p><?php echo esc_html($description_main); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($button)) : ?>
                        <a href="<?php echo esc_url($btnUrl); ?>" target="<?php echo esc_attr($btnTarget); ?>" class="btn"><?php echo esc_html($btnTitle); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (have_rows('rha_why_choose_us_lists')) : ?>
            <div class="col col-lists">
                <div class="col-wrap">
                    <ul class="lists">
                        <?php 
                        while (have_rows('rha_why_choose_us_lists')) : the_row();
                            $list_title = get_sub_field('why_title');
                            $list_description = get_sub_field('why_description');
                            $dashIcon = get_sub_field('why_us_icon');
                            ?>
                            <li>
                                <?php if (!empty($dashIcon)) : ?>
                                    <div class="icon-wrap">
                                        <span class="dashicons <?php echo esc_attr($dashIcon); ?>"></span>
                                    </div>
                                <?php endif; ?>
                                <div class="text-wrap">
                                    <?php if (!empty($list_title)) : ?>
                                        <strong class="title"><?php echo esc_html($list_title); ?></strong>
                                    <?php endif; ?>

                                    <?php if (!empty($list_description)) : ?>
                                        <p><?php echo esc_html($list_description); ?></p>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($bgImage)) : ?>
    <div class="img-wrap">
       <?php
        echo wp_get_attachment_image(
            $bgImage,
            'img_xl',
            false,
            [
                'loading' => 'lazy',
            ]
        );
        ?>
    </div>
    <?php endif; ?>
</section>