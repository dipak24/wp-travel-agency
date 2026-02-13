<?php
/**
 * Block Name: Our team alternate design
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_our_team_alternate_section')) {
    return;
}

// Unique ID & spacing
$section_id      = 'our-team-alternate-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title       = get_field('rha_our_team_alternate_title');
$section_description = get_field('rha_our_team_alternate_description');
$travel_styles       = get_field('rha_our_team_alternate_lists'); // ACF Relationship field (post Ids)

if (empty($travel_styles) || !is_array($travel_styles)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section team-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <!-- Section Heading -->
        <?php if ($section_title || $section_description): ?>
            <header class="heading-block">
                <span class="tagline">The Team</span>

                <?php if ($section_title): ?>
                    <h2><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>

                <?php if ($section_description): ?>
                    <p><?php echo esc_html($section_description); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="row">
            <div class="col card-team-alt">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <img src="assets/images/author.png" alt="image description">
                    </div>

                    <div class="text-wrap">
                        <span class="tagline">Lorem, ipsum.</span>
                        <h3 class="h6"><a href="#">title</a></h3>
                        <p>Lorem ipsum dolor, sit amet.</p>
                    </div>
                </div>
            </div>
            <div class="col card-team-alt">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <img src="assets/images/author.png" alt="image description">
                    </div>

                    <div class="text-wrap">
                        <span class="tagline">Lorem, ipsum.</span>
                        <h3 class="h6">title</h3>
                        <p>Lorem ipsum dolor, sit amet.</p>
                    </div>
                </div>
            </div>
            <div class="col card-team-alt">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <img src="assets/images/author.png" alt="image description">
                    </div>

                    <div class="text-wrap">
                        <span class="tagline">Lorem, ipsum.</span>
                        <h3 class="h6">title</h3>
                        <p>Lorem ipsum dolor, sit amet.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
