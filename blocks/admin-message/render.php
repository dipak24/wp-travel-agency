<?php
/**
 * Block Name: Admin message
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_admin_message_section')) {
    return;
}

// Unique ID & spacing
$section_id      = 'admin_message-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$admin_message       = get_field('rha_admin_message');
$author = get_field('message_by');
$degignation = get_field('designation');
$authour_image_id       = get_field('image_authour'); // Image ids

if (empty($admin_message)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section message-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">
        <div class="message-box has-border">
            <p><?php echo esc_html($admin_message); ?></p>
            <div class="author-box">

                <?php if ($authour_image_id) : ?>
                    <div class="img-wrap">
                        <?php
                        echo wp_get_attachment_image(
                            $authour_image_id,
                            'img_sm',
                            false,
                            [
                                'loading' => 'lazy',
                                'decoding'=> 'async',
                                'alt'     => esc_attr($author ? $author : 'Author image')
                            ]
                        );?>
                    </div>
                <?php endif; ?>

                <div class="text-wrap">
                    <?php if ($author) : ?>
                    <span class="author"><?php echo esc_html($author); ?></span>
                    <?php endif; ?>

                    <?php if ($degignation) : ?>
                    <span class="designation"><?php echo esc_html($degignation); ?></span>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>
