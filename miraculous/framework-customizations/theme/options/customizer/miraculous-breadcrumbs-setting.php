<?php if (!defined('FW')) die('Forbidden');
$options = array(
     'breadcrumbs_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Breadcrumbs Setting', 'miraculous'),
        'options' => array(
            'breadcrumbs_switch' => array( 
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
			'breadcrumbs_image'  => array( 
						 'label' => esc_html__('Breadcrumbs Background Image', 'miraculous'),
						 'desc' => esc_html__('Breadcrumbs Background Upload  image Here.', 'miraculous'),
						 'type' => 'upload', 
					  ),
					  
		   	     )
             ) 
        ); 
