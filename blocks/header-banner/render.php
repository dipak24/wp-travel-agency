<?php
/**
 * Block Name: Header Banner
 * Description: Display a header banner with background image and text.
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enabled_header_banner')) {
    return;
}

// Unique ID & spacing
$section_id      = 'header-banner-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title        = get_field('section_title');
$section_tagline      = get_field('sec_title_tagline');
$section_description  = get_field('section_description');
$background_image     = get_field('section_background_image');
$background_color     = get_field('body_background_color');
$heading_type         = get_field('title_heading_type') ?: 'h1'; // Default to h1
$title_color          = get_field('main_title_color');
$description_color    = get_field('description_text_color');
$link                 = get_field('section_button'); // ACF link field returns array

// Fallback to page title if section title is empty
if (empty($section_title)) {
    $section_title = get_the_title();
}

// Default background color if none set
$default_bg_color = '#1E3D51';

// Build inline styles
$inline_styles = [];

// Priority: Background image > Custom color > Default color
if ($background_image) {
    $bg_url = is_array($background_image) ? esc_url($background_image['url']) : esc_url($background_image);
    $inline_styles[] = "background-image: url('{$bg_url}')";
} elseif ($background_color) {
    $inline_styles[] = 'background-color: ' . esc_attr($background_color);
} else {
    $inline_styles[] = 'background-color: ' . esc_attr($default_bg_color);
}

$style_attr = !empty($inline_styles) ? ' style="' . implode('; ', $inline_styles) . '"' : '';

// Build CSS classes
$section_classes = ['section'];

// Add overlay class if background image exists
if ($background_image) {
    $section_classes[] = 'has-overlay';
    $section_classes[] = 'inner-banner';
} else {
    $section_classes[] = 'content-block';
    $section_classes[] = 'text-light';
    $section_classes[] = 'p-small';
}

// Add text color classes
$section_classes[] = 'text-light';

// Add alignment classes
$section_classes[] = 'align-center';
$section_classes[] = 'text-center';

// Add padding class based on content
if (!$section_description && !$link) {
    $section_classes[] = 'p-small';
}

// Add custom spacing if available
if ($section_padding) {
    $section_classes[] = $section_padding;
}

$class_attr = implode(' ', array_filter($section_classes));

// Sanitize heading type
$allowed_headings = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
$heading_tag = in_array($heading_type, $allowed_headings) ? $heading_type : 'h1';

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
?>

<section id="<?php echo $section_id; ?>" class="<?php echo esc_attr($class_attr); ?>"<?php echo $style_attr; ?>>
    <div class="container">
        <div class="banner-text">
            <?php if ($section_tagline) : ?>
                <span class="tagline"><?php echo wp_kses($section_tagline, getAllowedHtmlTags()); ?></span>
            <?php endif; ?>

            <?php if ($section_title) : ?>
                <<?php echo $heading_tag; ?><?php echo $title_style_attr; ?>>
                    <?php echo wp_kses($section_title, getAllowedHtmlTags()); ?>
                </<?php echo $heading_tag; ?>>
            <?php endif; ?>

            <?php if ($section_description) : ?>
                <p<?php echo $description_style_attr; ?>>
                    <?php echo wp_kses($section_description, getAllowedHtmlTags()); ?>
                </p>
            <?php endif; ?>

            <?php if ($link && !empty($link['url'])) : ?>
                <a href="<?php echo esc_url($link['url']); ?>" 
                   class="btn"
                   <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                    <?php echo esc_html($link['title'] ?: 'Learn More'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
