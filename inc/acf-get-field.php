<?php

/**
 * The function uses acf get_field fucntion
 */

/* Get Brands Listing data from Brands listing block */
function rha_brands_listing($field) {
    $brand_loop = array();
    $i = 0;
    $brands = get_field($field);
    if($brands!='' && count($brands)>0) {
        foreach($brands as $brand) {
            if(isset($brand['brand_details']) && $brand['brand_details']!='') {
                $induvidual_brand = $brand['brand_details'];
                $flow_direction = $brand['flow_direction'] ? '' : 'marquee--reverse';
                $j = 0;
                foreach($induvidual_brand as $indbr) {
                    if(isset($indbr['brand_logo'])) {
                        $brand_logo = $indbr['brand_logo'];
                        if($brand_logo!='' && isset($brand_logo['id'])) {
                            $logoid = $brand_logo['id'];
                            $brand_url = $indbr['brand_url'];
                            $brand_loop[$i][$j]['brand_logo'] = $brand_logo;
                            $brand_loop[$i][$j]['logo_url'] = $brand_url;
                            $brand_loop[$i][$j]['flow'] = $flow_direction;
                            $j++;
                        }                  
                    }
                }
            }
            $i++;
        }
        return $brand_loop;
    }
    return false;
}

/* Get style field for each block */
function rha_get_block_style() {
    $padding_type = get_field('style_padding_type');
    $section_padding = get_field('style_section_padding');
    $padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
    // $padding = $padding_type;
    $section_padding = ( $padding == '' ) ? $padding_type : $padding_type . ' ' . $padding;
    return $section_padding;
}