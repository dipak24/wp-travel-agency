<?php
/**
 * Travel Expert Block
 */

// Editor preview
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="">';
    return;
}

// Enable toggle
if (!get_field('trevel_expert_enable_section')) {
    return;
}

// Section ID
$section_id = !empty($block['anchor'])
    ? esc_attr($block['anchor'])
    : 'travel-expert-' . esc_attr($block['id']);

$section_padding = rha_get_block_style();

// Titles
$title         = get_field('rha_travel_expert_section_title');
$default_title = get_field('rha_speak_to_expert_section_title', 'option');

// Relationship field
$experts = get_field('opt_select_expert_lists', 'option');

if (empty($experts) || !is_array($experts)) {
    return;
}

$count = count($experts);

// PRIMARY INDEX LOGIC (exact as requested)
if ($count === 3) {
    $primary_index = 1;
} elseif ($count >= 4) {
    $primary_index = 2;
} else {
    $primary_index = 0;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section trip-export-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">
        <div class="trip-expert-box">

            <?php if ($title || $default_title) : ?>
                <h4><?php echo esc_html($title ?: $default_title); ?></h4>
            <?php endif; ?>

            <!-- Centered avatars -->
            <div class="expert-avatars">

                <?php 
                foreach ($experts as $index => $expert_id) :

                    $name  = get_the_title($expert_id);
                    $size  = ($index === $primary_index) ? 80 : 55;
                    $class = 'expert-avatar' . (($index === $primary_index) ? ' is-primary' : '');

                    echo wp_get_attachment_image(
                        get_post_thumbnail_id($expert_id),
                        'thumbnail',
                        false,
                        [
                            'width'    => $size,
                            'height'   => $size,
                            'class'    => $class,
                            'loading'  => 'lazy',
                            'decoding' => 'async',
                            'alt'      => esc_attr($name),
                            'title'    => esc_attr($name),
                        ]
                    );
                    ?>

                <?php endforeach; ?>

            </div>

            <?php
            // Primary expert details
            $main_id = $experts[$primary_index];
            ?>

            <strong class="name h5"><?php echo esc_html(get_the_title($main_id)); ?></strong>

            <p><?php echo esc_html(get_field('nationality', $main_id) ?: 'Nepal'); ?></p>

            <?php if ($phone = get_field('contact_number', $main_id)) : ?>
                <span class="contact">
                    WhatsApp:
                    <strong>
                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>">
                            <?php echo esc_html($phone); ?>
                        </a>
                    </strong>
                </span>
            <?php endif; ?>

        </div>
    </div>
</section>
