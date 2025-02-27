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
        #region content
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

        $this->start_controls_section(
            'section_layout_settings',
            [
                'label' => __('Layout Settings', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        /**
         * 1) RESPONSIVE MAX COLUMNS (FLEX)
         *
         * We'll do a responsive slider for columns:
         * - Desktop default: 4
         * - Tablet default: 2
         * - Mobile default: 1
         */
        $this->add_responsive_control(
            'max_columns',
            [
                'label'   => __('Max Columns per Row', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::SLIDER,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'range'   => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 4, // e.g., 4 columns on desktop by default
                ],
                'tablet_default' => [
                    'size' => 2, // columns on tablet
                ],
                'mobile_default' => [
                    'size' => 1, // columns on mobile
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-grid' => '--vol-cols: {{SIZE}};',
                    /*'(tablet){{WRAPPER}} .volunteer-grid'  => '--vol-cols: {{SIZE}};',
                    '(mobile){{WRAPPER}} .volunteer-grid'  => '--vol-cols: {{SIZE}};',*/
                ],
            ]
        );

        /**
         * 2) RESPONSIVE GAP (FLEX GAP)
         */
        $this->add_responsive_control(
            'card_gap',
            [
                'label'      => __('Gap Between Cards', 'plugin-name'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .volunteer-grid' => '--vol-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /**
         * 3) RESPONSIVE CARD MINIMUM HEIGHT
         */
        $this->add_responsive_control(
            'card_min_height',
            [
                'label'      => __('Card Min Height', 'plugin-name'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'vh'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 1000],
                    'em' => ['min' => 0, 'max' => 50],
                    'vh' => ['min' => 0, 'max' => 100],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /**
         * 4) VOLUNTEER ROLE HTML TAG DROPDOWN
         */
        $this->add_control(
            'volunteer_role_tag',
            [
                'label'   => __('Volunteer Role HTML Tag', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'div' => 'DIV',
                    'span' => 'SPAN',
                    'p'    => 'P',
                    // etc. Add any tags you want to support
                ],
                'default' => 'p',
            ]
        );

        /**
         * 5) VOLUNTEER NAME HTML TAG DROPDOWN
         */
        $this->add_control(
            'volunteer_name_tag',
            [
                'label'   => __('Volunteer Name HTML Tag', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1'  => 'H1',
                    'h2'  => 'H2',
                    'h3'  => 'H3',
                    'h4'  => 'H4',
                    'h5'  => 'H5',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                    // etc.
                ],
                'default' => 'h3',
            ]
        );

        $this->end_controls_section(); // End Layout Settings

        $this->start_controls_section(
            'section_card_layout',
            [
                'label' => __('Card Layout', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'vertical_alignment',
            [
                'label'   => __('Vertical Alignment (Text)', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Top', 'plugin-name'),
                        'icon'  => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => __('Center', 'plugin-name'),
                        'icon'  => 'eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => __('Bottom', 'plugin-name'),
                        'icon'  => 'eicon-align-end-v',
                    ],
                    'space-between' => [
                        'title' => __('Space between', 'plugin name'),
                        'icon'  => 'eicon-justify-space-between-v',

                    ],
                    'stretch' => [
                        'title' => __('Stretch', 'plugin name'),
                        'icon'  => 'eicon-align-stretch-v',

                    ]
                ],
                'default' => 'flex-start',
                'selectors' => [
                    /*
                      We apply it to .volunteer-body
                      so only the text is realigned, 
                      and the image stays at the top in .volunteer-image-wrapper.
                    */
                    '{{WRAPPER}} .volunteer-body' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        #endregion
        #region style tab

        #region card section
        /**
         * ──────────────────────────────────────────────────────────────────
         * 2. CARD SECTION (STYLE TAB)
         * ──────────────────────────────────────────────────────────────────
         */

        $this->start_controls_section(
            'section_card_style',
            [
                'label' => __('Card', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_card_state');
        #region normal
        // NORMAL TAB
        $this->start_controls_tab(
            'tab_card_normal',
            ['label' => __('Normal', 'plugin-name')]
        );
        $this->add_control(
            'card_normal_background',
            [
                'label'     => __('Background Color', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_normal_margin',
            [
                'label' => __('Margin', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'card_normal_padding',
            [
                'label' => __('Padding', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        // Border Radius
        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .volunteer-card',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .volunteer-card',
            ]
        );

        $this->add_control(
            'card_normal_arrow',
            [
                'label'     => __('Arrow color', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card::after' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );



        // Add more Normal-state controls here (padding, border, etc.)
        $this->end_controls_tab(); // End of Normal tab
        #endregion

        #region card hover
        /** 
         * 1) HOVER TAB 
         */
        $this->start_controls_tab(
            'tab_card_hover',
            ['label' => __('Hover', 'plugin-name')]
        );

        $this->add_control(
            'card_hover_background',
            [
                'label' => __('Background Color (Hover)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'card_hover_border',
                'label'    => __('Border (Hover)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_hover_box_shadow',
                'label'    => __('Box Shadow (Hover)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card:hover',
            ]
        );

        // Transition duration for hover
        $this->add_control(
            'card_hover_transition',
            [
                'label' => __('Transition Duration (Hover)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 3, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    // Apply transition on the base card so it transitions on hover
                    '{{WRAPPER}} .volunteer-card' => 'transition: all {{SIZE}}s ease-in-out;',
                ],
            ]
        );

        // Scale for hover
        $this->add_responsive_control(
            'card_hover_scale',
            [
                'label' => __('Scale (Hover)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.5, 'max' => 2, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 1.1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card:hover' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab(); // END HOVER TAB

        #endregion

        #region card focus
        /** 
         * 2) FOCUS TAB 
         */
        $this->start_controls_tab(
            'tab_card_focus',
            ['label' => __('Focus', 'plugin-name')]
        );

        $this->add_control(
            'card_focus_background',
            [
                'label' => __('Background Color (Focus)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'card_focus_border',
                'label'    => __('Border (Focus)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card:focus',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_focus_box_shadow',
                'label'    => __('Box Shadow (Focus)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card:focus',
            ]
        );

        // Transition for focus
        $this->add_control(
            'card_focus_transition',
            [
                'label' => __('Transition Duration (Focus)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 3, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'transition: all {{SIZE}}s ease-in-out;',
                ],
            ]
        );

        // Scale for focus
        $this->add_responsive_control(
            'card_focus_scale',
            [
                'label' => __('Scale (Focus)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.5, 'max' => 2, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card:focus' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab(); // END FOCUS TAB

        #endregion

        #region card active
        /** 
         * 3) ACTIVE (OPENED) TAB 
         */
        $this->start_controls_tab(
            'tab_card_active',
            ['label' => __('Active', 'plugin-name')]
        );

        $this->add_control(
            'card_active_background',
            [
                'label' => __('Background Color (Active)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card.active-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'card_active_border',
                'label'    => __('Border (Active)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card.active-card',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_active_box_shadow',
                'label'    => __('Box Shadow (Active)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card.active-card',
            ]
        );

        // Transition for active
        $this->add_control(
            'card_active_transition',
            [
                'label' => __('Transition Duration (Active)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 3, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'transition: all {{SIZE}}s ease-in-out;',
                ],
            ]
        );

        // Scale for active
        $this->add_responsive_control(
            'card_active_scale',
            [
                'label' => __('Scale (Active)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.5, 'max' => 2, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card.active-card' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab(); // END ACTIVE TAB
        #endregion

        #region card inactive

        /** 
         * 4) INACTIVE (GREYED-OUT) TAB 
         */
        $this->start_controls_tab(
            'tab_card_inactive',
            ['label' => __('Inactive', 'plugin-name')]
        );

        $this->add_control(
            'card_inactive_background',
            [
                'label' => __('Background Color (Inactive)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card.greyed-out' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'card_inactive_border',
                'label'    => __('Border (Inactive)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card.greyed-out',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_inactive_box_shadow',
                'label'    => __('Box Shadow (Inactive)', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card.greyed-out',
            ]
        );

        // Opacity slider

        $this->add_control(
            'card_inactive_opacity',
            [
                'label' => __('Opacity (Inactive)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01],
                ],
                'default' => [
                    'size' => 0.6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card.greyed-out' => 'opacity: {{SIZE}}',
                ],
            ]
        );

        $this->add_control(
            'card_inactive_hover_opacity',
            [
                'label' => __('Hover opacity (Inactive)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.01],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card.greyed-out:hover' => 'opacity: {{SIZE}}',
                ],
            ]
        );

        // Transition for inactive
        $this->add_control(
            'card_inactive_transition',
            [
                'label' => __('Transition Duration (Inactive)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 3, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card' => 'transition: all {{SIZE}}s ease-in-out;',
                ],
            ]
        );

        // Scale for inactive
        $this->add_responsive_control(
            'card_inactive_scale',
            [
                'label' => __('Scale (Inactive)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.5, 'max' => 2, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card.greyed-out' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab(); // END INACTIVE TAB
        #endregion

        $this->end_controls_tabs(); // End \"tabs_card_state\"

        $this->end_controls_section(); // End card style section
        #endregion

        #region image section
        /**
         * ──────────────────────────────────────────────────────────────────
         * 3. VOLUNTEER IMAGE SECTION (STYLE)
         * ──────────────────────────────────────────────────────────────────
         */

        $this->start_controls_section(
            'section_image_style',
            [
                'label' => __('Volunteer Image', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // ────────────────────────────────────────────────────────────────
        // NORMAL, HOVER, FOCUS TABS FOR IMAGE
        // ────────────────────────────────────────────────────────────────
        $this->start_controls_tabs('tabs_image_style');

        // ---------------------------------------------------------------
        // NORMAL TAB
        // ---------------------------------------------------------------
        $this->start_controls_tab(
            'tab_image_normal',
            [
                'label' => __('Normal', 'plugin-name'),
            ]
        );

        // Image Height
        $this->add_responsive_control(
            'image_height',
            [
                'label' => __('Image Height', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1000],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Object Fit (cover, contain, fill, etc.)
        $this->add_control(
            'image_object_fit',
            [
                'label' => __('Image Fit', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'fill'    => __('Fill', 'plugin-name'),
                    'contain' => __('Contain', 'plugin-name'),
                    'cover'   => __('Cover', 'plugin-name'),
                    'none'    => __('None', 'plugin-name'),
                    'scale-down' => __('Scale Down', 'plugin-name'),
                ],
                'default' => 'cover',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        // Object Position
        $this->add_control(
            'image_object_position',
            [
                'label' => __('Image Position', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'left top'      => __('Left Top', 'plugin-name'),
                    'center top'    => __('Center Top', 'plugin-name'),
                    'right top'     => __('Right Top', 'plugin-name'),
                    'left center'   => __('Left Center', 'plugin-name'),
                    'center center' => __('Center Center', 'plugin-name'),
                    'right center'  => __('Right Center', 'plugin-name'),
                    'left bottom'   => __('Left Bottom', 'plugin-name'),
                    'center bottom' => __('Center Bottom', 'plugin-name'),
                    'right bottom'  => __('Right Bottom', 'plugin-name'),
                ],
                'default' => '50% 50%',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper img' => 'object-position: {{VALUE}};',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'image_padding',
            [
                'label' => __('Image Padding', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // CSS Filters
        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters',
                'selector' => '{{WRAPPER}} .volunteer-image-wrapper img',
            ]
        );

        // Transition Duration
        $this->add_control(
            'image_transition_normal',
            [
                'label' => __('Transition Duration', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.3],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper img' => 'transition: transform {{SIZE}}s ease-in-out, filter {{SIZE}}s ease-in-out;',
                ],
            ]
        );

        // Scale (Normal) - Usually you want scale=1, but giving the option
        $this->add_control(
            'image_scale_normal',
            [
                'label' => __('Scale (Normal)', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.5, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab(); // END NORMAL TAB

        // ---------------------------------------------------------------
        // HOVER TAB
        // ---------------------------------------------------------------
        $this->start_controls_tab(
            'tab_image_hover',
            [
                'label' => __('Hover', 'plugin-name'),
            ]
        );

        // CSS Filters on Hover
        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'image_css_filters_hover',
                'selector' => '{{WRAPPER}} .volunteer-image-wrapper img:hover',
            ]
        );

        // Scale on Hover
        $this->add_control(
            'image_scale_hover',
            [
                'label' => __('Scale (Hover)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.5, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card:hover .volunteer-image-wrapper img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        // If you want a separate transition time for hover, you can do it
        // by applying transitions to img:hover, but typically the base
        // transition is enough.

        $this->end_controls_tab(); // END HOVER TAB

        // ---------------------------------------------------------------
        // FOCUS TAB
        // ---------------------------------------------------------------
        $this->start_controls_tab(
            'tab_image_focus',
            [
                'label' => __('Focus', 'plugin-name'),
            ]
        );

        // CSS Filters on Focus
        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'image_css_filters_focus',
                'selector' => '{{WRAPPER}} .volunteer-image-wrapper img:focus',
            ]
        );

        // Scale on Focus
        $this->add_control(
            'image_scale_focus',
            [
                'label' => __('Scale (Focus)', 'plugin-name'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.5, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-image-wrapper img:focus' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab(); // END FOCUS TAB

        $this->end_controls_tabs(); // END TABS

        $this->end_controls_section();

        #endregion

        #region card volunteer name
        /*************************************************
         * VOLUNTEER NAME STYLE CONTROLS
         ************************************************/
        $this->start_controls_section(
            'section_volunteer_name_style',
            [
                'label' => __('Volunteer Name', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'volunteer_name_typography',
                'label'    => __('Typography', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card h3',
            ]
        );

        // Alignment
        $this->add_responsive_control(
            'volunteer_name_alignment',
            [
                'label'     => __('Alignment', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __('Left', 'plugin-name'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'plugin-name'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'plugin-name'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card h3' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Text Color
        $this->add_control(
            'volunteer_name_color',
            [
                'label'     => __('Text Color', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Spacing (Margin / Padding)
        $this->add_responsive_control(
            'volunteer_name_spacing',
            [
                'label'      => __('Spacing', 'plugin-name'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'default'    => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .volunteer-card h3' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'volunteer_name_text_shadow',
                'label'    => __('Text Shadow', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card h3',
            ]
        );

        $this->end_controls_section();
        #endregion

        #region card volunteer role

        /*************************************************
         * VOLUNTEER ROLE STYLE CONTROLS
         ************************************************/
        $this->start_controls_section(
            'section_volunteer_role_style',
            [
                'label' => __('Volunteer Role', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'volunteer_role_typography',
                'label'    => __('Typography', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card .volunteer-role',
            ]
        );

        // Alignment
        $this->add_responsive_control(
            'volunteer_role_alignment',
            [
                'label'     => __('Alignment', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __('Left', 'plugin-name'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'plugin-name'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'plugin-name'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card .volunteer-role' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Text Color
        $this->add_control(
            'volunteer_role_color',
            [
                'label'     => __('Text Color', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-card .volunteer-role' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Spacing (Margin / Padding)
        $this->add_responsive_control(
            'volunteer_role_spacing',
            [
                'label'      => __('Spacing', 'plugin-name'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'default'    => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .volunteer-card .volunteer-role' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'volunteer_role_text_shadow',
                'label'    => __('Text Shadow', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-card .volunteer-role',
            ]
        );

        $this->end_controls_section();


        #endregion

        #region card description box

        /*************************************************
         * DESCRIPTION BOX STYLE CONTROLS
         ************************************************/

        $this->start_controls_section(
            'section_description_style',
            [
                'label' => __('Description Box', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_description_state');

        // NORMAL TAB
        $this->start_controls_tab(
            'tab_description_normal',
            ['label' => __('Normal', 'plugin-name')]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => __('Typography', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-description',
            ]
        );

        // Alignment
        $this->add_responsive_control(
            'description_alignment',
            [
                'label'     => __('Alignment', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __('Left', 'plugin-name'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'plugin-name'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'plugin-name'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Text Color
        $this->add_control(
            'description_text_color',
            [
                'label'     => __('Text Color', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Close Color
        $this->add_control(
            'description_close_color_normal',
            [
                'label'     => __('Close Button Color', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .close-desc' => 'color: {{VALUE}};',
                ],
            ]
        );


        // Spacing (Padding)
        $this->add_responsive_control(
            'description_padding',
            [
                'label'      => __('Padding', 'plugin-name'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .volunteer-description' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // (Optional) Spacing (Margin)
        $this->add_responsive_control(
            'description_margin',
            [
                'label'      => __('Margin', 'plugin-name'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .volunteer-description' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'description_text_shadow',
                'label'    => __('Text Shadow', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-description',
            ]
        );

        // Border Radius
        $this->add_control(
            'description_border_radius',
            [
                'label' => __('Border Radius', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .volunteer-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border (includes border radius, size, style, color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'description_border',
                'label' => __('Border', 'plugin-name'),
                'selector' => '{{WRAPPER}} .volunteer-description',
            ]
        );

        // Background Color
        $this->add_control(
            'description_background_color',
            [
                'label'     => __('Background Color', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .volunteer-description' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab(); // End of Normal tab

        /*
        *
        *   HOVER TAB
        *
        */

        $this->start_controls_tab(
            'tab_description_hover',
            ['label' => __('Hover', 'plugin-name')]
        );

        // Close hover Color
        $this->add_control(
            'description_close_color_hover',
            [
                'label'     => __('Close Button Color (hover)', 'plugin-name'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .close-desc:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab(); // End of Hover tab

        $this->end_controls_tabs();

        $this->end_controls_section();

        #endregion

    }
    #endregion



    public function render()
    {
        $settings = $this->get_settings_for_display();

        // Unique ID for the description container
        $desc_id = 'volunteer-desc-' . $this->get_id();

        echo '<div class="volunteer-grid">';

        if (!empty($settings['volunteers'])) {
            foreach ($settings['volunteers'] as $index => $volunteer) {
                // If alt text is not set in the media, fallback to empty string
                $alt_text = isset($volunteer['image']['alt']) ? $volunteer['image']['alt'] : '';
                $img_url = isset($volunteer['image']['url']) ? $volunteer['image']['url'] : '';
                $role_tag = $settings['volunteer_role_tag'];
                $name_tag = $settings['volunteer_name_tag'];

                // Volunteer card
                echo '<div class="volunteer-card" id="volunteer-card-' . esc_attr($index) . '" role="button" tabindex="0" aria-expanded="false" aria-controls="' . esc_attr($desc_id) . '" data-description="' . esc_attr($volunteer['description']) . '">';

                echo '<div class="volunteer-image-wrapper">';
                if ($img_url) {
                    echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($alt_text) . '" />';
                }
                echo '</div>'; // .volunteer-image-wrapper

                echo '<div class="volunteer-body">';
                // Name
                echo '<' . esc_html($name_tag) . '>';
                echo esc_html($volunteer['name']);
                echo '</' . esc_html($name_tag) . '>';

                // Role
                echo '<' . esc_html($role_tag) . ' class="volunteer-role">';
                echo esc_html($volunteer['role']);
                echo '</' . esc_html($role_tag) . '>';
                echo '</div>';
                echo '</div>'; // .volunteer-card
            }
        }

        // Container for dynamically loaded description
        echo '<div class="volunteer-description" id="' . esc_attr($desc_id) . '" role="region" aria-live="polite" ></div>';
        echo '</div>'; // .volunteer-grid
    }
}
