<?php
class TeamCardsWidget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'team_cards';
    }

    public function get_title() {
        return 'Team Cards';
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Content',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'name',
            [
                'label' => 'Name',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Team Member Name',
            ]
        );

        $repeater->add_control(
            'role',
            [
                'label' => 'Role',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Role',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Team member description goes here...',
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => 'Image',
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => 'Team Members',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => 'Card Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .team-card',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .team-card',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="team-cards-container">
            <?php foreach ($settings['team_members'] as $member) : ?>
                <div class="team-card" data-name="<?php echo esc_attr($member['name']); ?>">
                    <div class="team-card-inner">
                        <div class="team-card-front">
                            <?php if ($member['image']['url']) : ?>
                                <div class="team-member-image">
                                    <img src="<?php echo esc_url($member['image']['url']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                                </div>
                            <?php endif; ?>
                            <h3 class="team-member-name"><?php echo esc_html($member['name']); ?></h3>
                            <p class="team-member-role"><?php echo esc_html($member['role']); ?></p>
                            <div class="expand-preview">
                                <span class="preview-text"><?php echo wp_trim_words($member['description'], 10); ?></span>
                                <span class="expand-icon">↓</span>
                            </div>
                        </div>
                        <div class="team-card-expanded">
                            <div class="expanded-content">
                                <button class="close-expanded">×</button>
                                <div class="expanded-description">
                                    <?php echo wp_kses_post($member['description']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}