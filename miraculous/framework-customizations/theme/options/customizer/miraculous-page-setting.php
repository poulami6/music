<?php if (!defined('FW')) die('Forbidden');
$options = array(
    'user_page_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Pages Setting', 'miraculous'),
        'options' => array(
		    'user_profile_page'  => array( 
				'label' => esc_html__('Profile Page', 'miraculous'),
				'type' => 'select',
				'value' => '',
				'desc'  => __('user profile page', 'miraculous'),
				'choices' => miraculous_list_all_pages(),
			),
			'user_pricing_plan_page'  => array( 
				'label' => esc_html__('Pricing Plan Page', 'miraculous'),
				'type' => 'select',
				'value' => '',
				'desc'  => __('pricing plan page', 'miraculous'),
				'choices' => miraculous_list_all_pages(),
			),
			'user_blog_page'  => array( 
				'label' => esc_html__('Your Tracks', 'miraculous'),
				'type' => 'select',
				'value' => '',
				'desc'  => __('user uploaded music listing page', 'miraculous'),
				'choices' => miraculous_list_all_pages(),
			),
			'user_setting_page'  => array( 
				'label' => esc_html__('Setting Page', 'miraculous'),
				'type' => 'select',
				'value' => '',
				'desc'  => __('user setting page', 'miraculous'),
				'choices' => miraculous_list_all_pages(),
			),
			'user_music_upload_page'  => array( 
				'label' => esc_html__('Music Upload Page', 'miraculous'),
				'type' => 'select',
				'value' => '',
				'desc'  => __('user music upload page', 'miraculous'),
				'choices' => miraculous_list_all_pages(),
			),
		),
    ),
);  