<?php if( !defined('FW') ) die('Forbidden');

$options = array(
    'album_options' => array(
        'type' => 'box',
        'title' => __('Album Options', 'miraculous'),
        'options' => array(
            'album_type' => array(
                'type'  => 'radio',
                'fw-storage' => array(
                    'type' => 'post-meta',
                    'post-meta' => 'fw_option:album_type',
                ),
                'value' => 'free',
                'label' => __('Album', 'miraculous'),
                'choices' => array( 
                    'free' => __('Free', 'miraculous'),
                    'premium' => __('Premium', 'miraculous'),
                ),
                // Display choices inline instead of list
                'inline' => true,
            ),
            'album_songs' => array(
                'type'  => 'select-multiple',
                'label' => __('Song Name', 'miraculous'),
                'desc'  => __('Select Songs you wish to assign for this album.', 'miraculous'),
                'help'  => __('Help tip', 'miraculous'),
                'choices' => miraculous_get_all_songs_name_for_album_post(),
            ),
            'album_artists' => array(
                'type'  => 'select-multiple',
                'label' => __('Artist Name', 'miraculous'),
                'desc'  => __('Select Artists you wish to assign for this album.', 'miraculous'),
                'help'  => __('Help tip', 'miraculous'),
                'choices' => miraculous_get_all_artists_name_for_album_post(),
            ),
            'album_release_date' => array(
                'type'  => 'date-picker',
                'label' => __('Release Date', 'miraculous'),
                'help'  => __('Help tip', 'miraculous'),
                'monday-first' => true, // The week will begin with Monday; for Sunday, set to false
                'min-date' => date('d-m-Y'), 
                'max-date' => null, 
            ),
            'album_company_name' => array(
                'type' => 'text',
                'label' => __('Company Name', 'miraculous'),
                'help'  => __('Help tip', 'miraculous'),
            ),
            'post-sidebar' => array(
                'label'   => esc_html__( 'Post Sidebar Position', 'miraculous' ),
                'type'    => 'image-picker',
                'value'   => 'full',
                'desc'    => esc_html__( 'Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.',
                    'miraculous' ),
                'choices' => array(
                    'full' => array(
                        'small' => array(
                            'height' => 50,
                            'src'    => get_template_directory_uri() . '/assets/images/1c.png'
                        ),
                    ),
                    'left' => array(
                        'small' => array(
                            'height' => 50,
                            'src'    => get_template_directory_uri() . '/assets/images/2cl.png'
                        ),
                    ),
                    'right' => array(
                        'small' => array(
                            'height' => 50,
                            'src'    => get_template_directory_uri() . '/assets/images/2cr.png'
                        ),
                    ),
                ),
            ),
            'post_breadcrumbs_switch' => array( 
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
            'post_bgimages_switch' => array( 
                'type'  => 'switch',
                'value' => 'on',
                'label' => esc_html__('Background Image Enable/Disable', 'miraculous'),
                    'left-choice' => array(
                        'value' => 'off',
                        'label' => esc_html__('Off', 'miraculous'),
                    ),
                        'right-choice' => array(
                        'value' => 'on',
                        'label' => esc_html__('On', 'miraculous'),
                    ),
            ),
            'single_bg_images'  => array(
                'type'  => 'upload',
                'value' => '',
                'images_only' => true,
                'label' => __('Background Image', 'miraculous'),
                'desc'  => __('Upload Background Image', 'miraculous'),
                ),
        ),
    ),
);