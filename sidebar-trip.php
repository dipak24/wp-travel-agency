<?php
// ==========================
// PRICE SECTION
// ==========================
$regular_price = (float) get_field('trip_regular_price');
$sale_price    = (float) get_field('trip_sale_price');
$save_price    = ($regular_price > 0 && $sale_price > 0) ? ($regular_price - $sale_price) : 0;

// ==========================
// GROUP DISCOUNT SECTION
// ==========================
$group_discounts = get_field('rha_group_discount');
$section_title   = get_field('rha_group_discount_section_title');
$section_desc    = get_field('rha_group_discount_section_description');

// ==========================
// BOOKING URL
// ==========================
$booking_url = get_field('rha_trip_booking_url');
$trip_id     = get_the_ID();
?>

<div class="col col-sidebar">
    <div class="col-wrap">
        <aside class="trip">

            <?php if ($sale_price > 0 || $regular_price > 0 || $save_price > 0) : ?>
                <div class="promotion-offer">

                    <?php if ($sale_price > 0) : ?>
                        <strong class="price">
                            US$ <?php echo esc_html($sale_price); ?>
                            <span>per person</span>
                            <sup>PP</sup>
                        </strong>
                    <?php endif; ?>

                    <?php if ($regular_price > 0) : ?>
                        <div class="discount-price">
                            <strong>14 Days</strong>
                            <em>from</em>
                            <del>US$ <?php echo esc_html($regular_price); ?></del>
                        </div>
                    <?php endif; ?>

                    <?php if ($save_price > 0) : ?>
                        <div class="save-price">
                            SAVE <strong>US$ <?php echo esc_html($save_price); ?></strong>
                            <span>per person</span>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <?php if (!empty($group_discounts)) : ?>
                <div class="discount-lists">

                    <div class="discount">
                        <strong class="title">
                            <?php echo esc_html($section_title ?: 'Group-Size Discounts'); ?>
                        </strong>

                        <?php if (!empty($section_desc)) : ?>
                            <?php echo wp_kses_post($section_desc); ?>
                        <?php endif; ?>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>No. of Persons</th>
                                    <th>Price per Person</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($group_discounts as $row) :
                                    $group_size  = $row['number_of_pax'] ?? '';
                                    $group_price = $row['price_per_person'] ?? '';

                                    if (!$group_size || !$group_price) continue;
                                ?>
                                    <tr>
                                        <td><?php echo esc_html($group_size); ?> Pax</td>
                                        <td>US$ <?php echo esc_html($group_price); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            <?php endif; ?>

            <div class="button-lists">

                <?php if (!empty($booking_url)) : ?>
                    <a href="<?php echo esc_url($booking_url); ?>" class="btn">Book Now</a>
                <?php else : ?>
                    <form method="GET" action="<?php echo esc_url(home_url('/trip-booking')); ?>">
                        <input type="hidden" name="trip_id" value="<?php echo esc_attr($trip_id); ?>">
                        <button type="submit" class="btn">Book Now</button>
                        <p>Dates and discounts are applied in the next step.</p>
                    </form>
                    <br>
                <?php endif; ?>

                <form action="<?php echo esc_url(home_url('/trip-inquire')); ?>" method="GET">
                    <input type="hidden" name="trip_id" value="<?php echo esc_attr($trip_id); ?>">
                    <button type="submit" class="btn outline">Enquire</button>
                </form>

            </div>
        </aside>

        <?php
        // ==========================
        // EXPERT SECTION
        // ==========================
        $default_expert_title = get_field('rha_speak_to_expert_section_title', 'option');
        $expertsLists         = get_field('opt_select_expert_lists', 'option');

        if (!empty($expertsLists) && is_array($expertsLists)) :

            $count = count($expertsLists);

            if ($count === 3) {
                $primary_index = 1;
            } elseif ($count >= 4) {
                $primary_index = 2;
            } else {
                $primary_index = 0;
            }

            $main_id = $expertsLists[$primary_index] ?? null;

            if ($main_id) :
        ?>
            <div class="trip-expert-box sidebar has-border">

                <?php if (!empty($default_expert_title)) : ?>
                    <h5><?php echo esc_html($default_expert_title); ?></h5>
                <?php endif; ?>

                <div class="images">
                    <?php foreach ($expertsLists as $index => $expert_id) :

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
                            ]
                        );

                    endforeach; ?>
                </div>

                <strong class="name h6"><?php echo esc_html(get_the_title($main_id)); ?></strong>

                <?php if ($nationality = get_field('nationality', $main_id)) : ?>
                    <p><?php echo esc_html($nationality); ?></p>
                <?php endif; ?>

                <?php if ($phone = get_field('contact_number', $main_id)) : ?>
                    <span class="contact">
                        Whatsapp:
                        <strong>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </strong>
                    </span>
                <?php endif; ?>

            </div>
        <?php
            endif;
        endif;
        ?>

    </div>
</div>
