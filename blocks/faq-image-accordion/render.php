<?php
/**
 * FAQ With Image Accordion – Render
 */

// --------------------------------------------------
// Preview image (Block Inserter)
// --------------------------------------------------
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="">';
    return;
}

// --------------------------------------------------
// Enable toggle
// --------------------------------------------------
if (!get_field('faq_with_image_accordion_enable')) {
    return;
}

// --------------------------------------------------
// Required repeater check
// --------------------------------------------------
if (!have_rows('rha_faq_items')) {
    return;
}

// --------------------------------------------------
// Section ID & styles
// --------------------------------------------------
$section_id = !empty($block['anchor'])
    ? esc_attr($block['anchor'])
    : 'faq-with-image-accordion-' . esc_attr($block['id']);

$section_padding = function_exists('rha_get_block_style')
    ? rha_get_block_style()
    : '';

// --------------------------------------------------
// Section content
// --------------------------------------------------
$section_heading     = get_field('rha_section_heading');
$section_description = get_field('rha_section_description');

// --------------------------------------------------
// URL hash for auto-open
// --------------------------------------------------
$request_uri = isset($_SERVER['REQUEST_URI'])
    ? sanitize_text_field($_SERVER['REQUEST_URI'])
    : '';

// --------------------------------------------------
// Build FAQ Schema (JSON-LD)
// --------------------------------------------------
$faq_schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'FAQPage',
    'mainEntity' => [],
];

while (have_rows('rha_faq_items')) : the_row();

    $question = trim(wp_strip_all_tags(get_sub_field('rha_question')));
    $answer   = trim(wp_strip_all_tags(get_sub_field('rha_answer')));
    $image_id  = get_sub_field('rha_faq_image');

    if (!$question || !$answer) {
        continue;
    }

    $faq_schema['mainEntity'][] = [
        '@type' => 'Question',
        'name'  => $question,
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => $answer,
        ],
    ];

    // Add image URL if available
    if ($image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');

        if ($image_url) {
            $faq_item['image'] = [
                '@type' => 'ImageObject',
                'url'   => esc_url($image_url),
            ];
        }
    }

    $faq_schema['mainEntity'][] = $faq_item;

endwhile;

// Reset repeater pointer
reset_rows();

// --------------------------------------------------
// Output FAQ Schema
// --------------------------------------------------
if (!empty($faq_schema['mainEntity'])) :
?>
<script type="application/ld+json">
<?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
</script>
<?php endif; ?>

<section id="<?php echo esc_attr($section_id); ?>"
    class="section half-image-half-accordion-block <?php echo esc_attr($section_padding); ?>">

    <div class="container">

        <?php if ($section_heading || $section_description): ?>
            <header class="heading-block width-50">
                <?php if ($section_heading): ?>
                    <h2><?php echo esc_html($section_heading); ?></h2>
                <?php endif; ?>

                <?php if ($section_description): ?>
                    <p><?php echo esc_html($section_description); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="row">

            <!-- Desktop Images -->
            <div class="col col-image show-desktop">
                <div class="images">
                    <?php
                    $i = 1;
                    while (have_rows('rha_faq_items')) : the_row();
                        $image_id = get_sub_field('rha_faq_image');
                        if (!$image_id) {
                            $i++;
                            continue;
                        }

                        $is_active = (
                            ($i === 1 && strpos($request_uri, '#faq-') === false) ||
                            strpos($request_uri, '#faq-' . $i) !== false
                        );
                    ?>
                        <div class="img-wrap <?php echo $is_active ? 'active' : ''; ?>"
                             data-index="faq-img-<?php echo esc_attr($i); ?>">
                            <?php
                            echo wp_get_attachment_image(
                                $image_id,
                                'img_md',
                                false,
                                [
                                    'loading'  => 'lazy',
                                    'decoding' => 'async',
                                    'alt'      => esc_attr(
                                        get_post_meta($image_id, '_wp_attachment_image_alt', true)
                                        ?: get_sub_field('rha_question')
                                    ),
                                ]
                            );
                            ?>
                        </div>
                    <?php
                        $i++;
                    endwhile;
                    reset_rows();
                    ?>
                </div>
            </div>

            <!-- Accordion -->
            <div class="col col-accordion">
                <div class="accordion" role="tablist">

                    <?php
                    $i = 1;
                    while (have_rows('rha_faq_items')) : the_row();

                        $question = get_sub_field('rha_question');
                        $answer   = get_sub_field('rha_answer');
                        $image_id = get_sub_field('rha_faq_image');
                        $link     = get_sub_field('rha_faq_link');

                        $is_active = (
                            ($i === 1 && strpos($request_uri, '#faq-') === false) ||
                            strpos($request_uri, '#faq-' . $i) !== false
                        );
                    ?>
                        <div class="accordion-list <?php echo $is_active ? 'active' : ''; ?>">

                            <h3
                                id="faq-<?php echo esc_attr($i); ?>"
                                class="title"
                                data-index="faq-img-<?php echo esc_attr($i); ?>"
                                role="button"
                                aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>">
                                <?php echo esc_html($question); ?>
                            </h3>

                            <div class="slide">
                                <div class="slide-wrap">

                                    <?php if ($image_id): ?>
                                        <div class="img-wrap hide-desktop">
                                            <?php
                                            echo wp_get_attachment_image(
                                                $image_id,
                                                'img_md',
                                                false,
                                                [
                                                    'loading'  => 'lazy',
                                                    'decoding' => 'async',
                                                    'alt'      => esc_attr(
                                                        get_post_meta($image_id, '_wp_attachment_image_alt', true)
                                                        ?: $question
                                                    ),
                                                ]
                                            );
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($answer): ?>
                                        <div class="content">
                                            <?php echo wp_kses_post($answer); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($link['url']) && !empty($link['title'])): ?>
                                        <a class="btn outline"
                                           href="<?php echo esc_url($link['url']); ?>"
                                           target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                                            <?php echo esc_html($link['title']); ?>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>

                        </div>
                    <?php
                        $i++;
                    endwhile;
                    ?>
                </div>
            </div>

        </div>
    </div>
</section>
