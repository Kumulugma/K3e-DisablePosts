<?php

/*
  Plugin name: K3e - WP - DisablePosts
  Plugin URI: https://www.k3e.pl/
  Description: Przystawka K3e do wyłączenia wpisów typu post.
  Author: K3e
  Author URI: https://www.k3e.pl/
  Text Domain:
  Domain Path:
  Version: 0.0.1a
 */
require_once 'updater/K3eUpdater.php';
add_action('init', 'k3e_disable_posts_init');

Puc_v4_Factory::buildUpdateChecker(
        'http://k3e.pl/?action=get_metadata&slug=k3e-wp-disableposts',
        __FILE__, //Full path to the main plugin file or functions.php.
        'k3e-wp-disableposts'
);

function k3e_disable_posts_init() {
    do_action('k3e_disable_posts_init');
    
        add_action('template_redirect', 'post_redirect');

    function post_redirect() {
        $homepage_id = get_option('page_on_front');
        if ('post' == get_post_type()) {
            wp_redirect(home_url('index.php?page_id=' . $homepage_id));
        }
    }
    
    add_action('admin_menu', 'remove_default_post_type');

    function remove_default_post_type() {
        remove_menu_page('edit.php');
    }

    add_action('admin_bar_menu', 'remove_default_post_type_menu_bar', 999);

    function remove_default_post_type_menu_bar($wp_admin_bar) {
        $wp_admin_bar->remove_node('new-post');
    }

    add_action('wp_dashboard_setup', 'remove_draft_widget', 999);

    function remove_draft_widget() {
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    }

}

function k3e_disable_posts_activate() {
    
}

register_activation_hook(__FILE__, 'k3e_disable_posts_activate');

function k3e_disable_posts_deactivate() {
    
}

register_deactivation_hook(__FILE__, 'k3e_disable_posts_deactivate');
