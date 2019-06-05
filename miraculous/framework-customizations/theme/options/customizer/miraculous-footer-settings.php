<?php if (!defined('FW')) die('Forbidden');
$options = array(
    'footer_settings' => array(
      'type' => 'tab',
      'title' => esc_html__('Footer Setting', 'miraculous'),
      'options' => array(
        'footer_logo' => array(
          'type'  => 'switch',
          'value' => 'off',
          'label' => esc_html__('Logo Enable/Disable', 'miraculous'),
            'left-choice' => array(
                    'value' => 'off', 
                    'label' => esc_html__('Off', 'miraculous'),
                    ),
            'right-choice' => array(
                    'value' => 'on',
                    'label' => esc_html__('On', 'miraculous'),
                    ),
        ),
		'flogo_image'  => array( 
					'label' => esc_html__('Logo Image', 'miraculous'),
					'desc' => esc_html__('Upload logo image Here.', 'miraculous'),
					'type' => 'upload', 
					),  
		'flogo_width'  => array( 
					'type' => 'text',
					'value' => '111',
					'desc' => esc_html__('Enter logo width size in pixels. Ex: 80', 'miraculous'),
				    ),
		'flogo_height'  => array( 
					'type' => 'text',
					'value' => '111',
					'desc' => esc_html__('Enter logo width size in pixels. Ex: 80', 'miraculous'),
					),	
		'flogo_svgcode'  => array(
					'type'  => 'textarea',
					'value' => '',
					'label' => __('Logo Svg Code', 'miraculous'),
					'desc'  => __('Enter svg code', 'miraculous'),
					),	
		'footer_bg_image'  => array( 
					'label' => esc_html__('Background Image', 'miraculous'),
					'desc' => esc_html__('Upload image Here.', 'miraculous'),
					'type' => 'upload', 
					),  				   
        'footer_copyrigth' => array(
					'label' => esc_html__('Copyright', 'miraculous'),
					'desc' => esc_html__('Enter Copyright Text Here.', 'miraculous'),
					'type' => 'textarea', 
					'value' => ''
                  ),
      )
    )
  ); 