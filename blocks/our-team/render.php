<?php
/**
 * Block Name: Our team
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_our_team_section')) {
    return;
}

// Unique ID & spacing
$section_id      = 'our-team-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title       = get_field('rha_our_team_title');
$section_description = get_field('rha_our_team_description');
$our_teams       = get_field('rha_our_team_lists'); // ACF Relationship field (post Ids)

if (empty($our_teams) || !is_array($our_teams)) {
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
        
        <?php if ($our_teams): ?>
        <div class="row">
            <?php 
            foreach ($our_teams as $team_id):
                $team_name = get_the_title($team_id);
                $team_role = get_field('rha_team_designation', $team_id);
                $phoneNumber = get_field('contact_number', $team_id);
                $thumbnailId = get_post_thumbnail_id($team_id);
                ?>

                <div class="col card-team">
                    <div class="card-wrap">
                        <?php if ($thumbnailId){ ?>
                        <div class="img-wrap">
                            <a href="<?php echo esc_url(get_permalink($team_id)); ?>">
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
                            </a>
                        </div>
                        <?php } ?>
                        <div class="text-wrap">
                            <h3 class="h6">
                                <a href="<?php echo esc_url(get_permalink($team_id)); ?>"><?php echo esc_html($team_name); ?></a>
                            </h3>
                            <p><?php echo esc_html($team_role); ?></p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
            
        </div>
        <?php endif; ?>
    </div>
</section>
