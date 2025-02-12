<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Elementor_Volunteer_Grid_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'volunteer_grid';
    }

    public function get_title()
    {
        return __('Volunteer Grid', 'plugin-name');
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater control for multiple volunteers
        $repeater = new \Elementor\Repeater();

        // Name
        $repeater->add_control(
            'name',
            [
                'label' => __('Name', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('John Doe', 'plugin-name'),
            ]
        );

        // Role
        $repeater->add_control(
            'role',
            [
                'label' => __('Role', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Volunteer', 'plugin-name'),
            ]
        );

        // Image
        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default'   => [
                    'url' => '\Elementor\Utils::get_placeholder_image_src()',
                ],
            ]
        );

        // Description
        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet.', 'plugin-name'),
            ]
        );

        $this->add_control(
            'volunteers',
            [
                'label' => __('Volunteers', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();

        echo '<div class="volunteer-grid">';

        if (!empty($settings['volunteers'])) {
            foreach ($settings['volunteers'] as $volunteer) {
                // If alt text is not set in the media, fallback to empty string
                $alt_text = isset($volunteer['image']['alt']) ? $volunteer['image']['alt'] : '';
                $img_url = isset($volunteer['image']['url']) ? $volunteer['image']['url'] : '';

                // Volunteer card
                echo '<div class="volunteer-card" data-description="' . esc_attr($volunteer['description']) . '">';

                // Image
                if ($img_url) {
                    echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($alt_text) . '" />';
                }

                // Name
                echo '<h3>' . esc_html($volunteer['name']) . '</h3>';

                // Role
                echo '<p class="volunteer-role">' . esc_html($volunteer['role']) . '</p>';

                echo '</div>'; // .volunteer-card
            }
        }

        // Container for dynamically loaded description
        echo '<div class="volunteer-description"></div>';
        echo '</div>'; // .volunteer-grid
    }
}
