<?php
function mnssp_get_search_bar_data($post_id) {
    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'magnify_search') {
        return false;
    }

    return array(
        'form_name' => $post->post_title,
        'template_type' => get_post_meta($post_id, 'template_type', true),
        'post_types' => get_post_meta($post_id, 'posttypes', true),
        'icon_picker' => get_post_meta($post_id, 'icon_picker', true),
    );
}

add_action('pre_get_posts', 'mnssp_modify_search_query');
function mnssp_modify_search_query($query) {

    $mnssp_settings = get_option('mnssp_settings');

    if ($query->is_search && !is_admin()) {

        if (isset($mnssp_settings['limit'])) {
            $query->set('posts_per_page', $mnssp_settings['limit']);
        }

        if (isset($_GET['_wpnonce'])) {

            $nonce = sanitize_key($_GET['_wpnonce']);

            if ( wp_verify_nonce(wp_unslash($nonce), 'mnssp_search_nonce')) {
                if (isset($_GET['post_type']) && !empty($_GET['post_type'])) {
                    $post_types = sanitize_text_field(wp_unslash($_GET['post_type']));
        
                    if (strpos($post_types, ',') !== false) {
                        $post_types = explode(',', $post_types);
                    } else {
                        $post_types = [$post_types];
                    }
                    
                    $query->set('post_type', $post_types);
                }
            }
        }

    }
}

function mnssp_get_collections() {
    
    $endpoint_url = MNSSP_API_URL . 'getCollections';

    $options = [
        'body' => [],
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ];
    $response = wp_remote_post($endpoint_url, $options);

    if (!is_wp_error($response)) {
        $response_body = wp_remote_retrieve_body($response);
        $response_body = json_decode($response_body);

        if (isset($response_body->data) && !empty($response_body->data)) {
           return  $response_body->data;
        }
        return  [];
    }

    return  [];
}

function mnssp_get_filtered_products($cursor = '', $search = '', $collection = 'pro') {
    $endpoint_url = MNSSP_API_URL . 'getFilteredProducts';

    $remote_post_data = array(
        'collectionHandle' => $collection,
        'productHandle' => $search,
        'paginationParams' => array(
            "first" => 12,
            "afterCursor" => $cursor,
            "beforeCursor" => "",
            "reverse" => true
        )
    );

    $body = wp_json_encode($remote_post_data);

    $options = [
        'body' => $body,
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ];
    $response = wp_remote_post($endpoint_url, $options);

    if (!is_wp_error($response)) {
        $response_body = wp_remote_retrieve_body($response);
        $response_body = json_decode($response_body);

        if (isset($response_body->data) && !empty($response_body->data)) {
            if (isset($response_body->data->products) && !empty($response_body->data->products)) {
                return  array(
                    'products' => $response_body->data->products,
                    'pagination' => $response_body->data->pageInfo
                );
            }
        }
        return [];
    }
    
    return [];
}

function mnssp_get_filtered_products_ajax() {
    $cursor = isset($_POST['cursor']) ? sanitize_text_field(wp_unslash($_POST['cursor'])) : '';
    $search = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
    $collection = isset($_POST['collection']) ? sanitize_text_field(wp_unslash($_POST['collection'])) : 'pro';

    check_ajax_referer('mnssp_create_pagination_nonce_action', 'mnssp_pagination_nonce');

    $get_filtered_products = mnssp_get_filtered_products($cursor, $search, $collection);
    ob_start();
    if (isset($get_filtered_products['products']) && !empty($get_filtered_products['products'])) {
        foreach ( $get_filtered_products['products'] as $product ) {

            $product_obj = $product->node;
            
            if (isset($product_obj->inCollection) && !$product_obj->inCollection) {
                continue;
            }

            $product_obj = $product->node;

            $demo_url = isset($product->node->metafield->value) ? $product->node->metafield->value : '';
            $product_url = isset($product->node->onlineStoreUrl) ? $product->node->onlineStoreUrl : '';
            $image_src = isset($product->node->images->edges[0]->node->src) ? $product->node->images->edges[0]->node->src : ''; ?>

            <div class="mnssp-grid-item">
                <div class="mnssp-image-wrap">
                    <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($product_obj->title); ?>">
                    <div class="mnssp-image-overlay">
                        <a class="mnssp-demo-url mnssp-btn" href="<?php echo esc_attr($demo_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html('Demo'); ?></a>
                        <a class="mnssp-buy-now mnssp-btn" href="<?php echo esc_attr($product_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html('Buy Now'); ?></a>
                    </div>
                </div>
                <footer>
                    <h3><?php echo esc_html($product_obj->title); ?></h3>
                </footer>
            </div>
        <?php }
    }
    $output = ob_get_clean();

    $pagination = isset($get_filtered_products['pagination']) ?  $get_filtered_products['pagination'] : [];
    wp_send_json(array(
        'content' => $output,
        'pagination' => $pagination
    ));
}

add_action('wp_ajax_mnssp_get_filtered_products', 'mnssp_get_filtered_products_ajax');
add_action('wp_ajax_nopriv_mnssp_get_filtered_products', 'mnssp_get_filtered_products_ajax');

add_action('admin_notices', 'mnssp_admin_notice_with_html');
function mnssp_admin_notice_with_html() {
    ?>
    <div class="notice is-dismissible mnssp">
        <div class="mnssp-notice-banner-wrap" style="background-image: url(<?php echo esc_url( MNSSP_URL . 'assets/images/banner-bg.png'); ?>)">
            <div class="mnssp-notice-heading">
              <h1 class="mnssp-main-head"><?php echo esc_html('WORDPRESS THEME BUNDLE 115+ Templates');?></h1>
              <p class="mnssp-sub-head"><?php echo esc_html('Get 115+ WordPress Themes Worth  ');?><span><?php echo esc_html('$4999+');?></span></p>
                <div class="mnssp-notice-btn">
                    <a class="mnssp-buy-btn" target="_blank" href="<?php echo esc_url( MNSSP_MAIN_URL . 'products/wordpress-theme-bundle' ); ?>"><?php echo esc_html('Buy Now');?></a>
                </div>
            </div>
            <div class="mnssp-price-tag">
                <div class="mnssp-add-div">
                    <div class="mnssp-border-div">
                        <p class="mnssp-price"><?php echo esc_html('AT $89');?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}