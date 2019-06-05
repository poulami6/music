<?php if( !defined('FW') ) die('Forbidden');

$options = array(
    'main' => array(
        'type' => 'box',
        'title' => __('Plan Options', 'miraculous'),
        'options' => array(
            'plan_price' => array(
                'type'  => 'text',
                'fw-storage' => array(
                    'type' => 'post-meta',
                    'post-meta' => 'fw_option:plan_price',
                ),
                'label' => __('Price', 'miraculous'),
                'desc'  => __('Enter price eg. 20', 'miraculous'),
            ),
            'plan_monthly_downloads' => array(
                'type'  => 'text',
                'fw-storage' => array(
                    'type' => 'post-meta',
                    'post-meta' => 'fw_option:plan_monthly_downloads',
                ),
                'label' => __('Monthly Downloads', 'miraculous'),
                'desc'  => __('Enter number of songs to downloads eg. 50', 'miraculous'),
            ),
            
            'plan_validity' => array(
                'type'  => 'text',
                'fw-storage' => array(
                    'type' => 'post-meta',
                    'post-meta' => 'fw_option:plan_validity',
                ),
                'label' => __('Plan Validity', 'miraculous'),
                'desc'  => __('Enter number of months eg. 2', 'miraculous'),
            ),
            
        ),
    ),
);