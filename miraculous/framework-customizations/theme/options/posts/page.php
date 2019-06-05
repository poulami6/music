<?php if( !defined('FW') ) die('Forbidden');
$rev_slider = '';
if(function_exists('miraculous_revolution_slider_fun') && class_exists('RevSliderSlider')):
    $rev_slider = miraculous_revolution_slider_fun();
endif;

$options = array(
    'main' => array(
        'type' => 'box',
        'title' => __('Page Options', 'miraculous'),
        'options' => array(
            'rev_slider' => array(
                'type'  => 'select',
                'label' => esc_html__('Revolution Slider','miraculous'),
                'value' => '',
                'choices' => $rev_slider,
            ),
            'page-sidebar' => array(
                'label'   => esc_html__( 'Page Sidebar Position', 'miraculous' ),
                'type'    => 'image-picker',
                'value'   => 'right',
                'desc'    => esc_html__( 'Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.',
                    'miraculous' ),
                'choices' => array(
                    'full' => array(
                        'small' => array(
                            'height' => 50,
                            'src'    => get_template_directory_uri() . '/assets/images/1c.png'
                        ),
                    ),
                    'left' => array(
                        'small' => array(
                            'height' => 50,
                            'src'    => get_template_directory_uri() . '/assets/images/2cl.png'
                        ),
                    ),
                    'right' => array(
                        'small' => array(
                            'height' => 50,
                            'src'    => get_template_directory_uri() . '/assets/images/2cr.png'
                        ),
                    ),
                ),
            ),
            'page_breadcrumbs_switch' => array( 
                'type'  => 'switch',
                'value' => 'on',
                'label' => esc_html__('Breadcrumbs Enable/Disable', 'miraculous'),
                    'left-choice' => array(
                        'value' => 'off',
                        'label' => esc_html__('Off', 'miraculous'),
                    ),
                        'right-choice' => array(
                        'value' => 'on',
                        'label' => esc_html__('On', 'miraculous'),
                    ),
            ),
        ),
    ),
);