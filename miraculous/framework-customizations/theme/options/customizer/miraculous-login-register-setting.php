<?php if (!defined('FW')) die('Forbidden');
$options = array(
    'loginregister_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Login/Register Setting', 'miraculous'),
        'options' => array(
		    'loginregister_switch' => array(
			    'type'  => 'switch',
		        'value' => 'on',
		        'label' => esc_html__('Login / Register Enable/Disable', 'miraculous'),
			        'left-choice' => array(
						'value' => 'off',
						'label' => esc_html__('Off', 'miraculous'),
					),
			        'right-choice' => array(
						  'value' => 'on',
						  'label' => esc_html__('On', 'miraculous'),
					),
			),
			'loginregister_image'  => array( 
					'label' => esc_html__('Login / Register Image', 'miraculous'),
					'desc' => esc_html__('Upload Login & Register Image Here.', 'miraculous'),
					'type' => 'upload', 
					),
		)
    )
);