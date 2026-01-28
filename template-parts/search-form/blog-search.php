<?php

/**
 * Search input field displays on Blog listing page
 * 
 * Searches blog post in the site
 */


$finalurl = isset($args['finalurl']) ? $args['finalurl'] : '';
$search_blog = isset($args['search_blog']) ? $args['search_blog'] : ''; ?>

<div class="section-heading-search-box">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url($finalurl); ?>">
        <input type="search" class="blog-search-field" placeholder="Search"
            value="<?php echo esc_attr($search_blog); ?>" name="s">
    </form>
</div>