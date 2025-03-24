<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode( 'mnssp-bar', 'mnssp_render_search_bar_shortcode' );

function mnssp_render_search_bar_shortcode( $atts ) {

    global $mnssp_template_types;

    $atts = shortcode_atts(
        array(
            'bar-id' => 0,
        ),
        $atts,
        'mnssp-bar'
    );

    $bar_id = intval($atts['bar-id']);

    if ($bar_id) {
        $post = get_post($bar_id);
        if ($post && $post->post_type === 'magnify_search') {

            $template_type = get_post_meta($post->ID, 'template_type', true);
            $posttypes = get_post_meta($post->ID, 'posttypes', true);
            $icon_picker = get_post_meta($post->ID, 'icon_picker', true);

            $post_types_string = implode(',', array_map('esc_attr', $posttypes));

            $options = get_option('mnssp_settings');

            $search_bar_data = array(
                'form_name' => $post->post_title,
                'template_type' => $template_type,
                'post_types' => $post_types_string,
                'icon_picker' => $icon_picker,
                'mnssp_settings' => $options
            );

            $template = in_array($template_type, ['hover-icon', 'click-icon', 'icon-overlay', 'autocomplete'])
            ? $template_type
            : 'default';

            $custom_css = "";

            $show_submit_button = isset($search_bar_data['mnssp_settings']['show_submit_button']) ? $search_bar_data['mnssp_settings']['show_submit_button'] : false;
            $submit_button_bg_color = isset($search_bar_data['mnssp_settings']['submit_button_bg_color']) ? $search_bar_data['mnssp_settings']['submit_button_bg_color'] : '#000000';
            $submit_button_bg_hover_color = isset($search_bar_data['mnssp_settings']['submit_button_bg_hover_color']) ? $search_bar_data['mnssp_settings']['submit_button_bg_hover_color'] : '#000000';
            $submit_button_text_hover_color = isset($search_bar_data['mnssp_settings']['submit_button_text_hover_color']) ? $search_bar_data['mnssp_settings']['submit_button_text_hover_color'] : '#ffffff';

            if ( $template_type == 'autocomplete' ) {
                
                
                $custom_css .= "#mnssp-autocomplete-form .search-button.mnssp-btn:hover {
                    color: " . esc_attr($show_submit_button ? $submit_button_text_hover_color : $submit_button_bg_color) . " !important;
                    background-color: " . esc_attr($show_submit_button ? $submit_button_bg_hover_color : $submit_button_bg_color) . " !important;
                }";
            } elseif ( $template_type == 'default' ) {

                $custom_css .= "#default-serach .search-button.mnssp-btn:hover {
                    color: " . esc_attr($show_submit_button ? $submit_button_text_hover_color : $submit_button_bg_color) . " !important;
                    background-color: " . esc_attr($show_submit_button ? $submit_button_bg_hover_color : $submit_button_bg_color) . " !important;
                }";

            }

            add_action('wp_enqueue_scripts', function() use ($custom_css) {
                wp_add_inline_style('mnssp-inline-styles', $custom_css);
            });

            if (!isset($mnssp_template_types)) {
                $mnssp_template_types = array();
            }
            $mnssp_template_types[] = $template_type;

            ob_start();

            include MNSSP_PATH . "templates/{$template}.php";

            $output = ob_get_clean();
            return $output;

        }
    }
}
