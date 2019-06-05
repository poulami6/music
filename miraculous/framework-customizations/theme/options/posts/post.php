<?php if( !defined('FW') ) die('Forbidden');

$options = array(
    'main' => array(
        'type' => 'box',
        'title' => __('Post Options', 'miraculous'),
        'options' => array(
            'post-sidebar' => array(
                'label'   => esc_html__( 'Post Sidebar Position', 'miraculous' ),
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
            'post_breadcrumbs_switch' => array( 
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
            'post_bgimages_switch' => array( 
                'type'  => 'switch',
                'value' => 'on',
                'label' => esc_html__('Background Image Enable/Disable', 'miraculous'),
                    'left-choice' => array(
                        'value' => 'off',
                        'label' => esc_html__('Off', 'miraculous'),
                    ),
                        'right-choice' => array(
                        'value' => 'on',
                        'label' => esc_html__('On', 'miraculous'),
                    ),
            ),
            'single_bg_images'  => array(
                'type'  => 'upload',
                'value' => '',
                'images_only' => true,
                'label' => __('Background Image', 'miraculous'),
                'desc'  => __('Upload Background Image', 'miraculous'),
                ),
        ),
    ),
);