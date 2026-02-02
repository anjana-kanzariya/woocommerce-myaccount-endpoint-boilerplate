<?php
add_action('wp_enqueue_scripts', function () {

    if (!function_exists('is_woocommerce') || !is_woocommerce()) {
        return;
    }

    $js_path  = get_template_directory() . '/assets/js/favorite.js';
    $css_path = get_template_directory() . '/assets/css/favorite.css';

    // JS
    wp_enqueue_script('favorite-script', get_template_directory_uri() . '/assets/js/favorite.js', ['jquery'], file_exists($js_path) ? filemtime($js_path) : '1.0', true);
    wp_localize_script('favorite-script', 'mee_object', [ 
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('fav_nonce')
    ]);

    // CSS
    wp_enqueue_style('favorite-style', get_template_directory_uri() . '/assets/css/favorite.css', [], file_exists($css_path) ? filemtime($css_path) : '1.0');

});