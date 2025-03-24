<?php
    if ( ! defined( 'ABSPATH' ) ) exit;

    $icon_picker = isset($search_bar_data['icon_picker']) ? $search_bar_data['icon_picker'] : 'fas fa-search';
    $post_types = isset($search_bar_data['post_types']) ? $search_bar_data['post_types'] : 'post';
    $placeholder_text = isset($search_bar_data['mnssp_settings']['placeholder_text']) ? $search_bar_data['mnssp_settings']['placeholder_text'] : 'Search...';
    $icon_color = isset($search_bar_data['mnssp_settings']['icon_color']) ? $search_bar_data['mnssp_settings']['icon_color'] : '#ffffff';
    $placeholder_color = isset($search_bar_data['mnssp_settings']['placeholder_color']) ? $search_bar_data['mnssp_settings']['placeholder_color'] : '';
    $border_color = isset($search_bar_data['mnssp_settings']['border_color']) ? $search_bar_data['mnssp_settings']['border_color'] : '#e7f5ff';
?>
<form id="hover-icon" role="search" method="get" class="search-form serach-page d-flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="search-box">
        <input type="search" class="search-field search-input"  placeholder="<?php echo esc_html($placeholder_text); ?>"  value="<?php echo esc_attr(the_search_query()); ?>" name="s" style="color: <?php echo esc_attr($placeholder_color); ?>;border-bottom-color: <?php echo esc_attr($border_color); ?>;" required>
        <input type="hidden" name="post_type" value="<?php echo esc_attr($post_types); ?>">
        <?php wp_nonce_field('mnssp_search_nonce'); ?>
        <button type="submit" name="button" class="search-btn" style="color: <?php echo esc_attr($icon_color); ?>;">
            <i class="<?php echo esc_attr($icon_picker); ?>" aria-hidden="true"></i>
        </button>
    </div>
</form>
