<?php
$regular_price = (float) get_field('trip_regular_price');
$sale_price    = (float) get_field('trip_sale_price');
$save_price    = ($regular_price && $sale_price) ? ($regular_price - $sale_price) : 0;
?>

<div class="col col-sidebar">
    <div class="col-wrap">
        <aside class="trip">

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

            <?php if (have_rows('rha_group_discount')) : ?>

                <div class="discount-lists">

                    <div class="discount">
                        <strong class="title">
                            <?php
                            $section_title = get_field('rha_group_discount_section_title');
                            echo esc_html($section_title ? $section_title : 'Group-Size Discounts');
                            ?>
                        </strong>

                        <?php
                        $section_desc = get_field('rha_group_discount_section_description');
                        if ($section_desc) :
                            echo wp_kses_post($section_desc);
                        endif;
                        ?>
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
                                <?php while (have_rows('rha_group_discount')) : the_row(); ?>
                                    <?php
                                    $group_size  = get_sub_field('number_of_pax');
                                    $group_price = get_sub_field('price_per_person');
                                    ?>

                                    <?php if ($group_size && $group_price) : ?>
                                        <tr>
                                            <td><?php echo esc_html($group_size); ?> Pax</td>
                                            <td>US$ <?php echo esc_html($group_price); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            <?php endif; ?>

            <div class="button-lists">
                <?php if (get_field('rha_trip_booking_url')) : ?>
                    <a href="<?php echo esc_url(get_field('rha_trip_booking_url')); ?>" class="btn">Book Now</a>
                <?php else : ?>
                    <form method="POST" action="<?php echo esc_url(home_url('/booking')); ?>">
                        <input type="hidden" name="trip-id" value="<?php echo esc_attr(get_the_ID()); ?>">
                        <button type="submit" class="btn">Book Now</button>
                    </form>
                <?php endif; ?>

                <form action="<?php echo esc_url(home_url('/inquire')); ?>" method="POST">
                    <input type="hidden" name="trip-id" value="<?php echo esc_attr(get_the_ID()); ?>">
                    <button type="submit" class="btn outline">Enquire</button>
                </form>

                <a href="https://wa.me/9779860110433"
                   class="whatsapp-link"
                   target="_blank"
                   rel="noopener noreferrer">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none"></rect>
                        <g fill="none" stroke="#25D366" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"></path>
                            <path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"></path>
                        </g>
                    </svg>

                    <span>
                        Get Instant Response:<br>
                        +977-9860110433 (WhatsApp)
                    </span>
                </a>
                <p>Dates and discounts are applied in the next step.</p>
            </div>

        </aside>
    </div>
</div>
