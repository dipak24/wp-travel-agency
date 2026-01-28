<?php 
if( have_rows('rha_trip_fact_details') ): ?>
    <div class="overview-lists">
        <?php while( have_rows('rha_trip_fact_details') ) : the_row(); ?>
            <div class="overview-list">
                <?php 
                $icon = get_sub_field('rha_trip_fact_icon');
                $description = get_sub_field('rha_trip_fact_detail_description');
                if( $icon ): ?>
                    <div class="icon-wrap" style="position: relative;">
                        <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">

                        <?php if( $description ): ?>
                            <span class="info-tooltip">i
                                <span class="tooltip-text"><?php echo esc_html($description); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="text-wrap">
                    <span class="tagline"><?php the_sub_field('rha_trip_fact_detail_value'); ?></span>
                    <span class="title"><?php the_sub_field('rha_trip_fact_detail_title'); ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

