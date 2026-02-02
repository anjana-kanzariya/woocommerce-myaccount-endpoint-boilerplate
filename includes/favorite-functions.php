<?php
// Register endpoint
add_action('init', function () {
    add_rewrite_endpoint('favorites', EP_ROOT | EP_PAGES);
});

// Add to WooCommerce menu
add_filter('woocommerce_account_menu_items', function ($items) {
    $items['favorites'] = __('Favorites', 'woocommerce');
    return $items;
});

// Load template
add_action('woocommerce_account_favorites_endpoint', function () {
    wc_get_template('myaccount/favorite.php');
});

function get_user_favourites() {
    $user_id = get_current_user_id();

    if (!$user_id) {
        echo '<p>Please login to see your favorites.</p>';
        return;
    }

    $favourite_products = get_user_meta($user_id, 'favourites', true);

    if (!empty($favourite_products)) {
        display_products_slider($favourite_products);
    } else {
        echo '<p>No favorite products yet.</p>';
    }
}

function display_products_slider($products){
    $products = is_array($products)? $products : explode(',', $products);
    $product_count = count($products);
    if($products){
        $args = array(
            'post_type'      => array('product', 'product_variation'),
            'post__in'       => $products,
            'no_found_rows' => true,
            'fields' => 'ids',
            'posts_per_page' => $product_count,
            'post_status' => 'publish',
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            $layout_class = " list-view";
            if(is_account_page('favorites')){
                echo '<ul class="products columns-'. esc_attr( wc_get_loop_prop( 'columns' ) ) . $layout_class . '">';
            }else{
                woocommerce_product_loop_start();
            }            
            while ( $query->have_posts() ) {
                $query->the_post();
                wc_get_template_part('content', 'product');
            }
            woocommerce_product_loop_end();
            wp_reset_postdata(); 
        }
    }
}

add_action('woocommerce_before_shop_loop_item_title', 'add_favourite_button_to_product', 15);
add_action('woocommerce_single_product_summary', 'add_favourite_button_to_product', 35);
function add_favourite_button_to_product() {

    $product_id = get_the_ID();

    // Guest → static
    if (!is_user_logged_in()) {
        echo '<span class="add-product-to-favourite favourite guest"
                data-product_id="' . $product_id . '">
                <i class="fav-icon"></i>
              </span>';
        return;
    }

    $user_id    = get_current_user_id();
    $favourites = get_user_meta($user_id, 'favourites', true);

    if (!$favourites) {
        $favourites = [];
    }

    $class = in_array($product_id, $favourites) ? 'added' : '';

    echo '<span class="add-product-to-favourite favourite ' . $class . '" 
            data-product_id="' . $product_id . '">
            <i class="fav-icon"></i>
          </span>';
}




add_action('wp_ajax_add_product_to_favourite', 'add_product_to_favourite');

function add_product_to_favourite() {

    if (!wp_verify_nonce($_POST['nonce'], 'fav_nonce')) {
        wp_send_json_error('invalid_nonce');
    }

    if (!is_user_logged_in()) {
        wp_send_json_error();
    }

    $user_id    = get_current_user_id();
    $product_id = intval($_POST['product_id']);
    $action     = sanitize_text_field($_POST['fav_action']);

    $favourites = get_user_meta($user_id, 'favourites', true);

    if (!$favourites) {
        $favourites = [];
    }

    if ($action === 'add_product') {
        $favourites[] = (int)$product_id;
    } else {
        if (($key = array_search($product_id, $favourites)) !== false) {
            unset($favourites[$key]);
        }
    }

    $favourites = array_unique(array_values($favourites));

    update_user_meta($user_id, 'favourites', $favourites);

    wp_send_json_success([
        'count' => count($favourites)
    ]);
}

