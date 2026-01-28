<?php
/* Posts pagination: Default from WordPress */
function rha_pagination($query = false) {
    $big = 999999999;
    $paginate_args = array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'mid_size'  => 3, // Show number on each side of the current page
        'end_size'  => 1, // Show number at the beginning and end
        'next_text' => '<span class="next-icon"></span>',
        'prev_text' => '<span class="prev-icon"></span>',
    );
    if( !empty($query) ) {
        $paginate_args['total'] = $query->max_num_pages;
    }
    echo paginate_links($paginate_args); 
}

/* Post pagingation: Custom Structure */
function rha_listing_custom_pagination($totalblog, $post_per_page, $current_page, $class_name = "changePage", $current_page_url = "") {
    $total_pages = ceil($totalblog / $post_per_page);
    if ($total_pages > 1) {
        $page_counter = 0;
        echo '
        <div class="pagination-wrap">
        <ul class="pagination pagination-two text-center">';
        if($current_page != 1) {
            $_current_page = $current_page - 1;
            $page_url = $current_page_url . 'page/' . $_current_page; ?>
            <li class="prev page-item">
                <a class="page-link <?php echo $class_name; ?>" href="<?php echo esc_url($page_url); ?>" data-pageno="<?php echo $current_page - 1; ?>">
                    <span class="prev-icon"></span>
                </a>
            </li>
            <?php 
        }
        $dots = $dotLast = false;
        while ($page_counter <= $total_pages) {
            $page_url = $current_page_url . 'page/' . $page_counter;

            if ($total_pages > 5) {
                if ($current_page == 1) {
                    if ($page_counter < 6) { ?>
                        <li class="page-item<?php echo ($current_page == $page_counter) ? ' active' : ''; ?> <?php echo 'pg' . $page_counter; ?>">
                            <a class="page-link<?php echo ($current_page != $page_counter) ? ' ' . $class_name : ''; ?> <?php echo ($current_page == $page_counter) ? ' active' : ''; ?>" 
                                href="<?php echo esc_url($page_url); ?>" data-pageno="<?php echo $page_counter; ?>">
                                <?php echo $page_counter; ?>
                            </a>
                        </li>
                    <?php } else {
                        if (!$dots)
                            echo '<li class="page-item">...</li>';
                        $dots = true;
                    }
                } else if ($current_page < 4 && $current_page > 1) {
                    if ($page_counter < 5 || $page_counter == $total_pages) { ?>
                        <li class="page-item<?php echo ($current_page == $page_counter) ? ' active' : ''; ?> <?php echo 'pg' . $page_counter; ?>">
                            <a class="page-link<?php echo ($current_page != $page_counter) ? ' ' . $class_name : ''; ?> <?php echo ($current_page == $page_counter) ? ' active' : ''; ?>" 
                                href="<?php echo esc_url($page_url); ?>" data-pageno="<?php echo $page_counter; ?>">
                                <?php echo $page_counter; ?>
                            </a>
                        </li>
                        <?php } else {
                        if (!$dots)
                            echo '<li class="page-item">...</li>';
                        $dots = true;
                    }
                } else {
                    if (($total_pages - $current_page) > 3) {
                        if ($page_counter == 1 || $page_counter == $total_pages || $page_counter == $current_page || $page_counter == $current_page + 1) { ?>
                            <li class="page-item<?php echo ($current_page == $page_counter) ? ' active' : ''; ?> <?php echo 'pg' . $page_counter; ?>">
                                <a class="page-link<?php echo ($current_page != $page_counter) ? ' ' . $class_name : ''; ?> <?php echo ($current_page == $page_counter) ? ' active' : ''; ?>" 
                                    href="<?php echo esc_url($page_url); ?>" data-pageno="<?php echo $page_counter; ?>">
                                    <?php echo $page_counter; ?>
                                </a>
                            </li>
                        <?php $dots = false;
                        } else {
                            if (!$dots) {
                                echo '<li class="page-item">...</li>';
                                $dots = true;
                            }
                        }
                    } else {
                        if (
                            $page_counter == 1 || $page_counter == $total_pages || $page_counter == $current_page || $page_counter == $current_page + 1
                            || $page_counter == $total_pages - 3 || $page_counter == $total_pages - 2 || $page_counter == $total_pages - 1
                        ) { ?>
                            <li class="page-item<?php echo ($current_page == $page_counter) ? ' active' : ''; ?> <?php echo 'pg' . $page_counter; ?>">
                                <a class="page-link<?php echo ($current_page != $page_counter) ? ' ' . $class_name : ''; ?> <?php echo ($current_page == $page_counter) ? ' active' : ''; ?>" 
                                    href="<?php echo esc_url($page_url); ?>" data-pageno="<?php echo $page_counter; ?>">
                                    <?php echo $page_counter; ?>
                                </a>
                            </li>
                <?php $dots = false;
                        } else {
                            if (!$dots) {
                                echo '<li class="page-item">...</li>';
                                $dots = true;
                            }
                        }
                    }
                }
            } else { 
                if($page_counter > 0) { ?>
                <li class="page-item<?php echo ($current_page == $page_counter) ? ' active' : ''; ?> <?php echo 'pg' . $page_counter; ?>">
                    <a class="page-link<?php echo ($current_page != $page_counter) ? ' ' . $class_name : ''; ?> <?php echo ($current_page == $page_counter) ? ' active' : ''; ?>" 
                        href="<?php echo esc_url($page_url); ?>" data-pageno="<?php echo $page_counter; ?>">
                        <?php echo $page_counter; ?>
                    </a>
                </li>
                <?php 
                }
            }
            $page_counter++;
        } 
        if($current_page != $total_pages) {
            $_current_page = $current_page + 1;
            $page_url = $current_page_url . 'page/' . $_current_page; ?>
            <li class="next page-item">
                <a class="page-link <?php echo $class_name; ?>" href="<?php echo esc_url($page_url); ?>" data-pageno="<?php echo $current_page + 1; ?>">
                    <span class="next-icon"></span>
                </a>
            </li>
        <?php
        }
        echo '
            </ul>
        </div>';
    }
}