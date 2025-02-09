<?php
/**
 * Plugin Name: Expanding Cards for Elementor
 * Description: Een uitbreidbare cards widget voor Elementor.
 * Version: 0.1
 * Author: Daniël
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Elementor widget laden
function register_expanding_cards_widget($widgets_manager) {
    require_once(__DIR__ . '/includes/widget-expanding-cards.php');
    $widgets_manager->register(new \Expanding_Cards_Widget());
}
add_action('elementor/widgets/register', 'register_expanding_cards_widget');

// Stijlen en scripts laden
function expanding_cards_enqueue_scripts() {
    wp_enqueue_style('expanding-cards-style', plugins_url('/assets/style.css', __FILE__));
    wp_enqueue_script('expanding-cards-script', plugins_url('/assets/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'expanding_cards_enqueue_scripts');