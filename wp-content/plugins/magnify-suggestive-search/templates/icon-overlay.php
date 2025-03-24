<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    
    $icon_picker = isset($search_bar_data['icon_picker']) ? $search_bar_data['icon_picker'] : 'fas fa-search';
    $post_types = isset($search_bar_data['post_types']) ? $search_bar_data['post_types'] : 'post';
    $placeholder_text = isset($search_bar_data['mnssp_settings']['placeholder_text']) ? $search_bar_data['mnssp_settings']['placeholder_text'] : 'Search...';
    $icon_color = isset($search_bar_data['mnssp_settings']['icon_color']) ? $search_bar_data['mnssp_settings']['icon_color'] : '#ffffff';
    $icon_bg_color = isset($search_bar_data['mnssp_settings']['icon_bg_color']) ? $search_bar_data['mnssp_settings']['icon_bg_color'] : '#000000';
    $placeholder_color = isset($search_bar_data['mnssp_settings']['placeholder_color']) ? $search_bar_data['mnssp_settings']['placeholder_color'] : '';
?>
<div id="mnssp-overlay-template" class="overlay">
    <span class="closebtn" title="Close Overlay">×</span>
    <div class="overlay-content">
        <form role="search" method="get" class="search-form icon-overlay" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" placeholder="<?php echo esc_html($placeholder_text); ?>" value="<?php echo get_search_query(); ?>" name="s" style="color: <?php echo esc_attr($placeholder_color); ?>;">
            <input type="hidden" name="post_type" value="<?php echo esc_attr($post_types); ?>">
            <?php wp_nonce_field('mnssp_search_nonce'); ?>
            <button class="overlay-search-btn" type="submit" style="color: <?php echo esc_attr($icon_color); ?>; background: <?php echo esc_attr($icon_bg_color); ?>;"><i class="<?php echo esc_attr($icon_picker); ?>"></i></button>
        </form>
    </div>
</div>
<button class="openBtn mnssp-overlay-template" style="color: <?php echo esc_attr($icon_color); ?>; background: <?php echo esc_attr($icon_bg_color); ?>;"><i class="<?php echo esc_attr($icon_picker); ?>"></i></button>
