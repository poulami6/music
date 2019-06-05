<?php  if (!defined('FW')) die('Forbidden');
$options = array(
    'theme_switcher' => array(
        'type' => 'tab',
        'title' => esc_html__('Theme Layout Setting', 'miraculous'),
        'options' => array(
            'miraculous_layout' => array(
				'label'   => esc_html__('Theme Layout Color ', 'miraculous'),
				'type'    => 'image-picker',
				'value'   => '2',
				'desc'    => esc_html__('Select theme Layout color.','miraculous'),
				'choices' => array(
					'1' => array(
						'small' => array(
							'height' => 70,
							'width' => 70,
							'src'    => get_template_directory_uri() . '/assets/images/dark.png'
						  ),
					), 
					'2' => array(
						'small' => array(
							'height' => 70,
							'width' => 70,
							'src'    => get_template_directory_uri() . '/assets/images/light.png'
						),
					),
					
				),
			 ), 
		
		'themeoption_color_switch' => array(
            'type'  => 'multi-picker',
			'label' => false,
			'desc'  => false,       
			'picker' => array(
			'color_switch_value' => array(
			                  'label' => __('Theme Color Option', 'miraculous'),
			                  'type'  => 'switch',
			                    'right-choice' => array(
			                      'value' => 'on',
			                      'label' => __('On', 'miraculous')
			                    ),
			                    'left-choice' => array(
			                      'value' => 'off',
			                      'label' => __('Off', 'miraculous')
			                    ),
			              )
			    ), 
			'choices' => array(
			    'on' => array(
				'thememiraculous_color' => array(
						'label'   => esc_html__('Theme Color ', 'miraculous'),
						'type'    => 'image-picker',
						'value'   => '2',
				        'desc'    => esc_html__('Select theme color.','miraculous'),
							'choices' => array(
								'1' => array(
									'small' => array(
										'height' => 70,
										'width' => 70,
										'src'    => get_template_directory_uri() . '/assets/images/Logo-2.png'
									  ),
								), 
								'2' => array(
									'small' => array(
										'height' => 70,
										'width' => 70,
										'src'    => get_template_directory_uri() . '/assets/images/Logo-4.png'
									),
								),
								'3' => array(
									'small' => array(
										'height' => 70,
										'width' => 70,
										'src'    => get_template_directory_uri() . '/assets/images/Logo-3.png'
									),
								),
								'4' => array(
									'small' => array(
										'height' => 70,
										'width' => 70,
										'src'    => get_template_directory_uri() . '/assets/images/Logo.png'
									),
								),
								'5' => array(
									'small' => array(
										'height' => 70,
										'width' => 70,
										'src'    => get_template_directory_uri() . '/assets/images/Logo-5.png'
									),
								),
								'6' => array(
									'small' => array(
										'height' => 70,
										'width' => 70,
										'src'    => get_template_directory_uri() . '/assets/images/Logo-1.png'
									),
								),
								
							),
						 ), 
						   
					   ),
				),
			'show_borders' => false,     
		),	
			
		'theme_multi_color_switch' => array(
            'type'  => 'multi-picker',
			'label' => false,
			'desc'  => false,       
			'picker' => array(
			'color_switch_value' => array(
			                  'label' => __('Theme Multi Color Option', 'miraculous'),
			                  'type'  => 'switch',
			                    'right-choice' => array(
			                      'value' => 'on',
			                      'label' => __('On', 'miraculous')
			                    ),
			                    'left-choice' => array(
			                      'value' => 'off',
			                      'label' => __('Off', 'miraculous')
			                    ),
			              )
			    ), 
			'choices' => array(
					'on' => array(
						'theme_multi_color' => array(
							'label'   => esc_html__('Theme Color ', 'miraculous'),
							'type'    => 'color-picker',
							'value'   => '#e3720c',
							'desc'    => esc_html__( 'Select theme color.','miraculous' ),				
						   ),
					   ),
				),
			'show_borders' => false,     
			),
			'fonts_style' => array(
			    'type'  => 'switch',
		        'value' => 'on',
		        'label' => esc_html__('Theme fonts style', 'miraculous'),
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