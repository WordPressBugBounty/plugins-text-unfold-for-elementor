<?php

/**
 * Widget Text Unfold For Elementor
 * @fullstackwp
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;

class FSWP_ELT_text_unfold extends Widget_Base
{
    /**
     * Get widget name.
     * 
     * @since 1.0.0
     * */
    public function get_name()
    {
        return 'fswp-text-unfold';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * */
    public function get_title()
    {
        return esc_html__('Text Unfold', 'text-unfold');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * */
    public function get_icon()
    {
        return 'eicon-page-transition';
    }

    /**
     * Get widget categories.
     * 
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     * */
    public function get_categories()
    {
        return ['fswp-widget'];
    }

    /**
     * Get widget keywords.
     *
     * @since 1.0.0
     * */
    public function get_keywords()
    {
        return ['text unfold', 'read more', 'read less', 'text expand', 'text collapse'];
    }

    /**
     * Get widget styles.
     * 
     * @since 1.0.0
     * @access public
     * @return array Widget styles.
     * */
    public function get_style_depends()
    {
        return ['fswp-elt-text-unfold-style'];
    }

    /**
     * Get widget scripts.
     * 
     * @since 1.0.0
     * @access public
     * @return array Widget scripts.
     * */
    public function get_script_depends()
    {
        return ['fswp-elt-text-unfold-script'];
    }

    /**
     * Register widget controls.
     * 
     * @since 1.0.0
     * @access protected
     * @return void
     * */
    protected function register_controls()
    {
        $this->register_widget_control();
        $this->register_image_control();
        $this->register_title_control();
        $this->register_content_control();
        $this->register_read_more_control();
        $this->register_read_more_icon_control();
    }

    /**
     * Render widget output on the frontend.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-main-wrapper'); ?>">
            <?php
            if ($settings['include_image'] == 'yes' && $settings['read_more_image']['url']) :
                $this->render_read_more_image($settings);
            endif;
            if ($settings['title']) :
                $this->render_read_more_title($settings);
            endif;
            $this->render_read_more_content($settings);
            ?>
        </div>
    <?php
    }

    /**
     * Register Widget controls.
     *
     * @since 1.0.0
     * @access private
     */
    private function register_widget_control()
    {
        /* Read More Section in Content Tab Starts */
        $this->start_controls_section(
            'read_more_content_section',
            [
                'label' => esc_html__('Content', 'text-unfold'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'include_image',
            [
                'label'        => esc_html__('Include Image?', 'text-unfold'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'text-unfold'),
                'label_off'    => esc_html__('No', 'text-unfold'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'read_more_image',
            [
                'label'   => esc_html__('Image', 'text-unfold'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'include_image' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => esc_html__('Title', 'text-unfold'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Lorem Ipsum', 'text-unfold'),
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_control(
            'include_read_more',
            [
                'label'            => esc_html__('Include Read More?', 'text-unfold'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'text-unfold'),
                'label_off'    => esc_html__('No', 'text-unfold'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'height',
            [
                'label'     => esc_html__('Container Height', 'text-unfold'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-content' => 'height:{{SIZE}}px'
                ],
                'default' => [
                    'size' => 100,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'condition' => [
                    'include_read_more' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'       => esc_html__('Read More Text', 'text-unfold'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Read More', 'text-unfold'),
                'condition'   => [
                    'include_read_more' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'read_less_text',
            [
                'label'       => esc_html__('Read Less Text', 'text-unfold'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Read Less', 'text-unfold'),
                'condition'   => [
                    'include_read_more' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'include_icon',
            [
                'label'        => esc_html__('Include Icon?', 'text-unfold'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'text-unfold'),
                'label_off'    => esc_html__('No', 'text-unfold'),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'   => [
                    'include_read_more' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'read_more_icon',
            [
                'label' => esc_html__('Read More Icon', 'text-unfold'),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'include_read_more' => 'yes',
                    'include_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'read_less_icon',
            [
                'label' => esc_html__('Read Less Icon', 'text-unfold'),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-up',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'include_read_more' => 'yes',
                    'include_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'full_content',
            [
                'label'   => esc_html__('Full Content', 'text-unfold'),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ut suscipit justo. Etiam in neque et leo mattis venenatis. Integer tortor mauris, fringilla nec felis ac, volutpat maximus dui. Praesent vel leo nunc. Duis a est orci. Donec vitae odio id justo finibus bibendum nec in est. Duis sed fermentum enim. Donec blandit pulvinar bibendum. Sed pellentesque blandit turpis pulvinar consectetur. Curabitur mattis mollis justo, non venenatis neque mollis at. Phasellus vestibulum ornare turpis non efficitur. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi fringilla tellus et turpis sagittis aliquam. Duis lacinia bibendum nulla, in ultricies diam bibendum quis. Mauris interdum metus venenatis dui tristique auctor.',
                'dynamic' => ['active' => true],
            ]
        );

        /* Read More Section in Content Tab Ends */
        $this->end_controls_section();
    }

    /**
     * Register Image controls.
     *
     * @since 1.0.0
     * @access private
     */
    private function register_image_control()
    {
        /* Image Section in Style Tab Starts */
        $this->start_controls_section(
            'image_style_section',
            [
                'label'     => esc_html__('Image', 'text-unfold'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'include_image' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'       => esc_html__('Image Padding', 'text-unfold'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => ['px', '%', 'em', 'rem', 'custom'],
                'device'      => ['desktop', 'tablet', 'mobile'],
                'selectors'   => [
                    '{{WRAPPER}} .fswp-elt--read-more-image-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'       => esc_html__('Image Margin', 'text-unfold'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => ['px', '%', 'em', 'rem', 'custom'],
                'device'      => ['desktop', 'tablet', 'mobile'],
                'selectors'   => [
                    '{{WRAPPER}} .fswp-elt--read-more-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_responsive_control(
            'read_more_image_width',
            [
                'label' => esc_html__('Width', 'text-unfold'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-image-wrapper img' => 'width:{{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => '%',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_image_height',
            [
                'label' => esc_html__('Height', 'text-unfold'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-image-wrapper img' => 'height:{{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_image_alignment',
            [
                'label'       => esc_html__('Image Alignment', 'text-unfold'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left' => [
                        'title' => esc_html__('Left', 'text-unfold'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'text-unfold'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'text-unfold'),
                        'icon'  => 'eicon-text-align-right'
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-image-wrapper' => 'text-align:{{VALUE}}'
                ],
            ]

        );

        /* Image Section in Style Tab Ends */
        $this->end_controls_section();
    }

    /**
     * Register Widget Title controls.
     *
     * @since 1.0.0
     * @access private
     */
    private function register_title_control()
    {
        /* Title Section in Style Tab Starts */
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'text-unfold'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'       => esc_html__('Title Color', 'text-unfold'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .fswp-elt--read-more-title-wrapper .fswp-elt--read-more-title' => 'color:{{VALUE}}'
                ]
            ],
        );

        $this->add_control(
            'read_more_title_tag',
            [
                'label'       => esc_html__('Title Tag', 'text-unfold'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default'     => 'h3',
            ],
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Title Typography', 'text-unfold'),
                'selector' => '{{WRAPPER}} .fswp-elt--read-more-title-wrapper .fswp-elt--read-more-title'
            ],
        );

        $this->add_responsive_control(
            'title_alignment',
            [
                'label'       => esc_html__('Title Alignment', 'text-unfold'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left' => [
                        'title' => esc_html__('Left', 'text-unfold'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'text-unfold'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'text-unfold'),
                        'icon'  => 'eicon-text-align-right'
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-title-wrapper ' => 'text-align: {{VALUE}};',
                ],
            ],
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label'           => esc_html__('Title Padding', 'text-unfold'),
                'type'            => Controls_Manager::DIMENSIONS,
                'size_units'      => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'       => esc_html__('Title Margin', 'text-unfold'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => ['px', '%', 'em', 'rem', 'custom'],
                'selectors'   => [
                    '{{WRAPPER}} .fswp-elt--read-more-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        /* Title Section in Style Tab Starts */
        $this->end_controls_section();
    }

    /**
     * Register Widget Content controls.
     *
     * @since 1.0.0
     * @access private
     */
    private function register_content_control()
    {
        /* Content Section in Style Tab Starts */
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'text-unfold'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ],
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'       => esc_html__('Content Padding', 'text-unfold'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => ['px', '%', 'em', 'rem', 'custom'],
                'selectors'   => [
                    '{{WRAPPER}} .fswp-elt--read-more-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'       => esc_html__('Content Margin', 'text-unfold'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top'    => 10,
                    'bottom' => 10,
                    'unit'   => 'px'
                ],
                'selectors'   => [
                    '{{WRAPPER}} .fswp-elt--read-more-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_control(
            'content_color',
            [
                'label'       => esc_html__('Content Color', 'text-unfold'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .fswp-elt--read-more-content' => 'color:{{VALUE}}'
                ]
            ],
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'label'    => esc_html__('Content Typography', 'text-unfold'),
                'selector' => '{{WRAPPER}} .fswp-elt--read-more-content'
            ],
        );

        $this->add_responsive_control(
            'content_alignment',
            [
                'label'       => esc_html__('Alignment', 'text-unfold'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left' => [
                        'title' => esc_html__('Left', 'text-unfold'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'text-unfold'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'text-unfold'),
                        'icon'  => 'eicon-text-align-right'
                    ],
                    'justify' => [
                        'title' => esc_html__('justify', 'text-unfold'),
                        'icon'  => 'eicon-text-align-justify'
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-content' => 'text-align: {{VALUE}};',
                ],

            ],
        );

        /* Post Content Section in Style Tab Starts */
        $this->end_controls_section();
    }

    /**
     * Register Widget Read More controls.
     *
     * @since 1.0.0
     * @access private
     */
    private function register_read_more_control()
    {
        /* Read More Section in Style Tab Starts */
        $this->start_controls_section(
            'read_more_style',
            [
                'label' => esc_html__('Read More', 'text-unfold'),
                'tab' => Controls_Manager::TAB_STYLE,
            ],
        );

        $this->add_responsive_control(
            'read_more_padding',
            [
                'label'      => esc_html__('Read More Padding', 'text-unfold'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors'  => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
                'separator' => 'before',
            ],
        );

        $this->add_responsive_control(
            'read_more_margin',
            [
                'label'     => esc_html__('Read More Margin', 'text-unfold'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],

                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]

            ],
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'read_more_typography',
                'label'    => esc_html__('Read More Typography', 'text-unfold'),
                'selector' => '{{WRAPPER}} .fswp-elt--read-more .fswp-elt--read-more-text',
            ],

        );

        $this->add_responsive_control(
            'read_more_border',
            [
                'label'   => esc_html__('Read More Border', 'text-unfold'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'solid'  => esc_html__('Solid', 'text-unfold'),
                    'double' => esc_html__('Double', 'text-unfold'),
                    'dotted' => esc_html__('Dotted', 'text-unfold'),
                    'dashed' => esc_html__('Dashed', 'text-unfold'),
                    'groove' => esc_html__('Groove', 'text-unfold'),
                    'ridge'  => esc_html__('Ridge', 'text-unfold'),
                    'none'   => esc_html__('None', 'text-unfold')
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'border-style:{{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'read_more_border_width',
            [
                'label'      => esc_html__('Read More Border Width', 'text-unfold'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'border-width:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
                'condition'  => [
                    'read_more_border!' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'read_more_border_radius',
            [
                'label'      => esc_html__('Read More Border Radius', 'text-unfold'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
            ]
        );

        $this->start_controls_tabs('read_more_color_tabs');

        $this->start_controls_tab(
            'read_more_normal_tab',
            [
                'label' => esc_html__('Normal', 'text-unfold'),
            ],
        );

        $this->add_control(
            'read_more_normal_background_color',
            [
                'label'     => esc_html__('Background Color', 'text-unfold'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'background-color:{{VALUE}}'
                ],
            ],

        );

        $this->add_control(
            'read_more_normal_color',
            [
                'label'     => esc_html__('Color', 'text-unfold'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'color:{{VALUE}}',
                ],
            ],

        );

        $this->add_control(
            'read_more_normal_border_color',
            [
                'label'     => esc_html__('Border Color', 'text-unfold'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more' => 'border-color:{{VALUE}}'
                ],
                'condition'  => [
                    'read_more_border!' => 'none'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'read_more_hover_tab',
            [
                'label'     => esc_html__('Hover', 'text-unfold'),
            ],
        );

        $this->add_control(
            'read_more_hover_background_color',
            [
                'label'     => esc_html__('Background Color', 'text-unfold'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more:hover' => 'background-color:{{VALUE}}',
                ],
            ],
        );

        $this->add_control(
            'read_more_hover_color',
            [
                'label'     => esc_html__('Color', 'text-unfold'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more:hover' => 'color:{{VALUE}}',

                ],
            ],
        );

        $this->add_control(
            'read_more_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'text-unfold'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more:hover' => 'border-color:{{VALUE}}'
                ],
                'condition'  => [
                    'read_more_border!' => 'none'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        /* Read More Section in Style Tab Ends */
        $this->end_controls_section();
    }

    /**
     * Register Widget Read More Icon controls.
     *
     * @since 1.0.0
     * @access private
     */
    private function register_read_more_icon_control()
    {
        /* Icon Section in Style Tab Starts */

        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon', 'text-unfold'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition'   => [
                    'include_read_more' => 'yes',
                    'include_icon' => 'yes'
                ]
            ],
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Icon Size', 'text-unfold'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-icon i'   => 'font-size:{{SIZE}}px',
                    '{{WRAPPER}} .fswp-elt--read-more-icon svg' => 'height:{{SIZE}}px; width:{{SIZE}}px',
                ],
                'default'   => [
                    'size' => 20
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_gap',
            [
                'label'     => esc_html__('Icon Gap', 'text-unfold'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more'   => 'gap:{{SIZE}}px',
                ],
                'default'   => [
                    'size' => 2
                ],
                'range' => [
                    'px' => [
                        'max' => 20
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_position',
            [
                'label'     => esc_html__('Icon Position', 'text-unfold'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-icon i'   => 'margin-top:{{SIZE}}px',
                    '{{WRAPPER}} .fswp-elt--read-more-icon svg' => 'margin-top:{{SIZE}}px',
                ],
            ]
        );



        $this->start_controls_tabs('icon_color_tabs');

        $this->start_controls_tab(
            'icon_normal_tab',
            [
                'label' => esc_html__('Normal', 'text-unfold'),
            ],
        );

        $this->add_control(
            'icon_normal_color',
            [
                'label'     => esc_html__('Icon Color', 'text-unfold'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more-icon'          => 'color:{{VALUE}}',
                    '{{WRAPPER}} .fswp-elt--read-more-icon svg path' => 'fill:{{VALUE}}',
                ],
            ],

        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_hover_tab',
            [
                'label'     => esc_html__('Hover', 'text-unfold'),
            ],
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label'     => esc_html__('Color', 'text-unfold'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fswp-elt--read-more:hover .fswp-elt--read-more-icon'          => 'color:{{VALUE}}',
                    '{{WRAPPER}} .fswp-elt--read-more:hover .fswp-elt--read-more-icon svg path' => 'fill:{{VALUE}}',

                ],
            ],
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        /* Read More Section in Style Tab Ends */
        $this->end_controls_section();
    }


    /**
     * Render Read More Image on the frontend.
     *
     * @since 1.0.0
     * @access private
     */
    private function render_read_more_image($settings)
    {
    ?>
        <div class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-image-wrapper'); ?>">
            <img src="<?php echo esc_url($settings['read_more_image']['url']); ?>" />

        </div><!--read-more-image-wrapper-->
    <?php
    }

    /**
     * Render Read More Title on the frontend.
     *
     * @since 1.0.0
     * @access private
     */
    private function render_read_more_title($settings)
    {
    ?>
        <div class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-title-wrapper'); ?>">
            <?php
            echo '<' . fswp_validate_heading_tag($settings['read_more_title_tag']) . ' class="' . esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-title') . '">' . esc_html($settings['title']) . '</' . fswp_validate_heading_tag($settings['read_more_title_tag']) . '>';
            ?>
        </div><!--read-more-title-wrapper-->
    <?php
    }

    /**
     * Render Read More Content on the frontend.
     *
     * @since 1.0.0
     * @access private
     */
    private function render_read_more_content($settings)
    {
    ?>
        <div class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-content-wrapper'); ?>">
            <?php
            if (!empty($settings['full_content'])) :
            ?>
                <div class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-content'); ?>">
                    <?php echo wp_kses_post($settings['full_content']); ?>
                </div>
                <?php
                if (!empty($settings['include_read_more']) && $settings['include_read_more'] === 'yes') :
                    $height    = isset($settings['height']['size']) ? $settings['height']['size'] : 100;
                    $show_icon = !empty($settings['include_icon']) && $settings['include_icon'] === 'yes' ? 'show-icon' : 'hide-icon';
                ?>
                    <a class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more more ') . esc_attr($show_icon); ?>"
                        data-height="<?php echo esc_attr($height); ?>"
                        data-more="<?php echo esc_attr($settings['read_more_text'] ?? 'Read More'); ?>"
                        data-less="<?php echo esc_attr($settings['read_less_text'] ?? 'Read Less'); ?>">
                        <span class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-text'); ?>">
                            <?php echo esc_html($settings['read_more_text'] ?? 'Read More'); ?>
                        </span>
                        <?php if (!empty($settings['include_icon']) && !empty($settings['read_more_icon']['value'])) : ?>
                            <span class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-icon ') . 'more'; ?>">
                                <?php \Elementor\Icons_Manager::render_icon($settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($settings['include_icon']) && !empty($settings['read_less_icon']['value'])) : ?>
                            <span class="<?php echo esc_attr(FSWP_ELT_CLASS_PREFIX . 'read-more-icon ') . 'less'; ?>">
                                <?php \Elementor\Icons_Manager::render_icon($settings['read_less_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                        <?php endif; ?>
                    </a>
            <?php
                endif;
            endif;
            ?>
        </div><!--read-more-content-wrapper-->
<?php
    }
}
