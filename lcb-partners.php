<?php
/**
 * Plugin Name: LCB Partners
 * Description: Simple partners management for Wordpress blog.
 * Version: 1.0
 * Author: LCB
 * Author URI: http://leftcurlybracket.com/
 * License: GNU
 */

add_action('plugins_loaded', 'wan_load_textdomain');
function wan_load_textdomain() {
load_plugin_textdomain( 'lcb-partners', false, dirname( plugin_basename(__FILE__) ) . '/languages');
} 

add_action('init', 'create_post_type');

function create_post_type() {
    $labels = array(
        'name' => __('Partners','lcb-partners'),
        'singular_name' => __('Partner','lcb-partners'),
        'menu_name' => __('Partners','lcb-partners'),
        'add_new' => __('Add new','lcb-partners'),
        'add_new_item' => __('Add new partner','lcb-partners'),
        'not_found' => __('No partners found','lcb-partners'),
        'search_items' => __('Search Partners','lcb-partners')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt',),
    );

    register_post_type('lcb_partners', $args);
}

function output() {
    ob_start();

    $type = 'lcb_partners';
    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1
    );

    $query = null;
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-lg-6"><?php the_post_thumbnail(); ?></div>
            <div class="col-lg-6"><?php the_excerpt(); ?></div>
        <?php endwhile;
    }
    wp_reset_query();

    return ob_get_clean();
}

add_shortcode('partner', 'output');
