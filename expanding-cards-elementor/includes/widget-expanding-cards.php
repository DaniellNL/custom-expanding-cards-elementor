<?php

if (!defined('ABSPATH')) {
    exit;
}

class Expanding_Cards_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'expanding-cards';
    }

    public function get_title() {
        return __('Expanding Cards', 'expanding-cards');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Cards', 'expanding-cards'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cards',
            [
                'label' => __('Vrijwilligers', 'expanding-cards'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => __('Afbeelding', 'expanding-cards'),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                    ],
                    [
                        'name' => 'title',
                        'label' => __('Titel', 'expanding-cards'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Naam', 'expanding-cards'),
                    ],
                    [
                        'name' => 'role',
                        'label' => __('Rol', 'expanding-cards'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Vrijwilliger', 'expanding-cards'),
                    ],
                    [
                        'name' => 'description',
                        'label' => __('Beschrijving', 'expanding-cards'),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => __('Meer info over de vrijwilliger...', 'expanding-cards'),
                    ]
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['cards'])) {
            echo '<div class="expanding-card-container">';
            foreach ($settings['cards'] as $index => $card) {
                echo '<div class="expanding-card" data-index="' . esc_attr($index) . '">';
                echo '<div class="card-header">';
                echo '<img src="' . esc_url($card['image']['url']) . '" alt="' . esc_attr($card['title']) . '">';
                echo '<h3>' . esc_html($card['title']) . '</h3>';
                echo '<p>' . esc_html($card['role']) . '</p>';
                echo '</div>';
                echo '<div class="expanding-card-content">';
                echo '<button class="close-btn">&times;</button>';
                echo '<p>' . esc_html($card['description']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    }
}