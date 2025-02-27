<?php

/**
 * Plugin Name: Elementor Volunteer Grid
 * Description: A custom Elementor widget that displays a grid of volunteer cards with expandable descriptions.
 * Version: 0.9.0
 * Author: Daniël
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Register the custom Elementor widget
function register_volunteer_grid_widget($widgets_manager)
{
    require_once plugin_dir_path(__FILE__) . '/widgets/volunteer-grid-widget.php';
    $widgets_manager->register_widget_type(new \Elementor_Volunteer_Grid_Widget());
}
add_action('elementor/widgets/register', 'register_volunteer_grid_widget');

// Register widget scripts and styles
function volunteer_grid_enqueue_scripts()
{
    wp_enqueue_style('volunteer-grid-style', plugins_url('/assets/css/style.css', __FILE__));
    wp_enqueue_script('volunteer-grid-script', plugins_url('/assets/js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'volunteer_grid_enqueue_scripts');
