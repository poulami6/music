<?php if (!defined('FW')) die('Forbidden');
$options = array(
    'header_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Header Setting', 'miraculous'),
        'options' => array(
			'themeloginbar_switch' => array(
				'type'  => 'multi-picker',
				'label' => false,
				'desc'  => false,       
				'picker' => array(
			        'loginbar_switch_value' => array(
			                  'label' => __('Theme Login Bar Enable/Disable', 'miraculous'),
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
			        	        'header_trend_title'  => array(
			        	        		'type'  => 'text',
			        	        		'value' => 'Trending Songs',
			        	        		'label' => __('Trending Title', 'miraculous'),
			        	        ),
			        	        'header_trend_url'  => array(
			        	        		'type'  => 'text',
			        	        		'label' => __('Trending Url', 'miraculous'),
			        	        ),
			        	        'header_trend_desc'  => array(
			        	        		'type'  => 'textarea',
			        	        		'label' => __('Trending Description', 'miraculous'),
			        	        ),
					         	'header_search_option'  => array(
			        	        		'type'  => 'switch',
			                		    'label' => __('Search Block Enable/Disable', 'miraculous'),
			                		    'left-choice' => array(
			                		        'value' => 'off',
			                		        'label' => __('off', 'miraculous'),
			                		    ),
			                		    'right-choice' => array(
			                		        'value' => 'on',
			                		        'label' => __('on', 'miraculous'),
			                		    ),
			        	        ),
			        	        'header_language_option'  => array(
			        	        		'type'  => 'switch',
			                		    'label' => __('Language Selection Enable/Disable', 'miraculous'),
			                		    'left-choice' => array(
			                		        'value' => 'off',
			                		        'label' => __('off', 'miraculous'),
			                		    ),
			                		    'right-choice' => array(
			                		        'value' => 'on',
			                		        'label' => __('on', 'miraculous'),
			                		    ),
			        	        ),
					        ),
					    ),
					'show_borders' => false,     
			), 
			'header_style' => array(
                'type'  => 'select',
                'label' => esc_html__('Select Header','miraculous'),
                'value' => esc_html__('header-one', 'miraculous'),
                    'choices' => array(
                        'default' => esc_html__('Header Default', 'miraculous'),
                        'style-one' => esc_html__('Header One', 'miraculous'),
                ),
            ),
		
         )
    )
);