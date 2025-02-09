<?php
/**
 * Plugin Name: Expandable Team Cards
 * Description: Creates expandable team member cards with Elementor integration
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

class ExpandableTeamCards {
    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'register_widget']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function register_widget($widgets_manager) {
        require_once(__DIR__ . '/widgets/team-cards-widget.php');
        $widgets_manager->register(new \TeamCardsWidget());
    }

    public function enqueue_scripts() {
        wp_enqueue_style(
            'expandable-team-cards',
            plugins_url('assets/css/style.css', __FILE__),
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'expandable-team-cards',
            plugins_url('assets/js/script.js', __FILE__),
            ['jquery'],
            '1.0.0',
            true
        );
    }
}

new ExpandableTeamCards();