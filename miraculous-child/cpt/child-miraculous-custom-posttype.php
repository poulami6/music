<?php


add_action( 'init', 'child_miraculous_register_custom_post_type' );

function child_miraculous_register_custom_post_type() {

    $cgmtv_labels = array(
        'name'               => _x( 'CGM TV', 'miraculous' ),
        'singular_name'      => _x( 'CGM TV', 'miraculous' ),
        'menu_name'          => _x( 'CGM TV', 'admin menu', 'miraculous' ),
        'name_admin_bar'     => _x( 'news', 'add new on admin bar', 'miraculous' ),
        'add_new'            => _x( 'Add New', 'CGM TV', 'miraculous' ),
        'add_new_item'       => __( 'Add New CGM TV', 'miraculous' ),
        'new_item'           => __( 'New CGM TV', 'miraculous' ),
        'edit_item'          => __( 'Edit CGM TV', 'miraculous' ),
        'view_item'          => __( 'View CGM TV', 'miraculous' ),
        'all_items'          => __( 'All CGM TV', 'miraculous' ),
        'search_items'       => __( 'Search CGM TV', 'miraculous' ),
        'parent_item_colon'  => __( 'Parent CGM TV:', 'miraculous' ),
        'not_found'          => __( 'No CGM TV found.', 'miraculous' ),
        'not_found_in_trash' => __( 'No CGM TV found in Trash.', 'miraculous' )
    );

    $cgmtv_args = array(
        'labels'             => $cgmtv_labels,
        'description'        => __( 'Description.', 'miraculous' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ms-cgmtv' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-video-alt2',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'ms-cgmtv', $cgmtv_args );

    // Add new taxonomy, make it hierarchical (like categories) 
        $tv_labels = array(
            'name'              => _x( 'TV Category', 'miraculous' ),
            'singular_name'     => _x( 'TV Category', 'miraculous' ),
            'search_items'      => __( 'Search TV Category', 'miraculous' ),
            'all_items'         => __( 'All TV Category', 'miraculous' ),
            'parent_item'       => __( 'Parent TV Category', 'miraculous' ),
            'parent_item_colon' => __( 'Parent TV Category:', 'miraculous' ),
            'edit_item'         => __( 'Edit TV Category', 'miraculous' ),
            'update_item'       => __( 'Update TV Category', 'miraculous' ),
            'add_new_item'      => __( 'Add New TV Category', 'miraculous' ),
            'new_item_name'     => __( 'New TV Category', 'miraculous' ),
            'menu_name'         => __( 'TV Category', 'miraculous' ),
        );

        $tv_args = array(
            'hierarchical'      => true,
            'labels'            => $tv_labels,
            'has_archive'       => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'cgmtv-categories' ),
        );

    
    register_taxonomy( 'cgmtv-categories', array( 'ms-cgmtv' ), $tv_args );
    
$playlist_labels = array(
        'name'               => _x( 'Playlist', 'miraculous' ),
        'singular_name'      => _x( 'Playlist', 'miraculous' ),
        'menu_name'          => _x( 'Playlist', 'admin menu', 'miraculous' ),
        'name_admin_bar'     => _x( 'news', 'add new on admin bar', 'miraculous' ),
        'add_new'            => _x( 'Add New', 'Playlist', 'miraculous' ),
        'add_new_item'       => __( 'Add New Playlist', 'miraculous' ),
        'new_item'           => __( 'New Playlist', 'miraculous' ),
        'edit_item'          => __( 'Edit Playlist', 'miraculous' ),
        'view_item'          => __( 'View Playlist', 'miraculous' ),
        'all_items'          => __( 'All Playlist', 'miraculous' ),
        'search_items'       => __( 'Search Playlist', 'miraculous' ),
        'parent_item_colon'  => __( 'Parent Playlist:', 'miraculous' ),
        'not_found'          => __( 'No Playlist found.', 'miraculous' ),
        'not_found_in_trash' => __( 'No Playlist found in Trash.', 'miraculous' )
    );

    $playlist_args = array(
        'labels'             => $playlist_labels,
        'description'        => __( 'Description.', 'miraculous' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ms-playlist' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-playlist-audio',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'ms-playlist', $playlist_args );

    // Add new taxonomy, make it hierarchical (like categories) 
        $mood_labels = array(
            'name'              => _x( 'Playlist Mood', 'miraculous' ),
            'singular_name'     => _x( 'Playlist Mood', 'miraculous' ),
            'search_items'      => __( 'Search Playlist Mood', 'miraculous' ),
            'all_items'         => __( 'All Playlist Mood', 'miraculous' ),
            'parent_item'       => __( 'Parent Playlist Mood', 'miraculous' ),
            'parent_item_colon' => __( 'Parent Playlist Mood:', 'miraculous' ),
            'edit_item'         => __( 'Edit Playlist Mood', 'miraculous' ),
            'update_item'       => __( 'Update Playlist Mood', 'miraculous' ),
            'add_new_item'      => __( 'Add New Playlist Mood', 'miraculous' ),
            'new_item_name'     => __( 'New Playlist Mood', 'miraculous' ),
            'menu_name'         => __( 'Playlist Mood', 'miraculous' ),
        );

        $mood_args = array(
            'hierarchical'      => true,
            'labels'            => $mood_labels,
            'has_archive'       => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'playlist-mood' ),
        );

    
    register_taxonomy( 'playlist-mood', array( 'ms-playlist' ), $mood_args );
    register_taxonomy_for_object_type( 'genre', 'ms-playlist' );    


        $news_labels = array(
        'name'               => _x( 'News', 'miraculous' ),
        'singular_name'      => _x( 'News', 'miraculous' ),
        'menu_name'          => _x( 'News', 'admin menu', 'miraculous' ),
        'name_admin_bar'     => _x( 'news', 'add new on admin bar', 'miraculous' ),
        'add_new'            => _x( 'Add New', 'News', 'miraculous' ),
        'add_new_item'       => __( 'Add New News', 'miraculous' ),
        'new_item'           => __( 'New news', 'miraculous' ),
        'edit_item'          => __( 'Edit News', 'miraculous' ),
        'view_item'          => __( 'View News', 'miraculous' ),
        'all_items'          => __( 'All News', 'miraculous' ),
        'search_items'       => __( 'Search News', 'miraculous' ),
        'parent_item_colon'  => __( 'Parent News:', 'miraculous' ),
        'not_found'          => __( 'No News found.', 'miraculous' ),
        'not_found_in_trash' => __( 'No News found in Trash.', 'miraculous' )
    );

    $news_args = array(
        'labels'             => $news_labels,
        'description'        => __( 'Description.', 'miraculous' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ms-news' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-share-alt',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'ms-news', $news_args );

    /* Add new taxonomy, make it hierarchical (like categories) */
        $n_labels = array(
            'name'              => _x( 'News Types', 'miraculous' ),
            'singular_name'     => _x( 'News Type', 'miraculous' ),
            'search_items'      => __( 'Search News Types', 'miraculous' ),
            'all_items'         => __( 'All News Types', 'miraculous' ),
            'parent_item'       => __( 'Parent News Type', 'miraculous' ),
            'parent_item_colon' => __( 'Parent News Type:', 'miraculous' ),
            'edit_item'         => __( 'Edit News Type', 'miraculous' ),
            'update_item'       => __( 'Update News Type', 'miraculous' ),
            'add_new_item'      => __( 'Add New News Type', 'miraculous' ),
            'new_item_name'     => __( 'New News Type Name', 'miraculous' ),
            'menu_name'         => __( 'News Type', 'miraculous' ),
        );

        $n_args = array(
            'hierarchical'      => true,
            'labels'            => $n_labels,
            'has_archive'       => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'news-type' ),
        );

    
    register_taxonomy( 'news-type', array( 'ms-news' ), $n_args );

    $spotlight_labels = array(
        'name'               => _x( 'Spotlights', 'miraculous' ),
        'singular_name'      => _x( 'Spotlight', 'miraculous' ),
        'menu_name'          => _x( 'Spotlights', 'admin menu', 'miraculous' ),
        'name_admin_bar'     => _x( 'Spotlight', 'add new on admin bar', 'miraculous' ),
        'add_new'            => _x( 'Add New', 'music', 'miraculous' ),
        'add_new_item'       => __( 'Add New spotlight', 'miraculous' ),
        'new_item'           => __( 'New spotlight', 'miraculous' ),
        'edit_item'          => __( 'Edit spotlight', 'miraculous' ),
        'view_item'          => __( 'View spotlight', 'miraculous' ),
        'all_items'          => __( 'All Spotlights', 'miraculous' ),
        'search_items'       => __( 'Search Spotlights', 'miraculous' ),
        'parent_item_colon'  => __( 'Parent Spotlights:', 'miraculous' ),
        'not_found'          => __( 'No Spotlights found.', 'miraculous' ),
        'not_found_in_trash' => __( 'No Spotlights found in Trash.', 'miraculous' )
    );

    $spotlight_args = array(
        'labels'             => $spotlight_labels,
        'description'        => __( 'Description.', 'miraculous' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ms-spotlight' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-video-alt3',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );



    register_post_type( 'ms-spotlight', $spotlight_args );




    /* Add new taxonomy, make it hierarchical (like categories) */
        $sc_labels = array(
            'name'              => _x( 'Spotlight Types', 'miraculous' ),
            'singular_name'     => _x( 'Spotlight Type', 'miraculous' ),
            'search_items'      => __( 'Search Spotlight Types', 'miraculous' ),
            'all_items'         => __( 'All Spotlight Types', 'miraculous' ),
            'parent_item'       => __( 'Parent Spotlight Type', 'miraculous' ),
            'parent_item_colon' => __( 'Parent Spotlight Type:', 'miraculous' ),
            'edit_item'         => __( 'Edit Spotlight Type', 'miraculous' ),
            'update_item'       => __( 'Update Spotlight Type', 'miraculous' ),
            'add_new_item'      => __( 'Add New Spotlight Type', 'miraculous' ),
            'new_item_name'     => __( 'New Spotlight Type Name', 'miraculous' ),
            'menu_name'         => __( 'Spotlight Type', 'miraculous' ),
        );

        $sc_args = array(
            'hierarchical'      => true,
            'labels'            => $sc_labels,
            'has_archive'       => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'spotlight-type' ),
        );

    
        register_taxonomy( 'spotlight-type', array( 'ms-spotlight' ), $sc_args );


        // Artist of the month
        $arm_labels = array(
        'name'               => _x( 'Artist of Month', 'miraculous' ),
        'singular_name'      => _x( 'Artist of Month', 'miraculous' ),
        'menu_name'          => _x( 'Artist of Month', 'admin menu', 'miraculous' ),
        'name_admin_bar'     => _x( 'Artist of Month', 'add new on admin bar', 'miraculous' ),
        'add_new'            => _x( 'Add New', 'Artist of Month', 'miraculous' ),
        'add_new_item'       => __( 'Add New Artist of Month', 'miraculous' ),
        'new_item'           => __( 'New Artist of Month', 'miraculous' ),
        'edit_item'          => __( 'Edit Artist of Month', 'miraculous' ),
        'view_item'          => __( 'View Artist of Month', 'miraculous' ),
        'all_items'          => __( 'All Artist of Month', 'miraculous' ),
        'search_items'       => __( 'Search Artist of Month', 'miraculous' ),
        'parent_item_colon'  => __( 'Parent Artist of Month:', 'miraculous' ),
        'not_found'          => __( 'No Artist of Month found.', 'miraculous' ),
        'not_found_in_trash' => __( 'No Artist of Month found in Trash.', 'miraculous' )
    );

    $arm_args = array(
        'labels'             => $arm_labels,
        'description'        => __( 'Description.', 'miraculous' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ms-artist-month' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-admin-users',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'ms-artist-month', $arm_args );

    /* Add new taxonomy, make it hierarchical (like categories) */
        $arm_m_labels = array(
            'name'              => _x( 'Artist Month', 'miraculous' ),
            'singular_name'     => _x( 'Artist Month', 'miraculous' ),
            'search_items'      => __( 'Search Artist Month', 'miraculous' ),
            'all_items'         => __( 'All Artist Month', 'miraculous' ),
            'parent_item'       => __( 'Parent Artist Month', 'miraculous' ),
            'parent_item_colon' => __( 'Parent Artist Month:', 'miraculous' ),
            'edit_item'         => __( 'Edit Artist Month', 'miraculous' ),
            'update_item'       => __( 'Update Artist Month', 'miraculous' ),
            'add_new_item'      => __( 'Add New Artist Month', 'miraculous' ),
            'new_item_name'     => __( 'New Artist Month', 'miraculous' ),
            'menu_name'         => __( 'Artist Month', 'miraculous' ),
        );

        $arm_m_args = array(
            'hierarchical'      => true,
            'labels'            => $arm_m_labels,
            'has_archive'       => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'artist-month' ),
        );

    
        register_taxonomy( 'artist-month', array( 'ms-artist-month' ), $arm_m_args );
        /* Add new taxonomy, make it hierarchical (like categories) */
        $arm_y_labels = array(
            'name'              => _x( 'Artist Year', 'miraculous' ),
            'singular_name'     => _x( 'Artist Year', 'miraculous' ),
            'search_items'      => __( 'Search Artist Year', 'miraculous' ),
            'all_items'         => __( 'All Artist Year', 'miraculous' ),
            'parent_item'       => __( 'Parent Artist Year', 'miraculous' ),
            'parent_item_colon' => __( 'Parent Artist Year:', 'miraculous' ),
            'edit_item'         => __( 'Edit Artist Year', 'miraculous' ),
            'update_item'       => __( 'Update Artist Year', 'miraculous' ),
            'add_new_item'      => __( 'Add New Artist Year', 'miraculous' ),
            'new_item_name'     => __( 'New Artist Year', 'miraculous' ),
            'menu_name'         => __( 'Artist Year', 'miraculous' ),
        );

        $arm_y_args = array(
            'hierarchical'      => true,
            'labels'            => $arm_y_labels,
            'has_archive'       => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'artist-year' ),
        );

    
        register_taxonomy( 'artist-year', array( 'ms-artist-month' ), $arm_y_args );
}

// register a custom post type called 'banner'
function child_theme_create_releases_post_type() {
    $labels = array(
        'name' => __( 'Releases List' ),
        'singular_name' => __( 'new-releases' ),
        'add_new' => __( 'Add Release' ),
        'add_new_item' => __( 'Add New Release' ),
        'edit_item' => __( 'Edit Release' ),
        'new_item' => __( 'Add Release' ),
        'view_item' => __( 'View Release' ),
        'search_items' => __( 'Search Release' ),
        'not_found' =>  __( 'No Release Found' ),
        'not_found_in_trash' => __( 'No Release found in Trash' ),
        'featured_image'  => __( 'Cover Image'),
        'set_featured_image'    => __( 'Set cover image'),
        'remove_featured_image' => __( 'Remove cover image'),
        'use_featured_image'    => __( 'Use as cover image'),
    );
    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        
    );
    register_post_type( 'new-releases', $args );
}
add_action( 'init', 'child_theme_create_releases_post_type' );


?>