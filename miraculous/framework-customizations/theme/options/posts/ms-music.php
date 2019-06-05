<?php if( !defined('FW') ) die('Forbidden');
 
$options = array(
    'music_upload_option' => array(
        'type' => 'box',
        'title' => __('Music Upload Options', 'miraculous'),
        'options' => array(
            'mp3_full_songs' => array(
                'type'  => 'upload',
                'fw-storage' => array(
                    'type' => 'post-meta',
                    'post-meta' => 'fw_option:mp3_full_songs',
                ),
                'label' => __('Mp3 Full song', 'miraculous'),
                'desc'  => __('For Premium users', 'miraculous'),
                'files_ext' => array( 'mp3' ),
                'extra_mime_types' => array( 'audio/x-aiff, aif aiff' )
            ),
            'music_extranal_url'  => array(
                    'type'  => 'text',
                    'value' => '',
                    'label' => __('Mp3 Music External Url', 'miraculous'),
                    'desc'  => __('Mp3 Music External Url', 'miraculous'),
                    ),
        ),
    ),
    'music_option' => array(
        'type' => 'box',
        'title' => __('Music Options', 'miraculous'),
        'options' => array(
            'music_type_options' => array(
                'type'  => 'multi-picker',
                'label' => false,
                'desc'  => false,       
                'picker' => array(
                    'music_type' => array(
                                    'type'  => 'radio',
                                    'fw-storage' => array(
                                        'type' => 'post-meta',
                                        'post-meta' => 'fw_option:music_type',
                                    ),
                                    'value' => 'free',
                                    'label' => __('Music', 'miraculous'),
                                    'choices' => array( 
                                        'free' => __('Free', 'miraculous'),
                                        'premium' => __('Premium', 'miraculous'),
                                    ),
                                    // Display choices inline instead of list
                                    'inline' => true,
                                ),
                ), 
                    'choices' => array(
                            'premium' => array(
                                'single_music_price'  => array(
                                        'type'  => 'text',
                                        'value' => '',
                                        'label' => __('Price', 'miraculous'),
                                        'desc'  => __('enter price.', 'miraculous'),
                                ),
                            ),
                        ),
                    'show_borders' => false,     
            ),
            'music_artists' => array(
                'type'  => 'select-multiple',
                'fw-storage' => array(
                    'type' => 'post-meta',
                    'post-meta' => 'fw_option:music_artists',
                ),
                'label' => __('Artist Name', 'miraculous'),
                'desc'  => __('Select Artists you wish to assign for this music.', 'miraculous'),
                'choices' => miraculous_get_all_artists_name_for_album_post(),
            ),
            'music_release_date' => array(
                'type'  => 'date-picker',
                'label' => __('Release Date', 'miraculous'),
                'monday-first' => true, // The week will begin with Monday; for Sunday, set to false
                'min-date' => "01-01-1900", 
                'max-date' => null, 
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