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

        <div class="row">
            <div class="col card-team">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <a href="#">
                            <img src="assets/images/author.png" alt="team1">
                        </a>
                    </div>
                    <div class="text-wrap">
                        <h3 class="h6">
                            <a href="#">
                        Phonex Baker</a></h3>
                        <p>Founder</p>
                    </div>
                </div>
            </div>
            <div class="col card-team">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <img src="assets/images/author2.png" alt="team2">
                    </div>
                    <div class="text-wrap">
                        <h3 class="h6">Lana Steiner</h3>
                        <p>Product Manager</p>
                    </div>
                </div>
            </div>
            <div class="col card-team">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <img src="assets/images/img-trip1.png" alt="team3">
                    </div>
                    <div class="text-wrap">
                        <h3 class="h6">Demi Wilkinson</h3>
                        <p>Engineering Manager</p>
                    </div>
                </div>
            </div>
            <div class="col card-team">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <img src="assets/images/img-trip1.png" alt="team3">
                    </div>
                    <div class="text-wrap">
                        <h3 class="h6">Demi Wilkinson</h3>
                        <p>Engineering Manager</p>
                    </div>
                </div>
            </div>
            <div class="col card-team">
                <div class="card-wrap">
                    <div class="img-wrap">
                        <img src="assets/images/img-trip1.png" alt="team3">
                    </div>
                    <div class="text-wrap">
                        <h3 class="h6">Demi Wilkinson</h3>
                        <p>Engineering Manager</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
