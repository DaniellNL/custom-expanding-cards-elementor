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

        $this->add_control(
            'volunteers',
            [
                'label' => __('Volunteers', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => __('Name', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('John Doe', 'plugin-name'),
                    ],
                    [
                        'name' => 'image',
                        'label' => __('Image', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                    ],
                    [
                        'name' => 'description',
                        'label' => __('Description', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                    ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        echo '<div class="volunteer-grid">';
        foreach ($settings['volunteers'] as $volunteer) {
            echo '<div class="volunteer-card" data-description="' . esc_attr($volunteer['description']) . '">
                    <img src="' . esc_url($volunteer['image']['url']) . '" alt="' . esc_attr($volunteer['name']) . '">
                    <h3>' . esc_html($volunteer['name']) . '</h3>
                  </div>';
        }
        echo '<div class="volunteer-description"></div></div>';
    }
}
