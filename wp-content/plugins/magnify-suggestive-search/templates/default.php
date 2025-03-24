<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    
    $icon_picker = isset($search_bar_data['icon_picker']) ? $search_bar_data['icon_picker'] : 'fas fa-search';
    $post_types = isset($search_bar_data['post_types']) ? $search_bar_data['post_types'] : 'post';
    $submit_button_label = isset($search_bar_data['mnssp_settings']['submit_button_label']) ? $search_bar_data['mnssp_settings']['submit_button_label'] : 'Search';
    $placeholder_text = isset($search_bar_data['mnssp_settings']['placeholder_text']) ? $search_bar_data['mnssp_settings']['placeholder_text'] : 'Search...';
    $show_submit_button = isset($search_bar_data['mnssp_settings']['show_submit_button']) ? $search_bar_data['mnssp_settings']['show_submit_button'] : false;
    $border_color = isset($search_bar_data['mnssp_settings']['border_color']) ? $search_bar_data['mnssp_settings']['border_color'] : '#e7f5ff';
    $placeholder_color = isset($search_bar_data['mnssp_settings']['placeholder_color']) ? $search_bar_data['mnssp_settings']['placeholder_color'] : '';
    $icon_color = isset($search_bar_data['mnssp_settings']['icon_color']) ? $search_bar_data['mnssp_settings']['icon_color'] : '#ffffff';
    $icon_bg_color = isset($search_bar_data['mnssp_settings']['icon_bg_color']) ? $search_bar_data['mnssp_settings']['icon_bg_color'] : '#000000';
    $submit_button_bg_color = isset($search_bar_data['mnssp_settings']['submit_button_bg_color']) ? $search_bar_data['mnssp_settings']['submit_button_bg_color'] : '#000000';
    $submit_button_text_color = isset($search_bar_data['mnssp_settings']['submit_button_text_color']) ? $search_bar_data['mnssp_settings']['submit_button_text_color'] : '#ffffff';
    $submit_button_bg_hover_color = isset($search_bar_data['mnssp_settings']['submit_button_bg_hover_color']) ? $search_bar_data['mnssp_settings']['submit_button_bg_hover_color'] : '#000000';
    $submit_button_text_hover_color = isset($search_bar_data['mnssp_settings']['submit_button_text_hover_color']) ? $search_bar_data['mnssp_settings']['submit_button_text_hover_color'] : '#ffffff';
?>
<form role="search" method="get" id="default-serach" class="search-form default" action="<?php echo esc_url(home_url('/')); ?>" style="border-color: <?php echo esc_attr($border_color); ?>;">
    <input type="search" class="search-input" placeholder="<?php echo esc_html($placeholder_text); ?>" value="<?php echo get_search_query(); ?>" name="s" style="color: <?php echo esc_attr($placeholder_color); ?>;">
    <input type="hidden" name="post_type" value="<?php echo esc_attr($post_types); ?>">
    <?php wp_nonce_field('mnssp_search_nonce'); ?>
    <?php if($show_submit_button) { ?>
        <button type="submit" class="search-button mnssp-btn" style="color: <?php echo esc_attr($submit_button_text_color); ?>; background: <?php echo esc_attr($submit_button_bg_color); ?>;"><?php echo esc_html($submit_button_label); ?></button>
    <?php } else { ?>
        <button type="submit" class="search-button" style="color: <?php echo esc_attr($icon_color); ?>; background: <?php echo esc_attr($icon_bg_color); ?>;"><i class="<?php echo esc_attr($icon_picker); ?>"></i></button>
    <?php } ?>
</form>
