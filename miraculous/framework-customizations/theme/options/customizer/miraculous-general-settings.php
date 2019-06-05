<?php if (!defined('FW')) die('Forbidden');
$options = array(
    'general_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('General Setting', 'miraculous'),
        'options' => array(
		    'logo_setting' => array(
				'type' => 'group',
				'options' => array(
					'logo_image'  => array( 
						'label' => esc_html__('Logo Image', 'miraculous'),
						'desc' => esc_html__('Upload logo image Here.', 'miraculous'),
						'type' => 'upload', 
					),
					'logo_width'  => array( 
						'type' => 'text',
						'value' => '111',
						'desc' => esc_html__('Enter logo width size in pixels. Ex: 80', 'miraculous'),
				    ),
					'logo_height'  => array( 
						'type' => 'text',
						'value' => '111',
						'desc' => esc_html__('Enter logo height size in pixels. Ex: 80', 'miraculous'),
					),
					'logo_title'  => array( 
						'type' => 'text',
						'value' => '',
						'desc' => esc_html__('Enter logo title', 'miraculous'),
					),
					'logo_svgcode'  => array(
						'type'  => 'textarea',
						'value' => '',
						'label' => __('Logo Svg Code', 'miraculous'),
						'desc'  => __('Enter svg code', 'miraculous'),
					),
				), 
			),
           'loader_switch' => array(
			    'type'  => 'switch',
		        'value' => 'on',
		        'label' => esc_html__('Loader Enable/Disable', 'miraculous'),
			        'left-choice' => array(
						'value' => 'off',
						'label' => esc_html__('Off', 'miraculous'),
					),
			        'right-choice' => array(
						  'value' => 'on',
						  'label' => esc_html__('On', 'miraculous'),
					),
			),
            'loader_image'  => array( 
    			'label' => esc_html__('Loader Image', 'miraculous'),
    			'desc' => esc_html__('Upload loader image Here.', 'miraculous'),
    			'type' => 'upload', 
    		),
			'player_switch' => array(
			    'type'  => 'switch',
		        'value' => 'off',
		        'label' => esc_html__('Player Enable/Disable', 'miraculous'),
			        'left-choice' => array(
						'value' => 'off',
						'label' => esc_html__('Off', 'miraculous'),
					),
			        'right-choice' => array(
						  'value' => 'on',
						  'label' => esc_html__('On', 'miraculous'),
					),
			),
			'shadow_switch' => array(
			    'type'  => 'switch',
		        'value' => 'on',
		        'label' => esc_html__('Footer Shadow Enable/Disable', 'miraculous'),
			        'left-choice' => array(
						'value' => 'off',
						'label' => esc_html__('Off', 'miraculous'),
					),
			        'right-choice' => array(
						  'value' => 'on',
						  'label' => esc_html__('On', 'miraculous'),
					),
			),
		)
    )
);