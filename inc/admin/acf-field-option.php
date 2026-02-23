<?php 
/*
* Custom Function to get button class based on selection
*/
function rha_get_button_class($option){
    switch($option) {
    case 'filled':
      $selected_button_class = 'btn-primary';
      break;

    case 'tonal':
      $selected_button_class = 'btn-secondary';
      break;

    case 'outline':
      $selected_button_class = 'btn-outline-primary';
      break;

    case 'outline-secondary':
      $selected_button_class ='btn-outline-secondary';
      break;

    default:
      $selected_button_class = 'btn-primary';
    }
    
    return $selected_button_class;
}

/*
* Get Color from the Backend
*/
function rha_get_global_colors(){
// get dynamic colors from theme options
$field=[];
$global_color_field = rha_acf_load_color_field_choices($field);
    if ($global_color_field) {
        $choices = $global_color_field['choices'];
        $color_array = [];
        // Loop through the choices
        foreach ($choices as $value => $label) {
            $color_array[] = ['value'=>$value,'label'=>$label];
        }
        return $color_array;
    }
}

/* 
* Custom Function to get Color Class 
* If New class is required then add required class in this switch case statement
*/
function rha_get_color_class($color,$prefix){
    $colors_lists_array = rha_get_global_colors();
    $text_color="";
    foreach($colors_lists_array as $col){
        switch($col['value']){
            case ($col['value'] == $color && str_contains( $col['label'], "Primary Color" ) && !str_contains($col['label'],"Tonal")):
                $text_color = 'primary-color';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "Secondary Color" ) && !str_contains($col['label'],"Tonal")):
                $text_color = 'secondary-color';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "Tonal Primary Color" )):
                $text_color = 'primary-tonal';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "Tonal Secondary Color" )):
                $text_color = 'secondary-tonal';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "White" )):
                $text_color = 'white';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "Body Color" )):
                $text_color = 'body';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "Body Text Color"  ) && !str_contains($col['label'],"Secondary")):
                $text_color = 'body-text';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "Body Text Color Secondary" )):
                $text_color = 'body-text-secondary';
                break;

            case ($col['value'] == $color && str_contains( $col['label'], "Black" )):
                $text_color = 'black';
                break;
                case ($col['value'] == $color && str_contains( $col['label'], "Grey-200" )):
                    $text_color = 'grey-200';
                    break;
        }
    }
    return $prefix . $text_color;
}

/**
 * Gets the color from backend theme option and populates these colors on color select field 
 * In required color select field
 */
function rha_acf_load_color_field_choices( $field ) {

    $field['choices'] = array();
    $choices = [];
    $theme_colors = get_field_object('theme_colors','option');

    /**
     * Getting the Color Picker Field value 
     * & it's assigned label name
     */
    if($theme_colors!='') {
        foreach($theme_colors['value'] as $key=>$value){
            $choices[] = ["value"=>$value,"label"=>ucwords(str_replace("_"," ",$key))];
        }
    }

    /**
     * Static utility colors for select options
     */
    $color_black = '#000000';
    $color_black_label = 'Black';
    
    $color_white = '#ffffff';
    $color_white_label = 'White';
    
    $color_grey_200 = '#F2F2F2';
    $color_grey_200_label = 'Grey 200';
    
    $color_grey_light = '#eaeaea';
    $color_grey_light_label = 'Grey Light';
    
    $color_blue_light = '#0a013b';
    $color_blue_light_label = 'Blue Light';
    
    $color_dark_blue = '#1E3D51';
    $color_dark_blue_label = 'Dark Blue';

    array_push($choices,
        array(
            "value" => $color_black,
            "label" => $color_black_label
        ),
        array(
            "value" => $color_white,
            "label" => $color_white_label
        ),
        array(
            "value" => $color_grey_200,
            "label" => $color_grey_200_label
        ),
        array(
            "value" => $color_grey_light,
            "label" => $color_grey_light_label
        ),
        array(
            "value" => $color_blue_light,
            "label" => $color_blue_light_label
        ),
        array(
            "value" => $color_dark_blue,
            "label" => $color_dark_blue_label
        )
    );

    if ( is_array($choices) ) {
        foreach ( $choices as $choice ) {
            $field['choices'][ $choice['value'] ] = $choice['label']." "."(". $choice['value'] .")";
        }
    }
    return $field;
}
add_filter('acf/load_field/name=body_background_color', 'rha_acf_load_color_field_choices');
add_filter('acf/load_field/name=main_title_color', 'rha_acf_load_color_field_choices');
add_filter('acf/load_field/name=description_text_color', 'rha_acf_load_color_field_choices');
add_filter('acf/load_field/name=card_background_color', 'rha_acf_load_color_field_choices');
