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
$alternate_teams       = get_field('rha_our_team_alternate_lists'); // ACF Relationship field (post Ids)

if (empty($alternate_teams) || !is_array($alternate_teams)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section team-block team-alt <?php echo esc_attr($section_padding); ?>">
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
        
        <?php if ($alternate_teams): ?>
        <div class="row">

        <?php 
        foreach ($alternate_teams as $team_id):
            $team_name = get_the_title($team_id);
            $team_role = get_field('rha_team_designation', $team_id);
            $excerpts = get_field('team_short_description', $team_id);
            $thumbnailId = get_post_thumbnail_id($team_id);
            ?>
            <div class="col card-team-alt">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <?php
                        echo wp_get_attachment_image(
                            $thumbnailId,
                            'img_sm',
                            false,
                            [
                                'loading' => 'lazy',
                                'decoding'=> 'async',
                                'alt'     => esc_attr(
                                    get_post_meta($thumbnailId, '_wp_attachment_image_alt', true)
                                    ?: $team_name
                                ),
                            ]
                        );
                        ?>
                    </div>

                    <div class="text-wrap">
                        <span class="tagline"><?php echo esc_html($team_role); ?></span>
                        <h3 class="h6"><a href="<?php echo esc_url(get_permalink($team_id)); ?>"><?php echo esc_html($team_name); ?></a></h3>
                        <p><?php echo esc_html($excerpts); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        </div>
        <?php endif; ?>
    </div>
</section>
