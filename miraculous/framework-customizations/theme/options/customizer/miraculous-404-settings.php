<?php if (!defined('FW')) die('Forbidden');
$options = array(
    'error_404_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('404 Setting', 'miraculous'),
        'options' => array(
			'error_404_desc'  => array( 
				'label' => esc_html__('Description', 'miraculous'),
				'type' => 'wp-editor',
				'desc' => esc_html__('', 'miraculous'),
				'media_buttons' => false,
				'wpautop' => false, 
			),
			'err_ring' => array(
				'label' => esc_html__('Ring Image', 'miraculous'),
				'type' => 'upload',
				'desc' => esc_html__('', 'miraculous'),
			),
			'emptypageimage' => array(
				'label' => esc_html__('Bottom Wave Image', 'miraculous'),
				'type' => 'upload',
				'desc' => esc_html__('', 'miraculous'),
			),
		)
    ) 
);  