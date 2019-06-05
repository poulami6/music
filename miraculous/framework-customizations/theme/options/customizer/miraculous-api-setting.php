<?php if (!defined('FW')) die('Forbidden');
$options = array(
    'mailchimp_tab' => array(
        'type' => 'tab',
        'title' => esc_html__('Api Setting', 'miraculous'),
        'options' => array(
			'mailchimp_settings' => array(
				'type' => 'group',
				'options' => array(
					'mailchimp_api_key'  => array( 
						'label' => esc_html__('MailChimp Api Key', 'miraculous'),
						'type' => 'text',
					),
					'mailchimp_list_id'  => array( 
						'label' => esc_html__('MailChimp List Id', 'miraculous'),
						'type' => 'text',
					),
				),
			),	
			'paypal_settings' => array(
				'type' => 'group',
				'options' => array(
					'paypal_mode' => array(
						'label' => esc_html__('Paypal Payment Mode', 'miraculous'),
						'type' => 'select',
						'value' => 'testing',
						'choices' => array(
							'testing' => esc_html__('Testing', 'miraculous'),
							'live' => esc_html__('Live', 'miraculous')
						),
					),
					'paypal_currency' => array(
                        'label' => esc_html__('Currency', 'miraculous'),
                        'type' => 'select',
                        'value' => 'USD',
                        'choices' => array(
                            'ANG' => esc_html__('ANG', 'miraculous'),
                            'AOA' => esc_html__('AOA', 'miraculous'),
                            'AUD' => esc_html__('AUD', 'miraculous'),
                            'AWG' => esc_html__('AWG', 'miraculous'),
                            'BWP' => esc_html__('BWP', 'miraculous'),
                            'USD' => esc_html__('USD', 'miraculous'),
                            'CAD' => esc_html__('CAD', 'miraculous'),
                            'CDF' => esc_html__('CDF', 'miraculous'),
                            'GBP' => esc_html__('GBP', 'miraculous'),
                            'EUR' => esc_html__('EUR', 'miraculous'),
                            'RUB' => esc_html__('RUB', 'miraculous'),
                            'INR' => esc_html__('INR', 'miraculous'),
                            'JPY' => esc_html__('JPY', 'miraculous'),
                            'VND' => esc_html__('VND', 'miraculous'),
                        ),
                    ),
					'paypal_business_email' => array(
						'type'  => 'text',
    	        		'value' => '',
    	        		'label' => esc_html__('Paypal Business Email', 'miraculous'),

					),
					'paypal_success_page_url' => array(
						'type'  => 'text',
    	        		'value' => '',
    	        		'label' => esc_html__('Paypal Success Url', 'miraculous'),
					),
					'paypal_cancel_page_url' => array(
						'type'  => 'text',
    	        		'value' => '',
    	        		'label' => esc_html__('Paypal Cancel Url', 'miraculous'),
					),
					'paypal_info' => array(
					    'type'  => 'html',
                        'value' => '',
                        'label' => esc_html__('IPN Info', 'miraculous'),
                        'html'  => 'Set this url in paypal IPN setting <code>YOUR SITE URL/wp-content/plugins/miraculouscore/paypal/payments.php</code> for getting payment information.',
					    ),
				),
			),
			'google_api_settings' => array(
				'type' => 'group',
				'options' => array(
					'google_login_client_id' => array(
						'type'  => 'text',
    	        		'value' => '',
    	        		'label' => esc_html__('Google App Client ID', 'miraculous'),

					),
					'google_login_client_secret' => array(
						'type'  => 'text',
    	        		'value' => '',
    	        		'label' => esc_html__('Google App client serect', 'miraculous'),
					),
					'google_login_redirect_uri' => array(
						'type'  => 'text',
    	        		'value' => '',
    	        		'label' => esc_html__('Google Login Redirect URI', 'miraculous'),
					),
				),
			),
		),
	),
);  