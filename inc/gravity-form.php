<?php
// Changes Gravity Forms Ajax Spinner (next, back, submit) to a transparent image
// this allows you to target the css and create a pure css spinner like the one used below in the style.css file of this gist.
add_filter('gform_ajax_spinner_url', 'rha_spinner_url', 10, 2);
function rha_spinner_url($image_src, $form)
{
    return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // relative to you theme images folder
}

/* Gravity form validation */
add_filter('gform_field_validation', 'gravity_form_validation', 10, 4);
function gravity_form_validation($result, $value, $form, $field)
{
    
    // $patternPhone = "/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/";
    $patternPhone = "/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/";
    $patternName = "/^[a-zA-Z]{3,60}$/";

    if ($field->type == 'phone' && $value != '' && $field->phoneFormat != 'standard' && !preg_match($patternPhone, $value)  ) {
        $result['is_valid'] = false;
        $result['message']  = 'Please enter a valid phone number';
    }
    if ($field->type == 'phone' && strlen($value) <= 9 ) {
        $result['is_valid'] = false;
        $result['message']  = 'Please enter phone number with character 10 or more';
    }

    if ($field->type == 'text' && strlen($value) > 100) {
        $result['is_valid'] = false;
        $result['message']  = 'This field must be 100 characters or fewer.';
    }

    if ($field->type == 'textarea' && strlen($value) > 500) {
        $result['is_valid'] = false;
        $result['message']  = 'This field must be 500 characters or fewer.';
    }


    if ($field->type == 'url' && strlen($value) > 2048) {
        $result['is_valid'] = false;
        $result['message']  = 'This field must be 2048 characters or fewer.';
    }

    if ($field->type == 'name') {
        $first  = rgar($value, $field->id . '.3');
        $middle = rgar($value, $field->id . '.4');
        $last   = rgar($value, $field->id . '.6');

        if (!empty($first) && !preg_match($patternName, $first)) {
            $result['is_valid'] = false;
            $result['message']  = 'Please enter a valid name field with more than 3 character.';
        }
        if (!empty($middle) && !preg_match($patternName, $middle)) {
            $result['is_valid'] = false;
            $result['message']  = 'Please enter a valid name field with more than 3 character.';
        }
        if (!empty($last) && !preg_match($patternName, $last)) {
            $result['is_valid'] = false;
            $result['message']  = 'Please enter a valid name field with more than 3 character.';
        }
    }

    if ($field->type == 'address') {
        $city    = rgar( $value, $field->id . '.3' );
        $state   = rgar( $value, $field->id . '.4' );
        $zip     = rgar( $value, $field->id . '.5' );
        $country = rgar( $value, $field->id . '.6' );

        $street_label = $field->inputs[0]['label'];
        $street2_label = $field->inputs[1]['label'];
        $city_label = $field->inputs[2]['label'];
        $state_label = $field->inputs[3]['label'];

        if (!empty($street) && !preg_match("/^.{5,100}$/", $street)) {
            $result['is_valid'] = false;
            $result['message']  .= "<br>$street_label value must be between 5 and 100 characters";
        }

        if (!empty($street2) && !preg_match("/^.{5,100}$/", $street2)) {
            $result['is_valid'] = false;
            $result['message']  .= "<br>$street2_label value must be between 5 and 100 characters";
        }

        if (!empty($city) && strlen($city) > 100) {
            $result['is_valid'] = false;
            $result['message']  .= "<br>$city_label value must be 100 characters or fewer.";
        }

        if (!empty($state) && strlen($state) > 100) {
            $result['is_valid'] = false;
            $result['message']  .= "<br>$state_label must be 100 characters or fewer.";
        }
        
    }

    return $result;
}

define('BOOKING_FORM_ID', 2);
//define('CUSTOMIZE_TRIP_FORM_ID', 3);

add_action('init', function () {
    $hooks = [
        'gform_pre_render_',
        'gform_pre_validation_',
        'gform_pre_submission_filter_',
        'gform_admin_pre_render_'
    ];

    foreach ($hooks as $hook) {
        add_filter($hook . BOOKING_FORM_ID, 'populate_trip_product_dropdown');
        //add_filter($hook . CUSTOMIZE_TRIP_FORM_ID, 'populate_trip_product_dropdown');
    }
});

function populate_trip_product_dropdown($form) {
    $selected_trip_id = get_requested_trip_id();

    foreach ($form['fields'] as &$field) {
        if (!is_target_trip_product_field($field)) {
            continue;
        }

        $trips = get_posts([
            'post_type' => 'trip',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);

        $field->choices = [];

        if (!empty($trips)) {
            foreach ($trips as $trip) {
                $is_selected = $selected_trip_id && $trip->ID == $selected_trip_id;

                //Handle Price
                $regular_price = get_post_meta($trip->ID, 'trip_regular_price', true);
                $sale_price    = get_post_meta($trip->ID, 'trip_sale_price', true);
                if (is_numeric($regular_price)) {
                    $price = floatval($regular_price);
                } elseif (is_numeric($sale_price)) {
                    $price = floatval($sale_price);
                } else {
                    $price = 0;
                }

                $field->choices[] = [
                    'text'       => $trip->post_title,
                    'value'      => $trip->ID,
                    'isSelected' => $is_selected,
                    'price'      => $price,
                ];
            }

            // Optional placeholder at the top
            array_unshift($field->choices, [
                'text'  => 'Select your trip',
                'value' => '',
                'price' => 0,
            ]);
        } else {
            // Fallback if no trips found
            $field->choices[] = [
                'text'  => 'No trips available',
                'value' => '',
                'price' => 0,
            ];
        }
    }

    return $form;
}

function get_requested_trip_id() {
    if (!empty($_GET['trip_id'])) {
        return intval($_GET['trip_id']);
    }

    if (!empty($_SERVER['HTTP_TRIP_ID'])) {
        return intval($_SERVER['HTTP_TRIP_ID']);
    }

    return null;
}

function is_target_trip_product_field($field) {
    return (
        $field->type === 'product' &&
        $field->inputType === 'select' &&
        $field->inputName === 'trip_products'
    );
}

