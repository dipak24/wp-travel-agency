<?php
/**
 * Block Name: Travel Style Explore Out
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_travel_style_section')) {
    return;
}

// Unique ID & spacing
$section_id      = 'travel-style-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title       = get_field('rha_travel_style_title');
$section_description = get_field('rha_travel_style_description');
$travel_styles       = get_field('rha_travel_style_lists'); // taxonomy term objects

if (empty($travel_styles) || !is_array($travel_styles)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section deal-offer-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <!-- Section Heading -->
        <?php if ($section_title || $section_description): ?>
            <header class="heading-block">
                <?php if ($section_title): ?>
                    <h2><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>

                <?php if ($section_description): ?>
                    <p><?php echo esc_html($section_description); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="table-wrap scrollbar">
            <table class="travel-deal-table">
                <thead>
                    <tr>
                        <th>Departing</th>
                        <th>Trip name</th>
                        <th>Days</th>
                        <th class="from">From USD</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td><strong>March 13, 2025</strong></td>
                            <td>
                                <div class="name-wrap">
                                    <div class="text-wrap">
                                        <a href="/trip/everest-base-camp-classic-trek-14-days">Everest Base Camp Classic Trek 14 Days</a>
                                        <span class="dest">Kathmandu to Kathmandu</span>
                                    </div>
                                </div>
                            </td>
                            <td>14</td>
                            <td>
                                <del>$2470</del>
                                <strong class="price">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="gripfire" class="svg-inline--fa fa-gripfire " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <path fill="currentColor" d="M112.5 301.4c0-73.8 105.1-122.5 105.1-203 0-47.1-34-88-39.1-90.4.4 3.3.6 6.7.6 10C179.1 110.1 32 171.9 32 286.6c0 49.8 32.2 79.2 66.5 108.3 65.1 46.7 78.1 71.4 78.1 86.6 0 10.1-4.8 17-4.8 22.3 13.1-16.7 17.4-31.9 17.5-46.4 0-29.6-21.7-56.3-44.2-86.5-16-22.3-32.6-42.6-32.6-69.5zm205.3-39c-12.1-66.8-78-124.4-94.7-130.9l4 7.2c2.4 5.1 3.4 10.9 3.4 17.1 0 44.7-54.2 111.2-56.6 116.7-2.2 5.1-3.2 10.5-3.2 15.8 0 20.1 15.2 42.1 17.9 42.1 2.4 0 56.6-55.4 58.1-87.7 6.4 11.7 9.1 22.6 9.1 33.4 0 41.2-41.8 96.9-41.8 96.9 0 11.6 31.9 53.2 35.5 53.2 1 0 2.2-1.4 3.2-2.4 37.9-39.3 67.3-85 67.3-136.8 0-8-.7-16.2-2.2-24.6z"></path>
                                    </svg>
                                    2175
                                </strong>
                            </td>
                            <td>
                                <a class="btn" href="/booking">Book Now</a>
                            </td>
                        </tr>
                    <tr>
                        <td>
                            <strong>December 29, 2025</strong>
                        </td>
                        <td>
                            <div class="name-wrap">
                                <div class="text-wrap">
                                    <a href="/trip/annapurna-base-camp-trek-10-days">Annapurna Base Camp Trek 10 Days</a>
                                    <span class="dest">Kathmandu to Kathmandu</span>
                                </div>
                            </div>
                        </td>
                        <td>10</td>
                        <td>
                            <del>$2133</del>
                            <strong class="price">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="gripfire" class="svg-inline--fa fa-gripfire " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path fill="currentColor" d="M112.5 301.4c0-73.8 105.1-122.5 105.1-203 0-47.1-34-88-39.1-90.4.4 3.3.6 6.7.6 10C179.1 110.1 32 171.9 32 286.6c0 49.8 32.2 79.2 66.5 108.3 65.1 46.7 78.1 71.4 78.1 86.6 0 10.1-4.8 17-4.8 22.3 13.1-16.7 17.4-31.9 17.5-46.4 0-29.6-21.7-56.3-44.2-86.5-16-22.3-32.6-42.6-32.6-69.5zm205.3-39c-12.1-66.8-78-124.4-94.7-130.9l4 7.2c2.4 5.1 3.4 10.9 3.4 17.1 0 44.7-54.2 111.2-56.6 116.7-2.2 5.1-3.2 10.5-3.2 15.8 0 20.1 15.2 42.1 17.9 42.1 2.4 0 56.6-55.4 58.1-87.7 6.4 11.7 9.1 22.6 9.1 33.4 0 41.2-41.8 96.9-41.8 96.9 0 11.6 31.9 53.2 35.5 53.2 1 0 2.2-1.4 3.2-2.4 37.9-39.3 67.3-85 67.3-136.8 0-8-.7-16.2-2.2-24.6z"></path>
                                </svg>1925
                            </strong>
                        </td>
                        <td><a class="btn" href="/booking">Book Now</a></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>November 15, 2025</strong>
                        </td>
                        <td>
                            <div class="name-wrap">
                                <div class="text-wrap">
                                    <a href="/trip/langtang-trek-11-days">Langtang Trek 11 Days</a>
                                    <span class="dest">Kathmandu to Kathmandu</span>
                                </div>
                            </div>
                        </td>
                        <td>11</td>
                        <td><del>$1975</del><strong class="price"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="gripfire" class="svg-inline--fa fa-gripfire " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M112.5 301.4c0-73.8 105.1-122.5 105.1-203 0-47.1-34-88-39.1-90.4.4 3.3.6 6.7.6 10C179.1 110.1 32 171.9 32 286.6c0 49.8 32.2 79.2 66.5 108.3 65.1 46.7 78.1 71.4 78.1 86.6 0 10.1-4.8 17-4.8 22.3 13.1-16.7 17.4-31.9 17.5-46.4 0-29.6-21.7-56.3-44.2-86.5-16-22.3-32.6-42.6-32.6-69.5zm205.3-39c-12.1-66.8-78-124.4-94.7-130.9l4 7.2c2.4 5.1 3.4 10.9 3.4 17.1 0 44.7-54.2 111.2-56.6 116.7-2.2 5.1-3.2 10.5-3.2 15.8 0 20.1 15.2 42.1 17.9 42.1 2.4 0 56.6-55.4 58.1-87.7 6.4 11.7 9.1 22.6 9.1 33.4 0 41.2-41.8 96.9-41.8 96.9 0 11.6 31.9 53.2 35.5 53.2 1 0 2.2-1.4 3.2-2.4 37.9-39.3 67.3-85 67.3-136.8 0-8-.7-16.2-2.2-24.6z"></path></svg>1775</strong></td><td><a class="btn" href="/booking">Book Now</a></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>November 22, 2025</strong>
                        </td>
                        <td><div class="name-wrap"><div class="text-wrap"><a href="/trip/annapurna-base-camp-trek-10-days">Annapurna Base Camp Trek 10 Days</a><span class="dest">Kathmandu to Kathmandu</span></div></div>
                        </td>
                        <td>10</td>
                        <td><del>$2133</del><strong class="price"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="gripfire" class="svg-inline--fa fa-gripfire " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M112.5 301.4c0-73.8 105.1-122.5 105.1-203 0-47.1-34-88-39.1-90.4.4 3.3.6 6.7.6 10C179.1 110.1 32 171.9 32 286.6c0 49.8 32.2 79.2 66.5 108.3 65.1 46.7 78.1 71.4 78.1 86.6 0 10.1-4.8 17-4.8 22.3 13.1-16.7 17.4-31.9 17.5-46.4 0-29.6-21.7-56.3-44.2-86.5-16-22.3-32.6-42.6-32.6-69.5zm205.3-39c-12.1-66.8-78-124.4-94.7-130.9l4 7.2c2.4 5.1 3.4 10.9 3.4 17.1 0 44.7-54.2 111.2-56.6 116.7-2.2 5.1-3.2 10.5-3.2 15.8 0 20.1 15.2 42.1 17.9 42.1 2.4 0 56.6-55.4 58.1-87.7 6.4 11.7 9.1 22.6 9.1 33.4 0 41.2-41.8 96.9-41.8 96.9 0 11.6 31.9 53.2 35.5 53.2 1 0 2.2-1.4 3.2-2.4 37.9-39.3 67.3-85 67.3-136.8 0-8-.7-16.2-2.2-24.6z"></path></svg>1925</strong>
                        </td>
                        <td><a class="btn outline" href="/booking">Book Now</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</section>
