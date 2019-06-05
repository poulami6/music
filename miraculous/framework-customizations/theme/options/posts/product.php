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
        ),
    ),
  );