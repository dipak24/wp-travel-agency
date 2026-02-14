<?php
/**
 * Block Name: Message Block
 * Description: Display a message block with background color and text.
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enabled_trip_cta')) {
    return;
}

// Unique ID & spacing
$section_id      = 'message-block-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title        = get_field('section_title');
$section_tagline      = get_field('sec_title_tagline');
$section_description  = get_field('section_description');
$background_color     = get_field('body_background_color');
$heading_type         = get_field('title_heading_type') ?: 'h2'; // Default to h2
$title_color          = get_field('main_title_color');
$description_color    = get_field('description_text_color');
$link                 = get_field('section_button'); // ACF link field returns array

// New fields for layout control
$layout_style         = get_field('layout_style') ?: 'two-column'; // two-column, centered
$text_alignment       = get_field('text_alignment') ?: 'left'; // left, center, right
$button_size          = get_field('button_size') ?: 'default'; // default, small
$text_theme           = get_field('text_theme') ?: 'dark'; // dark, light

// Build inline styles for section
$section_styles = [];
if ($background_color) {
    $section_styles[] = 'background-color: ' . esc_attr($background_color);
}
$section_style_attr = !empty($section_styles) ? ' style="' . implode('; ', $section_styles) . '"' : '';

// Build CSS classes for section
$section_classes = ['section', 'cta-block'];

// Add layout class
if ($layout_style === 'two-column') {
    $section_classes[] = 'cta-two';
}

// Add text theme class
if ($text_theme === 'light') {
    $section_classes[] = 'text-light';
}

// Add text alignment class
$alignment_class_map = [
    'center' => 'text-center',
    'right'  => 'text-right',
    'left'   => 'text-left',
];

if (isset($alignment_class_map[$text_alignment])) {
    $section_classes[] = $alignment_class_map[$text_alignment];
}

// Add custom spacing if available
if ($section_padding) {
    $section_classes[] = $section_padding;
}

$section_class_attr = implode(' ', array_filter($section_classes));

// Sanitize heading type
$allowed_headings = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
$heading_tag = in_array($heading_type, $allowed_headings) ? $heading_type : 'h2';

// Build title inline styles
$title_styles = [];
if ($title_color) {
    $title_styles[] = 'color: ' . esc_attr($title_color);
}
$title_style_attr = !empty($title_styles) ? ' style="' . implode('; ', $title_styles) . '"' : '';

// Build description inline styles
$description_styles = [];
if ($description_color) {
    $description_styles[] = 'color: ' . esc_attr($description_color);
}
$description_style_attr = !empty($description_styles) ? ' style="' . implode('; ', $description_styles) . '"' : '';

// Button size class
$button_class = 'btn';
if ($button_size === 'small') {
    $button_class .= ' small';
}

?>

<section id="<?php echo $section_id; ?>" class="<?php echo esc_attr($section_class_attr); ?>"<?php echo $section_style_attr; ?>>
    <div class="container">
        <div class="row">
            <div class="col col-title">
                <div class="title-wrap">
                    <?php if ($section_tagline) : ?>
                        <span class="tagline"><?php echo wp_kses($section_tagline, getAllowedHtmlTags()); ?></span>
                    <?php endif; ?>

                    <?php if ($section_title) : ?>
                        <<?php echo $heading_tag; ?><?php echo $title_style_attr; ?>>
                            <?php echo wp_kses($section_title, getAllowedHtmlTags()); ?>
                        </<?php echo $heading_tag; ?>>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col col-content">
                <div class="col-wrap">
                    <?php if ($section_description) : ?>
                        <p<?php echo $description_style_attr; ?>>
                            <?php echo wp_kses($section_description, getAllowedHtmlTags()); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($link && !empty($link['url'])) : ?>
                        <a href="<?php echo esc_url($link['url']); ?>" 
                           class="<?php echo esc_attr($button_class); ?>"
                           <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                            <?php echo esc_html($link['title'] ?: 'Learn More'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
