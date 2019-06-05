<?php

/**
 * Child miraculous custom Post types 
 */ 


function miraculous_child_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'miraculous-style' for the Miraculous theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
   
     wp_enqueue_style( 'child-all-css', get_stylesheet_directory_uri() . '/css/all.css');

/* enqueue script for child custom ajax */

     wp_enqueue_script( 'child-custom-ajax', get_stylesheet_directory_uri() . '/js/child-custom-ajax.js', array('jquery'), '20151215', true );
    
     wp_localize_script( 'child-custom-ajax', 'front_ajax', array('ajax_url' => admin_url( 'admin-ajax.php' )) );

}
add_action( 'wp_enqueue_scripts', 'miraculous_child_theme_enqueue_styles',11 );

add_role( 'artist', 'Artist', array( 'read' => true, 'edit_posts' => false,'delete_posts' => false ) );

/**
 * miraculous add caps to upload files for artist
 */
function miraculous_add_artist_caps() {
    if ( current_user_can('artist') && !current_user_can('upload_files') ){
        $artist = get_role('artist');
        $artist->add_cap('upload_files');
    }
}
add_action( 'init', 'miraculous_add_artist_caps');

/**
 * miraculous Restrict artist to shows only own media
 */
add_filter( 'ajax_query_attachments_args', 'miraculous_show_current_artist_attachments' );
 
function miraculous_show_current_artist_attachments( $query ) {
    $current_user = wp_get_current_user();

    if ( $current_user && in_array('artist', $current_user->roles) ) {
        $query['author'] = $current_user->ID;
    }
    return $query;
}


/*##### get YouTube Video Id #######*/
function getYouTubeVideoId($pageVideUrl) {
    $link = $pageVideUrl;
    $video_id = explode("?v=", $link);
    if (!isset($video_id[1])) {
        $video_id = explode("youtu.be/", $link);
        
    }
    if (!isset($video_id[1])) {
        $video_id = explode("embed/", $link);
        
    }
    
    $youtubeID = $video_id[1];
    if (empty($video_id[1])) $video_id = explode("/v/", $link);
    $video_id = explode("&", $video_id[1]);
    $youtubeVideoID = $video_id[0];
    if ($youtubeVideoID) {
        return $youtubeVideoID;
    } else {
        return false;
    }
}


// function to display number of Visitors.
function getUserProfileVisitors($userid){

    $count_key = 'visitors_count';
    $count = get_user_meta($userid, $count_key, true);
    if($count==''){
        $count = 0;
    }

    return $count;
}
 
// function to count Visitors.
function setUserProfileVisitorss($userid) {
    $count_key = 'visitors_count';
    $count = get_user_meta($userid, $count_key, true);
    if($count==''){
        $count = 0;
        delete_user_meta($userid, $count_key);
        add_user_meta($userid, $count_key, '0');
    }else{
        $count++;
        update_user_meta($userid, $count_key, $count);
    }
  
}

/*#############################################*/
############## Template for admin playlist #########
################################################
//include 'playlist/playlist.php';
require_once 'cpt/child-miraculous-custom-posttype.php';
require_once 'cpt/pagination.php';
require_once 'class/class-message.php';
require_once 'class/class-subscription.php';

/* for users playlis */
if(!function_exists('get_users_playlist')){
    function get_users_playlist($user_id = null){
        $playlist_key = array();
        
        if($user_id){
            $playlists = get_user_meta($user_id);
            $user_playlist_key = "miraculous_playlist_";
                    
            foreach ($playlists as $playlists_key => $playlist) {
                
                if (strpos($playlists_key, $user_playlist_key) !== false) {
                    $playlist_key[] = $playlists_key;
                }
            }
        }else{
            $users = get_users();
            
            foreach ($users as $user_key => $user) {
                $playlists = get_user_meta($user->ID);
                $user_playlist_key = "miraculous_playlist_";
                
                foreach ($playlists as $playlists_key => $playlist) {
                    
                    if (strpos($playlists_key, $user_playlist_key) !== false) {
                        $playlist_key[] = $playlists_key;
                    }
                }

            }
            
        }
        if(!empty($playlist_key)){
            return $playlist_key;
        }else{
            return array('msg'=>'No Playlist Found');
        }
        

    }
}

if(!function_exists('get_timeago')){
	function get_timeago($date) {
	   $timestamp = strtotime($date);	
	   
	   $strTime = array("second", "minute", "hour", "day", "month", "year");
	   $length = array("60","60","24","30","12","10");

	   $currentTime = time();
	   if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			return $diff . " " . $strTime[$i] . "(s) ago ";
	   }
	}
}


	add_filter( 'admin_post_thumbnail_html', 'add_new_releases_cover_image_html');
	function add_new_releases_cover_image_html( $html ) {
	    if('new-releases'== get_post_type()){
	         $html .= '<p>The Cover Image should be at least 710 X 316px</p>';
	    }
	    return $html;
	}


	// for theme option by ACF
	if( function_exists('acf_add_options_page') ) {
	    
	    acf_add_options_page();
	    
	}

	/* Get all Music of artists*/
	 if(!function_exists('get_all_music_post_name_for_artist')){
	     function get_all_music_post_name_for_artist($artist_id){

	         $music_id = array();
	         $m_args = array('post_type' => 'ms-music', 'numberposts' => -1);
	         $music_posts = get_posts($m_args);
	         
	         foreach ($music_posts as $music_post) {
	          $artists_ids = get_post_meta($music_post->ID, 'fw_option:music_artists', true);
	          if( $artists_ids && in_array($artist_id, $artists_ids) ): 

	                $music_id[] = $music_post->ID;

	              endif;
	            }
	            return $music_id;
	    }

	 }

	/* Get all Music of Albums*/
	 if(!function_exists('get_all_albums_post_name_for_artist')){
	     function get_all_albums_post_name_for_artist($artist_id){

	         $album_id = array();
	         $m_args = array('post_type' => 'ms-albums', 'numberposts' => -1);
	         $album_posts = get_posts($m_args);
	         
	         foreach ($album_posts as $album_post) {
	          $artists_ids = get_post_meta($album_post->ID, 'album_artists', true);
	          if( $artists_ids && in_array($artist_id, $artists_ids) ): 

	                $album_id[] = $album_post->ID;

	              endif;
	            }
	            return $album_id;
	    }

	 }

/*#############################################*/
############## user register form #########
################################################

	add_action('wp_ajax_miraculous_child_user_register_form', 'miraculous_child_user_register_form');
	add_action('wp_ajax_nopriv_miraculous_child_user_register_form', 'miraculous_child_user_register_form');


	function miraculous_child_user_register_form() {

	    $error = array();

	    if( isset($_POST['username']) && isset($_POST['full_name']) && isset($_POST['useremail']) && isset($_POST['password']) && isset($_POST['confirmpass']) ) {

	        extract($_POST);

	         $user_genres = ($_POST['user_genres']!='') ? serialize(explode(',',$_POST['user_genres'])) : '';
	         

	                

	        if( ! validate_username($username) ) {
	            $error['erroruser'] = "* Username is not valid. Use only lowercase letter!";
	        }

	        if( username_exists($username) ) {
	            $error['erroruser'] = "* Username is already exist!";
	        }

	        if( email_exists($useremail) ) {
	            $error['erroremail'] = "* Email is already exist!"; 
	        }

	        if( empty($error) ) {
	            $userdata = array(

	                'user_login' => $username,
	                'user_pass' => $password,
	                'first_name' => $full_name,
	                'last_name' => $last_name,
	                'role' => $who_i_am,
	                'user_email' => $useremail

	            );


	            $user_id = wp_insert_user( $userdata );

	            //On success
	            
	            if ( ! is_wp_error( $user_id ) ) {

	            	child_miraculous_new_user_notification( $user_id, $password );

	                add_user_meta( $user_id, 'user_genres', $user_genres);
	                if($who_i_am == 'artist'){
	                  $post = array(
	                                'post_title'    => $full_name.' '.$last_name,
	                                'post_content'  => '',
	                                'post_status'   => 'draft',         // Choose: publish, preview, future, etc.
	                                'post_author'   => $user_id,         // Choose: publish, preview, future, etc.
	                                'post_type'     => 'ms-artists'  // Use a custom post type if you want to
	                                );
	                    $artist_id = wp_insert_post($post);
	                    add_user_meta( $user_id, '_user_artist_id', $artist_id);

	                    $genres_ids = array();
	                        if(!empty($user_genres)){
	                           $user_genres = explode(',',$_POST['user_genres']);
	                            foreach ($user_genres as $key => $value) {
	                                $term = get_term_by('slug', $value, 'genre'); 
	                                $name = $term->name; 
	                                $genres_ids[] = $term->term_id;
	                            }
	                            
	                        }
	                    if(!empty($genres_ids)){
	                        
	                        $term_taxonomy_ids = wp_set_object_terms($artist_id, $genres_ids, 'genre' );
	                        
	                    }
	                    
	                    
	                }
	                

	                $data = array('status' => 'true', 'msg' => 'You are successfully registered. Please login');

	                echo json_encode($data);

	            }else{

	                $data = array('status' => 'false', 'msg' => 'Something went wrong. Please try again.');
	                echo json_encode($data);
	            }

	        }else{

	            $error['status'] = 'false';
	            echo json_encode($error);

	        }
	        die();
	    }

	}

/*#############################################*/
############## user login form #########
################################################
	add_action('wp_ajax_chiild_miraculous_user_login_form', 'chiild_miraculous_user_login_form');
	add_action('wp_ajax_nopriv_chiild_miraculous_user_login_form', 'chiild_miraculous_user_login_form');
	function chiild_miraculous_user_login_form(){

		if( isset($_POST['username']) && isset($_POST['password']) ) {
			extract($_POST);

			if($rem_check) {

				$rem = true;

			}else{

				$rem = false;

			}


			if( is_user_logged_in() ) {

				$data = array('status' => 'false', 'msg' => 'You are already logged in!');

			}else{

				$creds = array();

				$creds['user_login'] = $username;

				$creds['user_password'] = $password;

				$creds['remember'] = $rem;

				$user = wp_signon( $creds, true );

				if ( is_wp_error($user) ) {

					$error = esc_html__('Incorrect login details.', 'miraculous');

					$data = array('status' => 'false', 'msg' => $error);

				}else{

					$url = site_url();

					$data = array('status' => 'true', 'msg' => 'Login Successfully', 'redirect_uri' => $url);

				}

			}


			echo json_encode($data);

			die();
		}

		$data = array('status' => 'false', 'msg' => 'Something went wrong. Please try again.');

		echo json_encode($data);

		die();
	}


/*#############################################*/
############## Rewrite Rule for Visitor profile #########
################################################

	function profile_rewrite_tag() {
	  add_rewrite_tag('%username%', '([^&]+)');
	}
	add_action('init', 'profile_rewrite_tag', 10, 0);

	function profile_rewrite_rule() {
	    add_rewrite_rule('^users-profile/([^/]*)/?','index.php?page_id=2446&username=$matches[1]','top');
	}
	add_action('init', 'profile_rewrite_rule', 10, 0);

/*#############################################*/
############## Rewrite Rule for login user profile #########
################################################

	function user_profile_rewrite_tag() {
	  add_rewrite_tag('%tab%', '([^&]+)');
	}
	add_action('init', 'user_profile_rewrite_tag', 10, 0);

	function user_profile_rewrite_rule() {
	    add_rewrite_rule('^profile/([^/]*)/?','index.php?page_id=187&tab=$matches[1]','top');
	}
	add_action('init', 'user_profile_rewrite_rule', 10, 0);

	
/*#############################################*/
############## Rewrite Rule for News Category #########
################################################

	function news_type_rewrite_action() {
	  add_rewrite_tag('%type%','([^/]*)');
	  add_rewrite_rule(
	    '^news/([^/]+)$',
	    'index.php?page_id=2498&type=$matches[1]',
	    'top');
	  add_rewrite_rule(
	    '^news/([^/]+)/page/([^/]+)$',
	    'index.php?page_id=2498&type=$matches[1]&paged=$matches[2]',
	    'top');
	}
	add_action( 'init', 'news_type_rewrite_action' );


	add_action('wp_ajax_user_follow_unfollow', 'user_follow_unfollow');
	add_action('wp_ajax_nopriv_user_follow_unfollow', 'user_follow_unfollow');


	function user_follow_unfollow() {

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['fid']) && $userid) {

	        $fid = array();

	        $fid[] = $_POST['fid'];

	        $following_users = get_user_meta($userid, 'following_users'.$userid, true);
	        $follower_users = get_user_meta($_POST['fid'], 'follower_users'.$_POST['fid'], true);
	        // echo "<pre>";
	        // print_r($following_users);
	        // die();

	        if($following_users) {

	            if( in_array($_POST['fid'], $following_users) ) {
	                $key = array_search($_POST['fid'], $following_users); 
	                unset($following_users[$key]);
	                $new_arr = array_values($following_users);
	                update_user_meta($userid, 'following_users'.$userid, $new_arr);
	                
	                $follower_user_key = array_search($userid, $follower_users);
	                unset($follower_users[$follower_user_key]);
	                $new_follower = array_values($follower_users);
	                update_user_meta($_POST['fid'], 'follower_users'.$_POST['fid'], $new_follower);

	                $follower_count = count(get_user_meta($_POST['fid'], 'follower_users'.$_POST['fid'], true));
	                $message['status'] = esc_html__('success','miraculous');
	                $message['action'] = esc_html__('removed','miraculous');
	                $message['msg'] = esc_html__('Unfollowed successfully','miraculous');
	                $message['followers'] = $follower_count;

	            }else{
	                $new_arr = array_merge($following_users, $fid);
	                update_user_meta($userid, 'following_users'.$userid, $new_arr);

	                $new_follower = array_merge($follower_users,array($userid));
	                update_user_meta($_POST['fid'], 'follower_users'.$_POST['fid'], $new_follower);
	                $follower_count = count(get_user_meta($_POST['fid'], 'follower_users'.$_POST['fid'], true));

	                $message['status'] = esc_html__('success','miraculous');
	                $message['action'] = esc_html__('added','miraculous');
	                $message['msg'] = esc_html__('Followed successfully','miraculous');
	                $message['followers'] = $follower_count;

	            }

	        }else{

	            update_user_meta($userid, 'following_users'.$userid, $fid);

	            if(!in_array($userid, $follower_users) ) {

	                if(!empty($follower_users)){
	                    $new_follower = array_merge($follower_users,array($userid));
	                }else{
	                    $new_follower =array($userid);
	                }
	                

	                update_user_meta($_POST['fid'], 'follower_users'.$_POST['fid'], $new_follower);
	                $follower_count = count(get_user_meta($_POST['fid'], 'follower_users'.$_POST['fid'], true));
	            }

	            $message['status'] = esc_html__('success','miraculous');
	            $message['msg'] = esc_html__('Followed successfully','miraculous');
	            $message['followers'] = $follower_count;

	        }
	        
	        echo json_encode($message);
	        die();
	    }


	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login.','miraculous');

	    echo json_encode($message);

	    die();

	}



 /*#############################################*/
############## User profile update  #########
################################################

	add_action( 'wp_ajax_child_miraculous_user_update_form','child_miraculous_user_update_form');

	add_action( 'wp_ajax_nopriv_child_miraculous_user_update_form', 'child_miraculous_user_update_form');

	function child_miraculous_user_update_form() {


		$error = array();

		if( isset($_POST)) {

		    extract($_POST);
		    $current_user = wp_get_current_user();

		           
		    if( isset($password) && isset($old_password) && $password != '' && $old_password != '' ) {

		        if (!wp_check_password( $old_password, $current_user->user_pass, $current_user->ID ) ) {
		            $error['status'] = 'false';
		            $error['msg'] = "Old password is incorect";
		        } 

		    }

		    $full_name = explode(' ', $first_name);
		    $fname = $full_name[0];
		    unset($full_name[0]);
		    $last_name = implode(' ', $full_name);


		    if( empty($error) ) {
		    	if($password==$old_password){
		    		$error['status'] = 'false';
		            $error['msg'] = "Sorry New password cannot be same as Old password'";
		    		
		    		echo json_encode($error);

		        }else{
			        if( isset($password) && isset($old_password) && $password != '' && $old_password != '' ) {
			            $userdata = array(
			              'ID' => $current_user->ID,
			              'user_pass' => $password,
			              'first_name' => $fname,
			              'last_name' => $last_name,
			              'display_name' => $first_name
			            );
			        }	
			        else{
			            $userdata = array(
			              'ID' => $current_user->ID,
			              'first_name' => $fname,
			              'last_name' => $last_name,
			              'display_name' => $first_name
			            );
			        }
			        $user_id = wp_update_user($userdata);
			        //On success
			        if ( ! is_wp_error( $user_id ) ) {
			            $user_genres = ($_POST['user_genres']!='') ? serialize(explode(',',$_POST['user_genres'])) : '';
			            if(current_user_can('artist') && $profile_img_id!=''){
			            	$artist_id = get_user_meta($user_id,'_user_artist_id',true);
			            	set_post_thumbnail( $artist_id, $profile_img_id );
			            }
			            update_user_meta($user_id, 'user_profile_img', $profile_img);
			            update_user_meta($user_id, 'description', $description);
			            update_user_meta($user_id, 'billing_country', $country);
			            update_user_meta($user_id, 'user_gender', $user_gender);
			            update_user_meta($user_id, 'user_genres', $user_genres);

			            $data = array('status' => 'true', 'msg' => 'Profile Successfully update');

		             	echo json_encode($data);

			        }else{

			        $data = array('status' => 'false', 'msg' => 'Something went wrong. Please try again.');

			            echo json_encode($data);

			        }
			    }

		    }else{

		        echo json_encode($error);

		    }


		    die();

		}

	}

	add_action( 'after_password_reset', 'action_function_name_1707', 10, 2 );
     function action_function_name_1707( $user, $new_pass ){
     			update_user_meta(1, 'test', 'test.test');


}

/*############### remove from user playlist songs list #####################*/
	add_action( 'wp_ajax_child_miraculous_remove_from_user_playlist_songs_list','child_miraculous_remove_from_user_playlist_songs_list');

	add_action( 'wp_ajax_nopriv_child_miraculous_remove_from_user_playlist_songs_list','child_miraculous_remove_from_user_playlist_songs_list');

	function child_miraculous_remove_from_user_playlist_songs_list(){

	$message = array();

	$userid = get_current_user_id();

	if (isset($_POST['songid']) && isset($_POST['playlist']) && $userid) {

	    $songs = array();



	    $songs[] = $_POST['songid'];
	    $playlist_key = 'miraculous_playlist_'.$userid.'_'.$_POST['playlist']; 

	    $music_id = get_user_meta($userid, $playlist_key, true);



	    if( $music_id ) {

	        if( in_array($_POST['songid'], $music_id) ) {

	            $key = array_search($_POST['songid'], $music_id); 



	            unset($music_id[$key]);

	            $new_arr = array_values($music_id);

	            update_user_meta($userid, $playlist_key, $new_arr);

	            $message['total_song'] = count(get_user_meta($userid, $playlist_key, true));
	            $message['status'] = 'success';

	            $message['msg'] = 'Removed successfully';

	        }

	    }

	    echo json_encode($message);

	    die();

	}



	$message['status'] = esc_html__('error','miraculous');

	$message['msg'] = esc_html__('You need to login','miraculous');

	echo json_encode($message);

	die();

	}
/*###############  remove from favourites albums list #####################*/
	add_action( 'wp_ajax_child_miraculous_remove_from_favourites_albums_list','child_miraculous_remove_from_favourites_albums_list');

	add_action( 'wp_ajax_nopriv_child_miraculous_remove_from_favourites_albums_list','child_miraculous_remove_from_favourites_albums_list');

	function child_miraculous_remove_from_favourites_albums_list(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['albumsid']) && $userid) {

	        $albums_data = get_user_meta($userid, 'favourites_albums_lists'.$userid, true);

	        if( $albums_data ) {

	            if( in_array($_POST['albumsid'], $albums_data) ) {

	                $key = array_search($_POST['albumsid'], $albums_data); 

	                unset($albums_data[$key]);

	                $new_arr = array_values($albums_data);

	                update_user_meta($userid, 'favourites_albums_lists'.$userid, $new_arr);

	                $message['status'] = 'success';

	                $message['msg'] = 'Removed successfully';

	            }

	        }

	        echo json_encode($message);

	        die();

	    }



	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();

	}

    /*############   remove from favourites artist list #####################*/
	add_action( 'wp_ajax_child_miraculous_remove_from_favourites_artist_list','child_miraculous_remove_from_favourites_artist_list');

	add_action( 'wp_ajax_nopriv_child_miraculous_remove_from_favourites_artist_list','child_miraculous_remove_from_favourites_artist_list');

	function child_miraculous_remove_from_favourites_artist_list(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['artistid']) && $userid) {

	        $artistid = array();

	        $artistid[] = $_POST['artistid'];

	        $artists_lists = get_user_meta($userid, 'favourites_artists_lists'.$userid, true);



	        if( $artists_lists ) {

	            if( in_array($_POST['artistid'], $artists_lists) ) {

	                $key = array_search($_POST['artistid'], $artists_lists); 



	                unset($artists_lists[$key]);

	                $new_arr = array_values($artists_lists);

	                update_user_meta($userid, 'favourites_artists_lists'.$userid, $new_arr);

	                
	                $message['status'] = 'success';

	                $message['msg'] = 'Removed successfully';

	            }

	        }

	        echo json_encode($message);

	        die();

	    }



	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();

	}


    /*############   remove from favourites radio list #####################*/
	add_action( 'wp_ajax_miraculous_remove_from_favourites_radio_list','miraculous_remove_from_favourites_radio_list');

	add_action( 'wp_ajax_nopriv_miraculous_remove_from_favourites_radio_list','miraculous_remove_from_favourites_radio_list');

	function miraculous_remove_from_favourites_radio_list(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['radioid']) && $userid) {

	        $radioid = array();

	        $radioid[] = $_POST['radioid'];

	        $radioid_lists = get_user_meta($userid, 'favourites_radios_lists'.$userid, true);



	        if( $radioid_lists ) {

	            if( in_array($_POST['radioid'], $radioid_lists) ) {

	                $key = array_search($_POST['radioid'], $radioid_lists); 



	                unset($radioid_lists[$key]);

	                $new_arr = array_values($radioid_lists);

	                update_user_meta($userid, 'favourites_radios_lists'.$userid, $new_arr);

	                
	                $message['status'] = 'success';

	                $message['msg'] = 'Removed successfully';

	            }

	        }

	        echo json_encode($message);

	        die();

	    }



	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();

	}

	add_action( 'wp_ajax_child_miraculous_download_song_pagination','child_miraculous_download_song_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_download_song_pagination','child_miraculous_download_song_pagination');

	function child_miraculous_download_song_pagination(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['offset']) && isset($_POST['offset']) && $userid) {

	    	$download_limit = $_POST['limit'];
	        $download_offset = $_POST['offset'];


		   $free_downloaded = !empty(get_user_meta($userid, 'free_downloaded_songs_by_user_'.$userid, true)) ? get_user_meta($userid, 'free_downloaded_songs_by_user_'.$userid, true) : array();
		   $premium_downloaded = !empty(get_user_meta($userid, 'premium_downloaded_songs_by_user_'.$userid, true)) ? get_user_meta($userid, 'premium_downloaded_songs_by_user_'.$userid, true) : array();

		   $downloaded = array_merge($free_downloaded,$premium_downloaded);

		   $downloaded = !empty($downloaded) ? array_slice($downloaded,$download_offset,$download_limit) : array();

		   $miraculous_theme_data = '';
		   if (function_exists('fw_get_db_settings_option')):  
		    $miraculous_theme_data = fw_get_db_settings_option();     
		   endif;

		   $currency = '';
		   if(!empty($miraculous_theme_data['paypal_currency']) && function_exists('miraculous_currency_symbol')):
		     $currency = miraculous_currency_symbol( $miraculous_theme_data['paypal_currency'] );
		   endif;

		   	foreach ($downloaded as $key => $download) :
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id($download), 'thumbnail' );

                  $music_price = '';
                  if(function_exists('fw_get_db_post_option')){
                    $music_price_arr = fw_get_db_post_option($download, 'music_type_options');
                    if( !empty( $music_price_arr['premium']['single_music_price'] ) ){
                        $music_price = $music_price_arr['premium']['single_music_price'];
                    }
                  }

                  $attach_music = array();
                  $mpurl = get_post_meta($download, 'fw_option:mp3_full_songs', true);
                  if($mpurl) {
                    $attach_music = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                  }

                  $music_type = get_post_meta($download, 'fw_option:music_type', true);
            ?>
            <li class="tr">
               <div class="cell cell-title">
                  <div class="ttl">
                     <strong class="name"><?php echo get_the_title($download);?></strong>
                     <?php if(!empty($image)):?>
                     <img src="<?php echo $image[0];?>" alt="album photo" width="26" height="26">
                   <?php endif?>
                  </div>
               </div>
               <!-- <div class="cell">
                  <time datetime="2014-01-12">12.01.2014</time>
               </div> -->
               <div class="cell">
               <?php if(empty($music_price)): ?>
                  <span><?php esc_html_e('Free', 'miraculous'); ?></span>
               <?php else: ?>
                  <span><?php printf( __('%s%s', 'miraculous'), $currency, $music_price ); ?></span>
              <?php endif;?>
               </div>
               <div class="cell">
                  <span class="time"><?php echo (isset($attach_music['length_formatted'])) ? $attach_music['length_formatted'] : " "; ?></span>
               </div>
               <div class="cell">
                  <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($download); ?>" data-musictype="music">
                  <span class="play_all btn-play">Play All</span>
                  <span class="pause_all btn-pause">Pause</span>
                  </a>
               </div>
            </li>
         <?php endforeach;

	        die();

	    }



	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();
	}

	add_action( 'wp_ajax_child_miraculous_favorites_artist_pagination','child_miraculous_favorites_artist_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_favorites_artist_pagination','child_miraculous_favorites_artist_pagination');

	function child_miraculous_favorites_artist_pagination(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['offset']) && isset($_POST['offset']) && $userid) {

	        $artists = get_user_meta($userid, 'favourites_artists_lists'.$userid, true);

	         $artist_limit = $_POST['limit'];
	        
	         $artist_offset = $_POST['offset'];

	        $artists = array_slice($artists,$artist_offset,$artist_limit);

	          foreach ($artists as $artist_key => $artist) :

	           $artist_music = get_all_music_post_name_for_artist($artist);
	        ?>
	        <li class="artist-<?php echo $artist;?>">
	           <div class="title">
	              <strong class="name"><?php echo get_the_title($artist);?></strong>
	              <div class="cell">
	                 <span class="number"><?php echo count($artist_music);?>  Songs</span>
	                 <a href="#" class="button delete_favourite_artist" artistid="<?php echo $artist;?>">DELETE</a>
	                 <a href="#" class="button opener">VIEW</a>
	              </div>
	           </div>
	           <?php if(!empty($artist_music)):?>
	           <div class="slide">
	              <div class="albums-table">
	                 
	                 <ol class="row-group">
	                 <?php 

	                    foreach ($artist_music as $music_key => $music) {
	                       $attach_music = array();
	                          $mpurl = get_post_meta($music, 'fw_option:mp3_full_songs', true);
	                      if($mpurl) {
	                        $attach_music = wp_get_attachment_metadata( $mpurl['attachment_id'] );
	                      }
	                      
	                      $music_image = wp_get_attachment_image_src( get_post_thumbnail_id($music), 'thumbnails' );
	                 ?>
	                    <li class="tr">
	                       <div class="cell cell-title">
	                          <div class="ttl">
	                             <strong class="name"><?php echo get_the_title($music);?></strong>
	                             <?php if($music_image!=''){?>
	                             <img src="<?php echo $music_image[0];?>" alt="album photo" width="26" height="26">
	                             <?php } ?>
	                          </div>
	                       </div>
	                       
	                       <div class="cell">
	                          <span class="time"><?php echo (isset($attach_music['length_formatted'])) ? $attach_music['length_formatted'] : " "; ?></span>
	                       </div>
	                       <div class="cell">
	                          <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($music); ?>" data-musictype="music">
	                             <span class="play_all btn-play">Play All</span>
	                             <span class="pause_all btn-pause">Pause</span>
	                          </a>
	                       </div>
	                    </li>
	                 <?php }?>
	                 </ol>
	              </div>
	           </div>
	        <?php endif;?>
	        </li>
	     <?php endforeach;

	        die();

	    }



	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();
	}

	add_action( 'wp_ajax_child_miraculous_favorites_albums_pagination','child_miraculous_favorites_albums_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_favorites_albums_pagination','child_miraculous_favorites_albums_pagination');

	function child_miraculous_favorites_albums_pagination(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['offset']) && isset($_POST['offset']) && $userid) {

	        $albums = get_user_meta($userid, 'favourites_albums_lists'.$userid, true);

	         $albums_limit = $_POST['limit'];
	        
	         $albums_offset = $_POST['offset'];

	        $albums = array_slice($albums,$albums_offset,$albums_limit);

	        
	        //$message['albums'] = '';
	        ?>
	        <?php
	          foreach ($albums as $album_key => $album) :
	           if( function_exists('fw_get_db_post_option') ):
	              $ms_album_post_meta_option = fw_get_db_post_option($album);
	           endif;
	           
	           $album_songs = $ms_album_post_meta_option['album_songs'];



	     ?>
	         <li class="albums-<?php echo $album;?>">
	           <div class="title">
	              <strong class="name"><?php echo get_the_title($album);?></strong>
	              <div class="cell">
	                 <span class="number"><?php echo count($album_songs);?>  Songs</span>
	                 <a href="javascript:;" class="button delete_favourite_albums" albumsid="<?php echo $album;?>">DELETE</a>
	                 <a href="#" class="button opener">VIEW</a>
	              </div>
	           </div>
	           <?php if(!empty($album_songs)):?>
	           <div class="slide">
	              <div class="albums-table">
	                 <div class="tr head">
	                    <div class="cell">Songs</div>
	                    <div class="cell"></div>
	                    <div class="cell">TIME</div>
	                    <div class="cell"></div>
	                 </div>
	                 <ol class="row-group">
	                 <?php
	                    //$i = 1;
	                    foreach($album_songs as $mst_music_option): 
	                      $attach_song = array();
	                          $mpurl = get_post_meta($mst_music_option, 'fw_option:mp3_full_songs', true);
	                      if($mpurl) {
	                        $attach_song = wp_get_attachment_metadata( $mpurl['attachment_id'] );
	                      }
	                      
	                      $music_images = wp_get_attachment_image_src( get_post_thumbnail_id($mst_music_option), 'thumbnails' );
	           

	                 ?>
	                    <li class="tr">
	                       <div class="cell cell-title">
	                          <div class="ttl">
	                             <strong class="name"><?php echo get_the_title($mst_music_option);?></strong>
	                             <?php if($music_image!=''){?>
	                             <img src="<?php echo $music_images[0];?>" alt="album photo" width="26" height="26">
	                             <?php } ?>
	                          </div>
	                       </div>
	                       
	                       <div class="cell">
	                          <span class="time"><?php echo (isset($attach_song['length_formatted'])) ? $attach_song['length_formatted'] : " "; ?></span>
	                       </div>
	                       <div class="cell">
	                          <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
	                             <span class="play_all btn-play">Play All</span>
	                             <span class="pause_all btn-pause">Pause</span>
	                          </a>
	                       </div>
	                    </li>
	                 <?php 
	                    //$i++; 
	                    endforeach; 

	                 ?>
	                 </ol>
	              </div>
	           </div>
	        <?php endif; ?>
	        </li>
	    <?php endforeach;?>
	    <?php

	        die();

	    }



	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();

	}

	add_action( 'wp_ajax_child_miraculous_favorites_playlist_songs_pagination','child_miraculous_favorites_playlist_songs_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_favorites_playlist_songs_pagination','child_miraculous_favorites_playlist_songs_pagination');

	function child_miraculous_favorites_playlist_songs_pagination(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['offset']) && isset($_POST['offset']) && $userid) {

	        $songs = get_user_meta($userid, 'favourites_songs_lists'.$userid, true);

	         $songs_limit = $_POST['limit'];
	        
	         $songs_offset = $_POST['offset'];

	        $songs = array_slice($songs,$songs_offset,$songs_limit);

	        
	        $message['songs'] = '';
	        foreach ($songs as $song_key => $song) :
	            $ms_album_post_meta_option = '';
	            if( function_exists('fw_get_db_post_option') ):
	              $ms_album_post_meta_option = fw_get_db_post_option($song);
	            endif;


	            $attach_meta = array();
	            $mpurl = get_post_meta($song, 'fw_option:mp3_full_songs', true);
	            if($mpurl) {
	              $attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
	            }
	            $duration = isset($attach_meta['length_formatted']) ? $attach_meta['length_formatted'] : " ";

	           $message['songs'] .= '<li class="fav_music_'.$song.'">
	               <div class="title">
	                  <strong class="name">'.get_the_title($song).'</strong>
	                  <div class="cell">
	                     <span class="time">'.$duration.'</span>
	                     <a href="javascript:;" class="button delete_favourite_music" musicid="'.$song.'">DELETE</a>
	                     <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="'.$song.'" data-musictype="music">
	                      <span class="play_all btn-play">Play All</span>
	                      <span class="pause_all btn-pause">Pause</span>
	                     </a>
	                  </div>
	               </div>
	               
	            </li>';
	        endforeach;


	        $message['status'] = 'success';
	        $message['msg'] = 'Add successfully';

	        echo json_encode($message);

	        die();

	    }

	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();

	}

/*############ radio pagination ####################*/
	add_action( 'wp_ajax_child_miraculous_favorites_radios_pagination','child_miraculous_favorites_radios_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_favorites_radios_pagination','child_miraculous_favorites_radios_pagination');

	function child_miraculous_favorites_radios_pagination(){

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['offset']) && isset($_POST['offset']) && $userid) {

	        $radios = get_user_meta($userid, 'favourites_radios_lists'.$userid, true);

	         $radio_limit = $_POST['limit'];
	        
	         $radio_offset = $_POST['offset'];

	        $radios = !empty($radios) ? array_slice($radios,$radio_offset,$radio_limit) : array();
	        
	        $message['radios'] = '';
	        foreach ($radios as $radio_key => $radio) :
	            $message['radio'].= '<li class="fav_music_'.$radio.'">
               <div class="title">
                  <strong class="name">'.get_the_title($radio).'</strong>
                  <div class="cell">
                     
                     <a href="javascript:;" class="button delete_favourite_radio" musicid="'.$radio.'">DELETE</a>
                     <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="'.$radio.'" data-musictype="radio">
                     <span class="play_all btn-play">Play All</span>
                     <span class="pause_all btn-pause">Pause</span>
                     </a>
                  </div>
               </div>
            </li>';
	        endforeach;


	        $message['status'] = 'success';
	        $message['msg'] = 'Add successfully';

	        echo json_encode($message);

	        die();

	    }

	    $message['status'] = esc_html__('error','miraculous');

	    $message['msg'] = esc_html__('You need to login','miraculous');

	    echo json_encode($message);

	    die();

	}


	add_action( 'wp_ajax_child_miraculous_artist_begins_with_a_specific_letter','child_miraculous_artist_begins_with_a_specific_letter');

	add_action( 'wp_ajax_nopriv_child_miraculous_artist_begins_with_a_specific_letter','child_miraculous_artist_begins_with_a_specific_letter');

	function child_miraculous_artist_begins_with_a_specific_letter(){

	    $message = array();

	    if (isset($_POST['search_data'])) {

	        
	        if($_POST['search_data'] == 'All'){
	            $search_data = '';
	        }else{
	            $search_data = $_POST['search_data'];
	        }
	        $arg = array(
	            'posts_per_page'=>-1,
	            'post_type'=>'ms-artists',
	            'starts_with' => $search_data,
	            'post_status' => 'publish',
	            'orderby'     => 'title', 
	            'order'       => 'ASC',
	            
	        );
	        $artist_query = new WP_Query($arg);

	        if ( $artist_query->have_posts() ) :
	            echo '<ul>';
	            while ( $artist_query->have_posts() ) : $artist_query->the_post();
	                
	                echo '<li><a href="'.get_the_permalink().'"><span>'.get_the_title().'</span></a></li>';
	        
	           endwhile;
	           echo '</ul>';
	        else:
	           echo '<p class="no-found">No Artist Found.</p>';
	        endif;

	    }
	    
	    die();
	}


	function where_title_begins_with_a_specific_letter_posts_where( $where, $query ) {
	    global $wpdb;

	    $starts_with = $query->get( 'starts_with' );

	    if ( $starts_with ) {
	    	if($starts_with == '0-9'){
	    		$where .= " AND $wpdb->posts.post_title REGEXP '^[0-9\$\@\!\?\%]'";
	    	}else{
	    		$where .= " AND $wpdb->posts.post_title LIKE '$starts_with%'";
	    	}
	        
	    }

	    return $where;
	}
	add_filter( 'posts_where', 'where_title_begins_with_a_specific_letter_posts_where', 10, 2 );

/*############## for dispaly spotlights as per spotlight type #########################*/
	add_action( 'wp_ajax_child_miraculous_spotlight_as_per_category','child_miraculous_spotlight_as_per_category');

	add_action( 'wp_ajax_nopriv_child_miraculous_spotlight_as_per_category','child_miraculous_spotlight_as_per_category');

	function child_miraculous_spotlight_as_per_category(){

	    $message = array();

	    if (isset($_POST['spotlight_type'])) {

	        
	        if($_POST['spotlight_type'] == 'All'){
	            $spotlight_type = '';
	            $spotlight_name = 'All';
	        }else{
	            $spotlight_type = $_POST['spotlight_type'];
	            $spotlight_name = ucwords($spotlight_type);
	        }
	            echo '<div class="section-header"><h2>'.$spotlight_name.'</h2></div>';
	        
	                          
	                          $arg = array(
	                          'posts_per_page'=>-1,
	                          'post_type'=>'ms-spotlight',
	                          'post_status' => 'publish',
	                          'orderby'     => 'title', 
	                          'order'       => 'ASC',
	                          'tax_query' => array(
	                                                array(
	                                                    'taxonomy' => 'spotlight-type',
	                                                    'field' => 'slug',
	                                                    'terms' => $spotlight_type
	                                                )
	                                             ),
	                          
	                          );

	                          $spotlight_query = new WP_Query($arg);
	                          
	                          if ( $spotlight_query->have_posts() ) :
	                       echo '<ul class="media-list">';
	                        while ( $spotlight_query->have_posts() ) : $spotlight_query->the_post();
	                        $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );
	                             
	                        
	                        echo '<li>
	                             <a href="#" class="img-box">';
	                             if(!empty($image)):
	                               echo '<img src="'.$image[0].'" alt="video image" width="150" height="142">';
	                             endif;
	                               echo '<span class="btn-play">Play</span>
	                               </a>
	                             <div class="text-holder">
	                                <strong class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></strong>

	                                <strong class="category"><a href="javascript:;">'.get_the_term_list(get_the_id(), 'spotlight-type', '', ', ' ).'</a></strong>
	                             </div>
	                          </li>';
	                      endwhile;
	                       echo '</ul>';
	                       
	                          else:
	                             echo '<p class="no-found">No spotlight Found.</p>';
	                          endif;
	                    
	                 wp_reset_postdata(); 

	    }
	    
	    die();
	}



/*###################### Artist Albums Pagination################################*/

	add_action( 'wp_ajax_child_miraculous_artist_albums_pagination','child_miraculous_artist_albums_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_artist_albums_pagination','child_miraculous_artist_albums_pagination');

	function child_miraculous_artist_albums_pagination(){


	    if (isset($_POST['offset']) && isset($_POST['limit']) && isset($_POST['post_id'])) {

	        $artist_albums = get_all_albums_post_name_for_artist($_POST['post_id']);

	         $ar_album_limit = $_POST['limit'];
	        
	         $ar_album_offset = $_POST['offset'];

	        $artist_albums = !empty($artist_albums) ? array_slice($artist_albums,$ar_album_offset,$ar_album_limit) : array();

	        
	          if(!empty($artist_albums)):
	            foreach ($artist_albums as $album_key => $artist_album) {
	            $album_image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_album), 'thumbnail' );
	          ?>
	            
	           <div class="album-item">
	              <div class="head-holder">
	                 <h3><?php echo get_the_title($artist_album)?></h3>
	                 <div class="cell">
	                    <div class="menu-box">
	                       <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
	                       <div class="menu-drop">
	                          <div class="drop-holder">
	                             <ul class="drop-list">
	                             <li><a href="javascript:;" class="favourite_albums" data-albumid="<?php echo $artist_album;?>">Add To Favorite</a></li>
	                             <li>
	                                <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo $artist_album;?>">Add To Playlist</a>
	                             </li>
	                          </div>
	                       </div>
	                    </div>
	                    <a href="#" class="button button-buy">BUY</a>
	                 </div>
	              </div>
	              <div class="item-holder">
	                 <div class="visual-holder">
	                    <div class="img-box">
	                       <img src="<?php echo $album_image[0];?>" alt="album image" width="168" height="160">
	                    </div>
	                    <div class="info">
	                       <em class="date"><i class="icon-clock-o"></i> <?php echo get_the_date('Y',$artist_album);?></em>
	                       <ol class="star-rating">
	                          <li><a href="#" class="one-star">1</a></li>
	                          <li><a href="#" class="two-stars">2</a></li>
	                          <li class="setted"><a href="#" class="three-stars">3</a></li>
	                          <li><a href="#" class="four-stars">4</a></li>
	                          <li><a href="#" class="five-stars">5</a></li>
	                       </ol>
	                    </div>
	                 </div>
	                 <ol class="playlist-item">
	                    <?php
	                       $ms_album_post_meta_option = '';
	                       $length = 00;
	                       $sec = 00;
	                       
	                       if( function_exists('fw_get_db_post_option') ):
	                          $ms_album_post_meta_option = fw_get_db_post_option($artist_album);
	                       endif;
	                       
	                       $album_songs = $ms_album_post_meta_option['album_songs'];
	                       
	                       if(!empty($album_songs)):
	                       $i = 1;
	                                foreach($album_songs as $mst_music_option): 
	                                  $attach_meta = array();
	                                      $mpurl = get_post_meta($mst_music_option, 'fw_option:mp3_full_songs', true);
	                                  if($mpurl) {
	                                    $attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
	                                  }
	                                  
	                                  $music_image = wp_get_attachment_image_src( get_post_thumbnail_id($mst_music_option), 'full' );
	                       
	                                  $music_price = '';
	                                    if(function_exists('fw_get_db_post_option')){
	                                        $music_price_arr = fw_get_db_post_option($mst_music_option, 'music_type_options');
	                                        if( !empty( $music_price_arr['premium']['single_music_price'] ) ){
	                                            $music_price = $music_price_arr['premium']['single_music_price'];
	                                        }
	                                    }
	                       
	                          $artists_ids = $ms_album_post_meta_option['album_artists'];
	                           $music_type = get_post_meta($mst_music_option, 'fw_option:music_type', true);
	                           //echo '<pre>'; print_r(get_post_meta($mst_music_option));
	                       
	                       
	                       ?>
	                    <li>
	                       <strong class="item-name"><a href="#"><?php echo get_the_title( $mst_music_option ); ?></a></strong>
	                       <div class="cell">
	                          <ol class="star-rating">
	                             <li><a href="#" class="one-star">1</a></li>
	                             <li><a href="#" class="two-stars">2</a></li>
	                             <li class="setted"><a href="#" class="three-stars">3</a></li>
	                             <li><a href="#" class="four-stars">4</a></li>
	                             <li><a href="#" class="five-stars">5</a></li>
	                          </ol>
	                          <a href="#" class="btn-round btn-edit"><i class="icon-pencil"></i> Edit</a>
	                          <span class="time"><?php echo (isset($attach_meta['length_formatted'])) ? $attach_meta['length_formatted'] : " "; ?></span>
	                          <div class="menu-box">
	                             <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
	                             <div class="menu-drop">
	                                <div class="drop-holder">
	                                   <ul class="drop-list">
	                                      <li>
	                                         <a href="javascript:;" class="favourite_music" data-musicid="<?php echo $mst_music_option;?>">Add To Favorite</a>
	                                      </li>
	                                      <li>
	                                         <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo $mst_music_option;?>">Add To Playlist</a>
	                                      </li>
	                                   </ul>
	                                </div>
	                             </div>
	                          </div>
	                          <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
	                          <span class="play_all btn-play">Play All</span>
	                          <span class="pause_all btn-pause">Pause</span>
	                          </a>
	                       </div>
	                    </li>
	                    <?php 
	                       $i++; 
	                       endforeach; 
	                       endif;
	                       ?>
	                 </ol>
	              </div>
	           </div>
	           <?php } endif;
	     
	        die();
	    }


	}
/*###################### Artist Gallry Pagination################################*/

	add_action( 'wp_ajax_child_miraculous_artist_gallry_pagination','child_miraculous_artist_gallry_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_artist_gallry_pagination','child_miraculous_artist_gallry_pagination');

	function child_miraculous_artist_gallry_pagination(){


	if (isset($_POST['offset']) && isset($_POST['limit']) && isset($_POST['post_id'])) {

		 if($_POST['role'] == 'administrator'){
		 	$gallery_images =  get_field('artist_gallery',$_POST['post_id']);
		 }else{
		 	$author_id = $_POST['post_id'];
            $args =array( 'post_type' => 'attachment', 'post_status' => 'inheret', 'author' => $author_id,'post_mime_type' => 'image');
            $gallery = new WP_Query( $args );
            $gallery_images =  $gallery->posts;
		 }



		$gallery_limit = $_POST['limit'];

		$gallery_offset = $_POST['offset'];

		$gallery_images = !empty($gallery_images) ? array_slice($gallery_images,$gallery_offset,$gallery_limit) : array();

		if(!empty($gallery_images)):
		foreach ($gallery_images as $key => $gallery_image) {

			if($_POST['role'] == 'administrator'){
               $image_url = $gallery_image['url'];
            }else{

              $image_url = $gallery_image->guid;
            }

		echo '<li><a href="#"><img src="'.$image_url.'" alt="photo" width="141" height="141"></a></li>';

		}
		endif;

		die();
	}


	}

	/*###############  remove from favourites albums list #####################*/
	add_action( 'wp_ajax_child_miraculous_give_star_rating','child_miraculous_give_star_rating');

	add_action( 'wp_ajax_nopriv_child_miraculous_give_star_rating','child_miraculous_give_star_rating');

	function child_miraculous_give_star_rating(){

	    $message = array();

	    $userid = get_current_user_id();
	    $user = get_user_by( 'id', $userid);

	    if (isset($_POST['post_id']) && isset($_POST['data_star']) && $userid) {

	        $rating = intval($_POST['data_star']);
	        $args = array(
	                    'post_id' => $_POST['post_id'],
	                    'user_id' => $userid,
	                );
	         $comments = get_comments( $args );

	        if(isset($comments) && empty($comments)){
	            $time = current_time('mysql');
	            $user_name = $user->first_name . ' ' . $user->last_name;
	            $data = array(
	                        'comment_post_ID' => $_POST['post_id'],
	                        'comment_author' => $user_name,
	                        'comment_author_email' => $user->user_email,
	                        'comment_author_url' => '',
	                        'comment_content' => '',
	                        'comment_type' => '',
	                        'comment_parent' => 0,
	                        'user_id' => $userid,
	                        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
	                        'comment_agent' => '',
	                        'comment_date' => $time,
	                        'comment_approved' => 1,
	                    );
	            $comment_id = wp_insert_comment($data);
	            if($comment_id){
	               add_comment_meta( $comment_id, 'rating', $rating ); 
	            }
	            $message['status'] = esc_html__('success','miraculous');
	            $message['msg'] = esc_html__('Successfully Voted','miraculous');
	            

	        }else{
	            $message['status'] = esc_html__('error','miraculous');
	            $message['msg'] = esc_html__('Already Voted','miraculous');
	        }


	            

	        echo json_encode($message);

	        die();

	    }

	    $message['status'] = esc_html__('error','miraculous');
	    $message['msg'] = esc_html__('You need to login','miraculous');
	    echo json_encode($message);
	    die();

	}

//Artist News by News Type 
	add_action( 'wp_ajax_child_miraculous_artist_news_by_news_type','child_miraculous_artist_news_by_news_type');

	add_action( 'wp_ajax_nopriv_child_miraculous_artist_news_by_news_type','child_miraculous_artist_news_by_news_type');

	function child_miraculous_artist_news_by_news_type(){


	    if (isset($_POST['newstype']) && isset($_POST['artist_id'])) {

	            $meta_query = array(array('key'=>'news_of_artist','value'=>serialize(strval($_POST['artist_id'])),'compare'=>'LIKE'));
				
				$tax_query = array(array('taxonomy' => 'news-type','field' => 'slug','terms' => $_POST['newstype']));

			     $arg = array(
			     'posts_per_page'=>-1,
			     'post_type'=>'ms-news',
			     'post_status' => 'publish',
			     'orderby'     => 'id',
			     'order'       => 'DESC',
			     'tax_query' => $tax_query,
			     'meta_query' => $meta_query
			   
			   );
			 
			    $news_query = new WP_Query($arg);
			    $news       = $news_query->posts;

			    $news_ids = array();
			    if(!empty($news)){
			      foreach ($news as $news_key => $news_data) {
			         $news_ids[] = $news_data->ID;
			      }
			    }

				$totla_news = count($news_ids);
				$news_limit = 1;
			    
			    ?>
			    
			    <?php
	              if (!empty($news_ids)) :
	                 foreach ($news_ids as $news_id_key => $news_id) :
	                       $image = wp_get_attachment_image_src( get_post_thumbnail_id($news_id), 'thumbnail' );

	                       if(empty($image)){
	                          $image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_id), 'thumbnail' );
	                       }

	                       $content_post = get_post($news_id);
                           $content = $content_post->post_content;
                           $date = $content_post->post_date;
                ?>
               <article class="event">
                  <div class="title-holder">
                     <h3><a href="javascript:;"><?php echo get_the_title($news_id);?></a></h3>
                  </div>
                  <div class="visual-box">
                     <?php if(!empty($image)):?>
                     <div class="img-box">
                        <img src="<?php echo $image[0];?>" alt="photo" width="168" height="160">
                     </div>
                     <?php endif;?>
                     <!-- <strong class="title"><?php //echo get_the_title($artist_id);?></strong> -->
                     <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo $date;?>"><?php echo get_timeago($date);?> </time></em>
                  </div>
                  <div class="text-holder">
                     <p class="more"><?php echo $content;?></p>
                  </div>
               </article>
               <?php 
                  endforeach;
               
                  //wp_reset_postdata();

                  else:
                     echo '<p class="no-found">No News Found.</p>';
                  endif;
               
	     
	       die();
	    }


	}

	// News pagination
	add_action( 'wp_ajax_child_miraculous_news_pagination','child_miraculous_news_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_news_pagination','child_miraculous_news_pagination');

	function child_miraculous_news_pagination(){


	    if (isset($_POST['all_news']) && isset($_POST['offset']) && isset($_POST['limit'])) {

	    	$all_news = json_decode($_POST['all_news']);
			$news_ids = !empty($_POST['all_news']) ? array_slice($all_news,$_POST['offset'],$_POST['limit']): array();    
			    
              if (!empty($news_ids)) :
                 foreach ($news_ids as $news_id_key => $news_id) :

                 	$artist_id = get_field('news_of_artist',$news_id);
                       $image = wp_get_attachment_image_src( get_post_thumbnail_id($news_id), 'thumbnail' );

                       if(empty($image)){
                          $image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_id[0]), 'thumbnail' );
                       }

                       $content_post = get_post($news_id);
                       $content = $content_post->post_content;

                       if($_POST['page'] == 'news-page'){
                       	  $page_link = get_the_permalink($news_id);
                       }else{
                       	  $page_link = 'javascript:;';	
                       }
            ?>
               <article class="event">
                  <div class="title-holder">
                     <h3><a href="<?php echo $page_link;?>"><?php echo get_the_title($news_id);?></a></h3>
                  </div>
                  <div class="visual-box">
                     <?php if(!empty($image)):?>
                     <div class="img-box">
                     <a href="<?php echo $page_link;?>">
                        <img src="<?php echo $image[0];?>" alt="photo" width="168" height="160">
                      </a>
                     </div>
                     <?php endif;?>
                     <?php if($_POST['page'] == 'news-page'){?>
                     <a href="<?php echo $page_link;?>">
                     	<strong class="title"><?php echo get_the_title($artist_id[0]);?></strong>
                     </a>
                     <?php }?>
                     <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo get_the_date('Y-m-d',$news_id);?>"><?php echo get_the_date('M, Y',$news_id);?></time></em>
                  </div>
                  <div class="text-holder">
                     <p class="more"><?php echo $content;?></p>
                  </div>
               </article>
               <?php 
                  endforeach;
               
                  endif;
               
	     
	       die();
	    }


	}

	// Artist Events pagination
	add_action( 'wp_ajax_child_miraculous_artist_events_pagination','child_miraculous_artist_events_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_artist_events_pagination','child_miraculous_artist_events_pagination');

	function child_miraculous_artist_events_pagination(){


	    if (isset($_POST['all_events']) && isset($_POST['offset']) && isset($_POST['limit'])) {

	    	$all_events = json_decode($_POST['all_events']);
			$event_ids = !empty($_POST['all_events']) ? array_slice($all_events,$_POST['offset'],$_POST['limit']): array();    
			    
              if (!empty($event_ids)) :
                 foreach ($event_ids as $key => $event_id) :
                  $event_image = wp_get_attachment_image_src( get_post_thumbnail_id($event_id), 'thumbnail' );
                  $content_post = get_post($event_id);
                  $content = $content_post->post_content;
            ?>
               <div class="event-item">
                  <div class="title-holder">
                     <h3><a href="<?php echo get_the_permalink($event_id);?>"><?php echo get_the_title($event_id);?></a></h3>
                     <em class="date-item"><i class="icon-clock-o"></i> <time datetime="2013-11-20">2 Days Ago</time></em>
                  </div>
                  <div class="img-box">
                  <?php if(!empty($event_image)){?>
                     <img src="<?php echo $event_image[0];?>" alt="photo" width="168" height="160">
                    <?php } ?>
                  </div>
                  <div class="text-holder">
                   <p><?php echo wp_trim_words($content, 40, '...' ); ?></p>
                     <a href="<?php echo get_the_permalink($event_id);?>" class="button">View Event</a>
                  </div>
               </div>
               <?php 
                  endforeach;
               
                  endif;
               
	     
	       die();
	    }


	}


	// Radio as per genre
	add_action( 'wp_ajax_child_miraculous_radio_as_per_genre','child_miraculous_radio_as_per_genre');

	add_action( 'wp_ajax_nopriv_child_miraculous_radio_as_per_genre','child_miraculous_radio_as_per_genre');

	function child_miraculous_radio_as_per_genre(){


	    if (isset($_POST['genre']) ) {
	    	
	       $tax_query = array();
           if(isset($_POST['genre']) && $_POST['genre']!=''){
              $tax_query[] = array ('taxonomy' => 'genre','field' => 'slug','terms' => $_POST['genre']);
           }
           
           
           
           $arg = array(
           'posts_per_page'=>-1,
           'post_type'=>'ms-radios',
           'post_status' => 'publish',
           'orderby'     => 'title', 
           'order'       => 'ASC',
           'tax_query' => $tax_query,
           
           );
           
           $radio_query = new WP_Query($arg);
           $radios       = $radio_query->posts;
           
           $radio_ids = array();
           if(!empty($radios)){

              foreach ($radios as $radio_key => $radio) {
                 $radio_ids[] = $radio->ID;
              }
           }
           
           
           $total_radio = count($radio_ids);
           $radio_limit = 3;
           
           
           
           
           ?>
        <input type="hidden" name="all_radio" id="all_radio" value="<?php echo !empty($radio_ids) ? json_encode($radio_ids) : '';?>" data-page="news-details-page">
        <input type="hidden" name="radio_offset" id="radio_offset" data-limit="<?php echo $radio_limit;?>">
        <div id="radio_pagin_result">
           <?php
              $radio_ids = !empty($radio_ids) ? array_slice($radio_ids,0,$radio_limit) : array();
              if(!empty($radio_ids)){
				$i = 0;
				$len = count($radio_ids);
                 foreach ($radio_ids as $radio_key => $radio_id) {
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id($radio_id), 'thumbnail' );
                 $radio_artists  = get_post_meta($radio_id,'radio_artists',true);
              ?>
           <?php if($i%2 == 0){?>
           <div class="section-row">
              <?php }?>
              <div class="item">
                 <div class="visual-box">
                    <div class="img-box">
                       <?php if(!empty($image)){?>
                       <a href="<?php echo get_the_permalink($radio_id);?>">
                       <img src="<?php echo $image[0];?>" alt="photo" width="142" height="135">
                       </a>
                       <?php }?>
                    </div>
                    <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo $radio_id;?>" data-musictype="radio">
                    <span class="play_all btn-play">Play All</span>
                    <span class="pause_all btn-pause">Pause</span>
                    </a>
                    <strong class="title"><?php echo get_the_title($radio_id);?></strong>
                    <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo get_the_date('Y-m-d',$radio_id);?>"><?php echo get_the_date('Y',$radio_id);?></time></em>
                 </div>
                 <div class="text-holder">
                    <h3>Artists</h3>
                    <?php if(!empty($radio_artists)){?>
                    <ol>
                       <?php foreach ($radio_artists as $key => $radio_artist) { ?>
                       <li><a href="<?php echo get_the_permalink($radio_artist);?>"><?php echo get_the_title($radio_artist);?></a></li>
                       <?php } ?>
                    </ol>
                    <?php }else{?>
                    <p class="no-found no-artist">No artist found</p>
                    <?php }?>
                 </div>
              </div>
              <?php if($i%2 == 1 || $i == $len - 1){?>
           </div>
           <?php }?>
           <?php
           		$i++;
              }
              }else{
              echo '<p class="no-found">No radio Found.</p>';
              }
            ?>
        </div>
        <?php 
           if(!empty($radio_ids) && $total_radio > count($radio_ids)):
           ?>
        <div class="paging-holder">
           <ul class="paging news-paging">
              <li class="prev"><a href="JavaScript:void(0);">&laquo;</a></li>
              <?php
                 for($ai=1; $ai<= ceil($total_radio/$radio_limit); $ai++){
                   
                 
                   if($ai==1){
                     $radio_current = 'class="radio_genre_pagin current"';
                   }else{
                     $radio_current = 'class="radio_genre_pagin"';
                   }
                 
                   $ao = $ai-1;
                   echo '<li><a href="JavaScript:void(0);" '.$radio_current.' id="radio_pagin_'.$ai.'" data-pagin="'.$ai.'" data-offset="'.$ao*$radio_limit.'">'.$ai.'</a><li/>';
                   
                 }
                 ?>
              <li class="next"><a href="JavaScript:void(0);"> &raquo;</a></li>
           </ul>
        </div>
        <?php endif;
	       die();
	    }


	}

	// Radio as per genre pagination
	add_action( 'wp_ajax_child_miraculous_radio_genre_pagination','child_miraculous_radio_genre_pagination');

	add_action( 'wp_ajax_nopriv_child_miraculous_radio_genre_pagination','child_miraculous_radio_genre_pagination');

	function child_miraculous_radio_genre_pagination(){


	    if (isset($_POST['all_radio']) && isset($_POST['offset']) && isset($_POST['limit'])) {

	    	$radio_ids = json_decode($_POST['all_radio']);
			$radio_ids = !empty($_POST['all_radio']) ? array_slice($radio_ids,$_POST['offset'],$_POST['limit']): array();    
			    
     		if(!empty($radio_ids)){
                  foreach ($radio_ids as $radio_key => $radio_id) {
                     $image = wp_get_attachment_image_src( get_post_thumbnail_id($radio_id), 'thumbnail' );
                  $radio_artists  = get_post_meta($radio_id,'radio_artists',true);

               ?>
               <?php if($radio_key%2 == 0){?>
                 <div class="section-row">
                <?php }?>
                  <div class="item">
                   <div class="visual-box">
                      <div class="img-box">
                      <?php if(!empty($image)){?>
                      <a href="<?php echo get_the_permalink($radio_id);?>">
                         <img src="<?php echo $image[0];?>" alt="photo" width="142" height="135">
                      </a>
                      <?php }?>
                      </div>
                      <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo $radio_id;?>" data-musictype="radio">
                         <span class="play_all btn-play">Play All</span>
                         <span class="pause_all btn-pause">Pause</span>
                      </a>
                      <strong class="title"><?php echo get_the_title($radio_id);?></strong>
                      <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo get_the_date('Y-m-d',$radio_id);?>"><?php echo get_the_date('Y',$radio_id);?></time></em>
                   </div>
                   <div class="text-holder">
                      <h3>Artists</h3>
                      <?php if(!empty($radio_artists)){?>
                      <ol>
                      <?php foreach ($radio_artists as $key => $radio_artist) { ?>
                         <li><a href="<?php echo get_the_permalink($radio_artist);?>"><?php echo get_the_title($radio_artist);?></a></li>
                      <?php } ?>
                      </ol>
                   <?php }else{?>
                   <p class="no-found no-artist">No artist found</p>
                   <?php }?>
                   </div>
                 </div>
            <?php if($radio_key%2 == 1 || count($radio_ids) == 1){?>
           		</div>
           <?php }?>
               <?php
                  }
               }else{
                  echo '<p class="no-found">No radio Found.</p>';
               }

	       die();
	    }


	}

	/*########### Add friend ##########*/

	add_action('wp_ajax_child_miraculous_add_friend', 'child_miraculous_add_friend');
	add_action('wp_ajax_nopriv_child_miraculous_add_friend', 'child_miraculous_add_friend');


	function child_miraculous_add_friend() {

	    $message = array();

	    $userid = get_current_user_id();

	    if (isset($_POST['fid']) && $_POST['fid']!='' && $userid ) {


	    	global $wpdb;

	    	$fid = $_POST['fid'];
	    	$type = $_POST['type'];
	    	$table_name = $wpdb->prefix . "friends"; 

			
			$result = $wpdb->get_results("SELECT f_id FROM ".$table_name." WHERE FID = ".$fid. " AND UID=".$userid);
			if(empty($result)){

				if($type == 'accept'){
					$savedata = array('FID' => $fid, 'UID' => $userid, 'invite_date' => date('Y-m-d h:m:s'),'accept_date' => date('Y-m-d h:m:s'),'status' => 'Confirmed');
					$insert_id = $wpdb->insert($table_name, $savedata);

					$data = array('status' => 'Confirmed','accept_date' => date('Y-m-d h:m:s'));
					$where = array('FID' => $userid, 'UID' => $fid,);

					$updated = $wpdb->update( $table_name, $data, $where );
					if($updated){
						$message['status'] = esc_html__('success','miraculous');
				         $message['msg'] = esc_html__('Accepted successfully','miraculous');
					}else{
						$message['status'] = esc_html__('error','miraculous');
				        $message['msg'] = esc_html__('Something went wrong please try again','miraculous');
					}

				}else{
					$savedata = array('FID' => $fid, 'UID' => $userid, 'invite_date' => date('Y-m-d h:m:s'));
					$insert_id = $wpdb->insert($table_name, $savedata);
					if($insert_id){
						$message['status'] = esc_html__('success','miraculous');
				        $message['msg'] = esc_html__('Friend request has been sent successfully','miraculous');
					}else{
						$message['status'] = esc_html__('error','miraculous');
				        $message['msg'] = esc_html__('Something went wrong please try again','miraculous');
					}
				}

				echo json_encode($message);
				die();
				
			}else{
				
				if($type == 'remove'){
					$delete = $wpdb->query( 'DELETE  FROM '.$table_name.' WHERE FID = '.$fid. ' AND UID='.$userid);
					if($delete){
						$message['status'] = esc_html__('success','miraculous');
				         $message['msg'] = esc_html__('Removed successfully','miraculous');
					    echo json_encode($message);
					    die();
					}else{
						$message['status'] = esc_html__('error','miraculous');
				        $message['msg'] = esc_html__('Something went wrong please try again','miraculous');
					    echo json_encode($message);
					    die();
					}
				}
				
			}

	    	
	    }


	    $message['status'] = esc_html__('error','miraculous');
	    $message['msg'] = esc_html__('You need to login.','miraculous');
	    echo json_encode($message);
	    die();

	}

	/*########### Send Message ##########*/

	add_action('wp_ajax_miraculous_child_send_message', 'miraculous_child_send_message');
	add_action('wp_ajax_nopriv_miraculous_child_send_message', 'miraculous_child_send_message');


	function miraculous_child_send_message() {

	    $message = array();

	    $userid = get_current_user_id();
	    $saveMessage = new Message();

	    

	    if ($userid ) {
	    	if(isset($_POST['receiver']) && $_POST['receiver']!=''){
	    		//extract($_POST);
	    		global $wpdb;

	    		
	    		

	    		$current_user = wp_get_current_user();
				$upload_dir   = wp_upload_dir();


				if ( isset( $current_user->user_login ) && ! empty( $upload_dir['basedir'] ) ) {
				    $user_dirname = $upload_dir['basedir'].'/user/'.$current_user->user_login;
				        if ( ! file_exists( $user_dirname ) ) {
					        wp_mkdir_p( $user_dirname );
					    }
				}

				$attachment_file = '';
				$filename = '';

				if(isset($_FILES['file']['name'])){
				    $filename = $_FILES['file']['name'];
				    if(isset($filename) && !empty($filename)){

				    	$attachment_file = time().'_'.$_FILES['file']['name'];
						$tmp_file_name = $_FILES['file']['tmp_name'];
						if($attachment_file){
						       move_uploaded_file($tmp_file_name,$user_dirname.'/'.$attachment_file);
						       $filename = $current_user->user_login.'/'.$attachment_file;
						}

				    }
				}

				
				$receiver     = sanitize_text_field($_POST['receiver']);
				$subject      = sanitize_text_field($_POST['subject']);
				$user_message = sanitize_text_field($_POST['user_message']);

				$threads_id = $saveMessage->_get_threads_id($userid,$receiver);
				

				$savedata = array(
					'sender_id'=>$userid,
					'receiver_id'=>$receiver,
					'subject'=>$subject,
					'message_text'=>$user_message,
					'file'=>$filename,
					'thread_id'=>$threads_id,
					'reply_id'=>0,
					'is_read'=>0,
					'create_at'=>date_create('now')->format('Y-m-d H:i:s'),
				);

				

				$msg_id = $saveMessage->_save_message($savedata);
				if($msg_id){

					$message['status'] = esc_html__('success','miraculous');
					$message['msg'] = esc_html__('Message has been sent successfully','miraculous');
					echo json_encode($message);
					die();

				}

				

	    	}else{
	    		$message['status'] = esc_html__('error','miraculous');
			    $message['msg'] = esc_html__('Something went wrong.','miraculous');
			    echo json_encode($message);
			    die();
	    	}

	    }


	    $message['status'] = esc_html__('error','miraculous');
	    $message['msg'] = esc_html__('You need to login.','miraculous');
	    echo json_encode($message);
	    die();

	}


	/*########### Get user conversation ##########*/

	add_action('wp_ajax_child_miraculous_get_user_conversation', 'child_miraculous_get_user_conversation');
	add_action('wp_ajax_nopriv_child_miraculous_get_user_conversation', 'child_miraculous_get_user_conversation');


	function child_miraculous_get_user_conversation() {

	    $message = array();

	    $userid = get_current_user_id();

	    

		if ($userid ) {
			if(isset($_POST['sender_id']) && $_POST['receiver_id']!=''){

				$conversation_data = new Message();
				$orderby = 'create_at DESC';
				$conversations = $conversation_data->_get_message($_POST['sender_id'],$_POST['receiver_id'],'',$orderby);
				if(!empty($conversations)){

					if($userid == $_POST['sender_id']){
                        $sender = $_POST['receiver_id'];
                    }else{
                        $sender = $_POST['sender_id'];
                    }

					$senderUser = get_userdata($sender);
			?>
			<div class="conversation-user"><h2><?php echo $senderUser->first_name .' '.$senderUser->last_name;?></h2></div>
			<?php

					foreach ($conversations as $c_key => $conversations) {
						$reply_orderby = 'm_id ASC';
						$reply_conversations = $conversation_data->_get_message($_POST['sender_id'],$_POST['receiver_id'],$conversations->m_id,$reply_orderby);


							$conversationUserDetails = get_userdata($conversations->sender_id);

							$conversationSenderName = ($conversations->sender_id == get_current_user_id()) ? "Me" : $conversationUserDetails->first_name .' '.$conversationUserDetails->last_name;
							//echo $conversations->is_read;
		?>	

			<div class="message-item panel-group <?php if($conversations->is_read != $userid || $reply_conversations->is_read != $userid || $conversations->is_read == 0){echo 'active-item';}?>" role="tablist" aria-multiselectable="true" id="message-content-<?php echo $conversations->m_id;?>">
                <div class="panel panel-default">

                  <div class="panel-heading title-holder" role="tab" id="heading<?php echo $c_key;?>">
	                  <a role="button" data-toggle="collapse" data-parent="#message-content-<?php echo $conversations->m_id;?>" href="#collapse<?php echo $c_key;?>" aria-expanded="true" aria-controls="collapse<?php echo $c_key;?>" onclick="readMessage('<?php echo $conversations->m_id;?>');" >
	                    	<h2><?php echo $conversations->subject;?></h2>
	                   </a>
	                   <?php 
	                   		if($conversations->file!=''){
	                   			$upload_dir   = wp_upload_dir();

	                   			$file_link = $upload_dir['baseurl'].'/user/'.$conversations->file;
	                   ?>
	                   <a href="<?php echo $file_link;?>" download class="file-download"><i class="fa fa-download" aria-hidden="true"></i></a>
	                   <?php } ?>

                    <div class="cell">
                      <span class="messages-number"><span class="number"><?php echo count($reply_conversations)+1;?></span> Messages</span>
                      <dl class="date"> <dt>Date:</dt> <dd><?php echo $conversation_data->_format_date($conversations->create_at,'j.m.Y');?><!-- 01.01.2013 --></dd> </dl>
                      <a href="javascript:;" onclick="deleteMessage('<?php echo $conversations->m_id;?>','message-content-<?php echo $conversations->m_id;?>');" class="button button-danger">DELETE</a>
                    </div>
                  </div>
                  <div id="collapse<?php echo $c_key;?>" class="panel-collapse collapse in message-text" role="tabpanel" aria-labelledby="heading<?php echo $c_key;?>">
                    <div class="main-message">
                      <p><?php echo $conversations->message_text;?></p>
                      <strong class="name"><?php echo $conversationSenderName; ?></strong>
                    </div>
                    <div class="more-reply">
                     <ul class="messages-chain" id="reply-messages-section">
                    <?php if(!empty($reply_conversations)){  ?>
                    <?php
                    	foreach ($reply_conversations as $r_key => $reply_conversation) {

							$replyUserDetails = get_userdata($reply_conversation->sender_id);

							$replySenderName = ($reply_conversation->sender_id == get_current_user_id()) ? "Me" : $replyUserDetails->first_name .' '.$replyUserDetails->last_name;
							
                    ?>
                      <li id="reply-message-content-<?php echo $reply_conversation->m_id;?>">
                        <p><?php echo $reply_conversation->message_text;?></p>
                         <span class="delete-reply" onclick="deleteMessage('<?php echo $reply_conversation->m_id;?>','reply-message-content-<?php echo $reply_conversation->m_id;?>');"><i class="fa fa-trash"></i></span>
                        <strong class="name"><?php echo $replySenderName;?></strong>
                      </li>
                    <?php } } ?>
                    </ul>
                    </div>
                    <div class="reply_section" >
                    	<div class="reply_loader" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i>Loading</div>
	                    <div id="show_reply_form_<?php echo $conversations->m_id;?>">
	                    	<a href="javascript:;" class="button" onclick="showRplyForm('<?php echo $conversations->m_id;?>')">Reply</a>
	                    </div>
                    </div>
                  </div>


                </div>
            </div>

		<?php

					}
				}
				die();

			}
		}

	}

	/*########### Get user conversation ##########*/

	add_action('wp_ajax_child_miraculous_get_user_reply_form', 'child_miraculous_get_user_reply_form');
	add_action('wp_ajax_nopriv_child_miraculous_get_user_reply_form', 'child_miraculous_get_user_reply_form');


	function child_miraculous_get_user_reply_form() {

		if(isset($_POST['mid']) && $_POST['mid']!=''){
	?>	

		 <form class="" method="post" action="javascript:;" onsubmit="return sendReplyMessage('<?php echo $_POST['mid'];?>');">
			<textarea id="message" class="reply-message" name="message"></textarea>
			<p class="error message_error"></p>
			<div class="show_reply_loader" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i></div>
			<input type="submit" name="reply-submit" value="Send" class="reply-submit">
			<input type="button" name="cancel" value="cancel" class="reply-submit cancel-button" onclick="cancelRplyForm('<?php echo $_POST['mid'];?>');"">
        </form>
	<?php
		}
		
		die();
	}


	/*########### Get user conversation ##########*/

	add_action('wp_ajax_child_miraculous_save_user_reply_conversation', 'child_miraculous_save_user_reply_conversation');
	add_action('wp_ajax_nopriv_child_miraculous_save_user_reply_conversation', 'child_miraculous_save_user_reply_conversation');


	function child_miraculous_save_user_reply_conversation() {

		$userid = get_current_user_id();

		if(isset($_POST['mid']) && $_POST['mid']!=''){
			$mid = $_POST['mid'];
			$reply_message = $_POST['message'];
			
			$conversation_data = new Message();
			$conversations = $conversation_data->_get_message_by_id($mid);
			if(!empty($conversations)){

				if($userid != $conversations->receiver_id){
					$receiver = $conversations->receiver_id;
				}else{
					$receiver = $conversations->sender_id;
				}

				$savedata = array(
					'sender_id'=>$userid,
					'receiver_id'=>$receiver,
					'subject'=>$conversations->subject,
					'message_text'=>$reply_message,
					'thread_id'=>$conversations->thread_id,
					'reply_id'=>$mid,
					'is_read'=>0,
					'create_at'=>date_create('now')->format('Y-m-d H:i:s'),
				);

				$msg_id = $conversation_data->_save_message($savedata);
				if($msg_id){

					$updateData = array('deleted_by'=>0);
					$updatecondition = array('m_id'=>$mid);
					$conversation_data->_update_message($updateData,$updatecondition);
				}

				$orderby = 'm_id ASC';
				$reply_conversations = $conversation_data->_get_message($userid,$receiver,$mid,$orderby);


					foreach ($reply_conversations as $r_key => $reply_conversation) {

							$replyUserDetails = get_userdata($reply_conversation->sender_id);

							$replySenderName = ($reply_conversation->sender_id == get_current_user_id()) ? "Me" : $replyUserDetails->first_name .' '.$replyUserDetails->last_name;
							
                    ?>
                      <li id="reply-message-content-<?php echo $reply_conversation->m_id;?>">
                        <p><?php echo $reply_conversation->message_text;?></p>
                        <span class="delete-reply" onclick="deleteReplyMessage('<?php echo $reply_conversation->m_id;?>');"><i class="fa fa-trash"></i></span>
                        <strong class="name"><?php echo $replySenderName;?></strong>
                      </li>
                    <?php 
                } 
				
			}

		}
		
		die();
	}

	/*########### Delete user conversation ##########*/

	add_action('wp_ajax_child_miraculous_delete_user_conversation', 'child_miraculous_delete_user_conversation');
	add_action('wp_ajax_nopriv_child_miraculous_delete_user_conversation', 'child_miraculous_delete_user_conversation');


	function child_miraculous_delete_user_conversation() {

		$message = array();
		$userid = get_current_user_id(); 

		if (isset($_POST['mid']) && isset($_POST['mid']) ) {

			$mid = $_POST['mid'];
			$conversationsCondition = array('m_id'=>$mid);


		     
		     $conversation = new Message();

		     $conversationData = $conversation->_get_message_by_id($mid);
		     $deleted_by = (int)$conversationData->deleted_by;

		     
		     if($deleted_by > 0 && $deleted_by != $userid ){

		     	$deleteCoversations = $conversation->_delete_user_message($conversationsCondition);
		     	$replyCondition = array('reply_id'=>$mid);
		     	$conversation->_delete_user_message($replyCondition);

		     }else{

				$updateData = array('deleted_by'=>$userid);
				$updatecondition = array('m_id'=>$mid);
				$deleteCoversations = $conversation->_update_message($updateData,$updatecondition);

		     }

		     
		     if($deleteCoversations){
		     	
		     	$message['status'] = 'success';
				$message['msg'] = 'Deleted successfully';
			    echo json_encode($message);

			    die();
		     }else{
		     	$message['status'] = 'error';
				$message['msg'] = 'Something went wrong';
			    echo json_encode($message);
		     }
			

		}


		die();
	}

	/*########### Read user conversation ##########*/

	add_action('wp_ajax_child_miraculous_read_user_conversation', 'child_miraculous_read_user_conversation');
	add_action('wp_ajax_nopriv_child_miraculous_read_user_conversation', 'child_miraculous_read_user_conversation');


	function child_miraculous_read_user_conversation() {

		$message = array();
		$userid = get_current_user_id(); 

		if (isset($_POST['mid']) && isset($_POST['mid']) ) {

			$mid = $_POST['mid'];

		    $conversation = new Message();


			$updateData = array('is_read'=>$userid);
			$updatecondition = array('m_id'=>$mid);
			$updateCoversations = $conversation->_update_message($updateData,$updatecondition);
			$conversation->_update_message($updateData,array('reply_id'=>$mid));

			// $updateData = array('is_read'=>$userid);
			// $updatecondition = array('receiver_id'=>$userid,'sender_id'=>$sender);
			// $conversation_data->_update_message($updateData,$updatecondition);
		     
		     if($updateCoversations){
		     	$message['status'] = 'success';
				$message['msg'] = 'Deleted successfully';
			    echo json_encode($message);

			    die();
		     }else{
		     	$message['status'] = 'error';
				$message['msg'] = 'Something went wrong';
			    echo json_encode($message);
		     }
			

		}


		die();
	}

function wpb_woo_my_account_order() {
	$myorder = array(
		'orders'             => __( 'Orders', 'woocommerce' ),
		'woo-wallet'             => __( 'My Wallet', 'woocommerce' ),
		'downloads'          => __( 'Download Songs', 'woocommerce' ),
		'edit-address'       => __( 'Addresses', 'woocommerce' ),
		'customer-logout'    => __( 'Logout', 'woocommerce' ),
	);
	return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );


	/*########### Check User Wallet Funds ##########*/

	add_action('wp_ajax_child_miraculous_check_user_wallet_funds', 'child_miraculous_check_user_wallet_funds');
	add_action('wp_ajax_nopriv_child_miraculous_check_user_wallet_funds', 'child_miraculous_check_user_wallet_funds');


	function child_miraculous_check_user_wallet_funds() {

		$message = array();
		$userid = get_current_user_id();
		$current_user = wp_get_current_user();
		$submit_url = get_stylesheet_directory_uri().'/paypal/payments.php';

		$wallet_amount = woo_wallet()->wallet->get_wallet_balance( get_current_user_id() ); 

		$credit_amount = array_sum(wp_list_pluck( get_wallet_transactions( array( 'user_id' => $userid, 'where' => array( array( 'key' => 'type', 'value' => 'credit' ) ) ) ), 'amount' ) );
		$debit_amount = array_sum(wp_list_pluck( get_wallet_transactions( array( 'user_id' => $userid, 'where' => array( array( 'key' => 'type', 'value' => 'debit' ) ) ) ), 'amount' ) );
			
		$wallet_balance = $credit_amount - $debit_amount;
                



		$miraculous_theme_data = '';
		if (function_exists('fw_get_db_settings_option')):  
		    $miraculous_theme_data = fw_get_db_settings_option();     
		endif;
		if(function_exists('miraculous_currency_symbol')){
            $currency_symbol = miraculous_currency_symbol($currency);
        }
        
		
		if (isset($_POST['pid']) && isset($_POST['pid']) && $userid) {

			$pid = $_POST['pid'];
			$plans_details   = get_post($pid);

			 $plan_price = get_post_meta($pid, 'fw_option:plan_price', true);


				
		if( !empty($current_user) && $current_user->ID ){
			//paypalform  = '<form class="paypal" action="'.esc_url(home_url( '/payment-processing/' )).'" method="post">';
			$paypalform  = '<form class="paypal" action="'.esc_url(home_url( '/packages/' )).'" method="post">';
			$paypalform .= '<input type="hidden" name="payFor" value="package" />';
			$paypalform .= '<input type="hidden" name="cmd" value="_xclick" />';
			$paypalform .= '<input type="hidden" name="lc" value="UK" />';
			$paypalform .= '<input type="hidden" name="first_name" value="'.esc_attr($current_user->user_firstname).'" />';
			$paypalform .= '<input type="hidden" name="last_name" value="'.esc_attr($current_user->user_lastname).'" />';
			$paypalform .= '<input type="hidden" name="payer_email" value="'.esc_attr($current_user->user_email).'" />';
			$paypalform .= '<input type="hidden" name="user_id" value="'.esc_attr($current_user->ID).'" />';
			$paypalform .= '<input type="hidden" name="item_number" id="item_number" value="'.esc_attr($pid).'" / >';
			$paypalform .= '<input type="hidden" name="item_name" id="item_name" value="'.esc_attr($plans_details->post_title).'" / >';
			$paypalform .= '<input type="submit" name="submit" id="buy_now" class="ms_btn" value="'.esc_attr('buy now', 'miraculous').'"/>';
			$paypalform  .= ' </form>';
		}else{
			$paypalform  = '<a href="javascript:;" class="ms_btn" data-toggle="modal" data-target="#myModal1">'.esc_html("buy now", "miraculous").'</a>';
		}

		
			if($wallet_balance > $plan_price){
		     	
		     	$message['paypalData'] = $paypalform;
                $message['walletData'] = '<a href="javascript:;" class="ms_btn wallet-pay" data-pid="'.$pid.'">'.esc_html("buy now", "miraculous").'</a>';
                echo json_encode($message);
				die();
				
		     }else{
		     	$message['paypalData'] = $paypalform;
				$message['walletData'] = 'wallet amount low';
				echo json_encode($message);
				die();
			    
		     }

		}

		die();
	}


	/*########### Get Subscription By User Wallet  ##########*/

	add_action('wp_ajax_child_miraculous_get_subscription_by_wallet', 'child_miraculous_get_subscription_by_wallet');
	add_action('wp_ajax_nopriv_child_miraculous_get_subscription_by_wallet', 'child_miraculous_get_subscription_by_wallet');

	function child_miraculous_get_subscription_by_wallet() {

		$message = array();
		$userid = get_current_user_id();
		$current_user = wp_get_current_user();

		if( function_exists('fw_get_db_settings_option') ) {
		  
		  $paypal_business_email = fw_get_db_settings_option( 'paypal_business_email' );
		  $currency_code = fw_get_db_settings_option( 'paypal_currency' );
		}
		
		$wallet_amount = woo_wallet()->wallet->get_wallet_balance( get_current_user_id() ); 

		$credit_amount = array_sum(wp_list_pluck( get_wallet_transactions( array( 'user_id' => $userid, 'where' => array( array( 'key' => 'type', 'value' => 'credit' ) ) ) ), 'amount' ) );
		$debit_amount = array_sum(wp_list_pluck( get_wallet_transactions( array( 'user_id' => $userid, 'where' => array( array( 'key' => 'type', 'value' => 'debit' ) ) ) ), 'amount' ) );
			
		$wallet_balance = $credit_amount - $debit_amount;
                

		
		if (isset($_POST['pid']) && isset($_POST['pid']) && $userid) {

			$pid = $_POST['pid'];
			$plans_details   = get_post($pid);

			$itemName = $plans_details->post_title;
			$itemAmount = get_post_meta($pid, 'fw_option:plan_price', true);
			$plan_validity = get_post_meta($pid, 'fw_option:plan_validity', true);
			$monthly_download = get_post_meta($pid, 'fw_option:plan_monthly_downloads', true);
			$monthly_upload = get_post_meta($pid, 'fw_option:plan_monthly_upload', true) ? get_post_meta($pid, 'fw_option:plan_monthly_upload', true) : 50;

			$txn_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			
			
		
			if($wallet_balance >= $plan_price){
		     	
		     	$subscription = new Subscription();
		     	$txn_id = $subscription->_generate_string($txn_chars, 17);

		     	$data = array(
					'plan_name' => $itemName,
					'plan_number' => $pid,
					'user_id' => $userid,
					'plan_validity' => $plan_validity,
					'monthly_download' => $monthly_download,
					'monthly_upload' => $monthly_upload,
					'payment_status' => 'Confirm',
					'payment_amount' => $itemAmount,
					'payment_currency' => $currency_code,
					'txn_id' => $txn_id,
					'receiver_email' => $paypal_business_email,
					'payer_email' => $current_user->user_email,
					'payment_via' => 'wallet',
				);

				
				$payment_id = $subscription->_save_payment_info($data);
				if($payment_id){

					$description = 'For payment of '.$itemName.' Package';
					$transaction_id = woo_wallet()->wallet->debit( $userid, $itemAmount, $description);

					$message['status'] = 'success';
					$message['msg'] = 'Payment successfully';
				    echo json_encode($message);
				    die();
				}

		     }else{
				$message['status'] = 'error';
				$message['msg'] = 'wallet amount low';
				echo json_encode($message);
				die();
		     }

		}

		die();
	}



	function get_subscription_via_paypal(){

		ob_start();
	    if( isset($_REQUEST['payFor'] )  ||  isset($_REQUEST['tx'] )){

	    	$_SESSION['cms-ridirectUrl'] = $_SERVER['HTTP_REFERER'];

	    	$subscription = new Subscription();

	       	$enableSandbox = true;

			if( function_exists('fw_get_db_settings_option') ) {
			  $enableSandbox = fw_get_db_settings_option( 'paypal_mode' ) == 'testing' ? true : false;
			  $paypal_business_email = fw_get_db_settings_option( 'paypal_business_email' );
			  $paypal_success_page_url = fw_get_db_settings_option( 'paypal_success_page_url' );
			  $paypal_cancel_page_url = fw_get_db_settings_option( 'paypal_cancel_page_url' );
			  $currency_code = fw_get_db_settings_option( 'paypal_currency' );
			}

			// PayPal settings. 
			$paypalConfig = [
			  'email' => $paypal_business_email,
			  'return_url' => $paypal_success_page_url ? $paypal_success_page_url : site_url(),
			  'cancel_url' => $paypal_cancel_page_url ? $paypal_cancel_page_url : site_url(),
			  'notify_url' => esc_url(home_url( '/packages/' )),
			];

			$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

			$itemName = $_REQUEST['item_name'];
			$itemAmount = get_post_meta($_REQUEST['item_number'], 'fw_option:plan_price', true);
			$plan_validity = get_post_meta($_REQUEST['item_number'], 'fw_option:plan_validity', true);
			$monthly_download = get_post_meta($_REQUEST['item_number'], 'fw_option:plan_monthly_downloads', true);
			$monthly_upload = get_post_meta($_REQUEST['item_number'], 'fw_option:plan_monthly_upload', true) ? get_post_meta($_REQUEST['item_number'], 'fw_option:plan_monthly_upload', true) : 50; 

			// Check if paypal request or response
			if ( !isset($_REQUEST["tx"]) ) {

			  // Grab the post data so that we can set up the query string for PayPal.
			  // Ideally we'd use a whitelist here to check nothing is being injected into
			  // our post data.
			  $data = [];
			  foreach ($_REQUEST as $key => $value) {
			    $data[$key] = stripslashes($value);
			  } 

			  // Set the PayPal account.
			  $data['business'] = $paypalConfig['email'];

			  // Set the PayPal return addresses.
			  $data['return'] = stripslashes($paypalConfig['return_url']);
			  $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
			  $data['notify_url'] = stripslashes($paypalConfig['notify_url']);

			  // Set the details about the product being purchased, including the amount
			  // and currency so that these aren't overridden by the form data.
			  $data['amount'] = $itemAmount;
			  $data['currency_code'] = $currency_code;
			  $data['item_name'] = $itemName;
			  $data['item_number'] = $_REQUEST['item_number'];

			  $custom_arr = array('user_id' => $_POST['user_id'],'payer_email' => $_POST['payer_email'], 'plan_validity' => $plan_validity, 'ms_download' => $monthly_download, 'ms_upload' => $monthly_upload, 'payment_via' => 'paypal');
			  $data['custom'] = json_encode($custom_arr);
			 


			  //$_SESSION['paypalData'] = $data;

			  // Build the query string from the data.
			  $queryString = http_build_query($data);

			  
			 
			  // Redirect to paypal IPN
			  header('location:' . $paypalUrl . '?' . $queryString);
			  exit();

			}else {


			  // Handle the PayPal response.
			  // Assign posted variables to local data array.
			  $custom_res = stripslashes($_REQUEST['cm']);
			  $custom_res1 = json_decode( $custom_res );


			  $data = [
			    'plan_name' => $_REQUEST['item_name'],
			    'plan_number' => $_REQUEST['item_number'],
			    'user_id' => $custom_res1->user_id,
			    'plan_validity' => $custom_res1->plan_validity,
			    'monthly_download' => $custom_res1->ms_download,
			    'monthly_upload' => $custom_res1->ms_upload,
			    'payment_status' => $_REQUEST['st'],
			    'payment_amount' => $_REQUEST['amt'],
			    'payment_currency' => $_REQUEST['cc'],
			    'txn_id' => $_REQUEST['tx'],
			    'receiver_email' => $paypal_business_email,
			    'payer_email' => $custom_res1->payer_email,
			    'payment_via' => 'paypal',
			  ];


			  // We need to verify the transaction comes from PayPal and check we've not
			  // already processed the transaction before adding the payment to our
			  // database.

			  //if ($subscription->_verifyTransaction($_SESSION['paypalData'],$paypalUrl) && $subscription->_checkTxnid($data['txn_id'])) {
			  if ($subscription->_checkTxnid($data['txn_id'])) {
			    if ($subscription->_addPayment($data) !== false) {
			      /*Payment successfully added.*/
			      echo "paypment successfully";
			    }
			  }
			}
			ob_end_clean();
	    }
	}
	add_action( 'init', 'get_subscription_via_paypal' );

		/*########### Artist Albums Upload  ##########*/

	add_action('wp_ajax_child_miraculous_artist_album_upload', 'child_miraculous_artist_album_upload');
	add_action('wp_ajax_nopriv_child_miraculous_artist_album_upload', 'child_miraculous_artist_album_upload');

	function child_miraculous_artist_album_upload(){

        $miraculous_theme_data = '';
        if (function_exists('fw_get_db_settings_option')):  
          $miraculous_theme_data = fw_get_db_settings_option();     
        endif; 
        $track_page = '';
        $track_page = get_the_permalink(get_page_by_path('profile')).'albums';
        

		$data = array('status' => 'false', 'msg' => 'Something went Wrong.');

		$user_id = get_current_user_id();

		global $wpdb;
		$pmt_tbl = $wpdb->prefix . 'ms_payments'; 
	    $query = $wpdb->get_row( "SELECT * FROM `$pmt_tbl` WHERE user_id = $user_id AND expiretime > '$today'" );
 
	    

		if( isset($_POST['song_title']) ){



		    extract($_POST);

		     
		    $user_artist_id  = get_user_meta($user_id,'_user_artist_id',true);



		    if($song_title!=''){
		    	$song_title = explode(',', $song_title);

		    }

		    if($song_image_id!=''){
		    	$song_image_id = explode(',', $song_image_id);

		    }

		    if($song_file_id!=''){
		    	$song_file_id = explode(',', $song_file_id);

		    }

		    if($file_url!=''){
		    	$file_url = explode(',', $file_url);

		    }

		    if($full_file_data!=''){
		    	$full_file_data = explode('\"acf_errors\":false},', $full_file_data);

		    }



		    $genres_ids = array();
	        if(!empty($album_genres)){
               $album_genres = explode(',',$_POST['album_genres']);
               foreach ($album_genres as $key => $album_genre) {
                    $genre = get_term_by('slug', $album_genre, 'genre'); 
                    $genres_ids[] = $genre->term_id;
                }
            }

		if($query->remains_upload > 0){    
	          
		    $musicid = array();

		    $remains_upload = $query->remains_upload;
		    
		    if(!empty($song_title) ){

		    	foreach ($song_title as $key => $track_name) {
				    $m_args = array(
				            'post_type' => 'ms-music',
				            'post_title' => $track_name,
				            'post_author' => $user_id,
				            'post_status' => 'draft',
				      );

				    if($remains_upload > 0){
				    	$music_id =  wp_insert_post($m_args);

					    if(!empty($music_id)){

					    	$musicid[] = $music_id;

							if(!empty($song_image_id)){
								set_post_thumbnail( $music_id, $song_image_id[$key]);
							}


		                    if(!empty($genres_ids)){
		                        $term_taxonomy_ids = wp_set_object_terms($music_id, $genres_ids, 'genre' );
		                    }

		                     
		                    $artist_arr = array();
						    $artist_arr[] = $user_artist_id;

							$new_full_track = array('attachment_id' => $song_file_id[$key], 'url' => $file_url[$key]);

							update_post_meta($music_id, 'music_added_by', $user_id);

							update_post_meta($music_id, 'fw_option:mp3_full_songs', $new_full_track);

							update_post_meta($music_id, 'mp3_full_songs', $full_file_data[$key]);

							update_post_meta($music_id, 'fw_option:music_artists', $artist_arr);

							update_post_meta($music_id, 'fw_option:music_type', 'premium');


					    }
				    }

				    
				  $remains_upload = $remains_upload-1;
		    	}
		    }

		    if(!empty($musicid)){

		    	$albums_arg = array(
					'post_type' => 'ms-albums',
					'post_title' => $album_name,
					'post_content' => $description,
					'post_author' => $user_id,
					'post_status' => 'draft',
		    		);

		    	$album_id =  wp_insert_post($albums_arg);

		    	if($album_id){

					if(!empty($album_image_id)){
						set_post_thumbnail( $album_id, $album_image_id);
					}
   
					$data = array(
						'album_type' => 'premium',
						'album_songs' => $musicid,
						'album_artists'=> $artist_arr,
						'album_release_date' => '',
						'album_company_name' => '', 
						'post-sidebar' => 'full',
						'post_breadcrumbs_switch' => 'off',
						'post_bgimages_switch' => 'on' ,
						'single_bg_images' =>' ' 
					);

					update_post_meta($album_id, 'album_artists', $artist_arr);
					update_post_meta($album_id, 'fw_options', $data);
					update_post_meta($album_id, 'album_type','premium');
					update_post_meta($album_id, 'album_artists', $artist_arr);
					update_post_meta($album_id, 'fw_option:album_type', 'premium');
					
					if(!empty($genres_ids)){
	                        $term_taxonomy_ids = wp_set_object_terms($album_id, $genres_ids, 'genre' );
	                    }

	                    $mailToAdmin = send_notification_to_admin_for_create_albums_by_artist($album_id,$user_id);

		    	}

		    	if($query->remains_upload > 0){

		          	$wpdb->update( $pmt_tbl, array( 'remains_upload' => $query->remains_upload-count($musicid)),array( 'ID' => $query->id ), array( '%d' ), array( '%d' ) );
	      		}

	      		$data = array('status' => 'true', 'msg' => 'Uploaded Successfully.', 'track_page' => $track_page);


		    }else{

	      		$data = array('status' => 'false', 'msg' => 'Something went Wrong.');

	    	}

	    	echo json_encode($data);

	    	die();
	    }else{
	    	$data = array('status' => 'true', 'msg' => 'Your uploading limit has expired.', 'track_page' => $track_page);
	    }

		}

	  	echo json_encode($data);

	  	die();

	}

	function send_notification_to_admin_for_create_albums_by_artist($album_id,$user_id){

		if($album_id!=''){

			$albumsName = '<a href="'.get_the_permalink($album_id).'">'.get_the_title($album_id).'</a>';

			if( function_exists('fw_get_db_post_option') ):
				$ms_album_post_meta_option = fw_get_db_post_option($album_id);
			endif;

			$album_songs = $ms_album_post_meta_option['album_songs'];
			if(!empty($album_songs)){
				foreach ($album_songs as $key => $songs) {
					$song_name[] = get_the_title($songs);
				}
				$song_name = implode(',', $song_name);

				$user = get_user_by( 'id', $user_id);
				$username = $user->first_name . ' ' . $user->last_name .' ( '.$user->user_email.' )';

				$mailBody = 'Hello Administrator '.$username.' has created a new album '.$albumsName.' with '.$song_name.' songs.';

					$to = 'arvind@digitalaptech.com';
					$subject = 'New Albums Added by '.$username;
					$headers = "From: ".$user->user_email . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
 					$headers .= "Content-type: text/html; charset: utf8\r\n";

					if(mail( $to, $subject, $mailBody, $headers )){
						$rs = true;
					}else{
						$rs = false;
					}
					return $rs;

			}

			
		}

	}

	/*########### Artist Albums Delete  ##########*/

	add_action('wp_ajax_child_miraculous_remove_from_artist_albums_list', 'child_miraculous_remove_from_artist_albums_list');
	add_action('wp_ajax_nopriv_child_miraculous_remove_from_artist_albums_list', 'child_miraculous_remove_from_artist_albums_list');

	function child_miraculous_remove_from_artist_albums_list(){
		$data = array('status' => 'false', 'msg' => 'Something went Wrong.');
		if(isset($_POST['albumsid']) && $_POST['albumsid']!=''){

			$aid = $_POST['albumsid'];

			if(function_exists('fw_get_db_post_option')):
				$ms_album_post_meta_option = fw_get_db_post_option($aid);
			endif;

			$album_songs = $ms_album_post_meta_option['album_songs'];

			$deleteAlbums = wp_delete_post($aid, true);
			if($deleteAlbums){
				if(!empty($album_songs)){
					foreach ($album_songs as $key => $songs) {
						wp_delete_post($songs, true);
					}
				}

				$data = array('status' => 'true', 'msg' => 'Deleted Successfully.');

			}


		}
		echo json_encode($data);
		die();

    }

    /*###########  Albums Popup Content  ##########*/

	add_action('wp_ajax_child_miraculous_albums_popup_list', 'child_miraculous_albums_popup_list');
	add_action('wp_ajax_nopriv_child_miraculous_albums_popup_list', 'child_miraculous_albums_popup_list');

	function child_miraculous_albums_popup_list(){

		
		if(isset($_POST['albumsid']) && $_POST['albumsid']!=''){

			$aid = $_POST['albumsid'];


			 $album_artist_id = get_post_meta($aid, 'album_artists', true);
  			 $album_image = wp_get_attachment_image_src( get_post_thumbnail_id($aid), 'full' );

		?>

		<div class="album-block">
				<div class="block-table">
					<div class="img-box">
						<img src="<?php echo $album_image[0];?>" alt="<?php echo $title;?>" width="168" height="160">
					</div>
					<div class="text-holder">
						<div class="text-frame">
							<div class="tr">
								<div class="heading">
									<div class="title-holder">
										<h2><?php echo get_the_title($aid);?></h2>
										<strong class="sub-title">
											<?php 
					                           if(!empty($album_artist_id)){
					                                foreach ($album_artist_id as $artist_id_key => $artist_id) {
					                                    echo get_the_title($artist_id);
					                                    if($artist_id_key != count( $album_artist_id ) -1){
					                                      echo ', ';
					                                    }
					                                }
					                            }
					                           ?>
										</strong>
									</div>
								</div>
								<dl class="info">
									<dt>Genre:</dt>
									<dd><?php  echo get_the_term_list($aid, 'genre', '', ', ' );?></dd>
									<dt>Releases:</dt>
									<dd><?php echo get_the_date('M d, Y',$aid);?></dd>
								</dl>
							</div>
							<div class="bottom-panel">
								<div class="panel-holder">
									<div class="panel-frame">
										<a href="#" class="button button-danger">Download Album</a>
										<div class="share-item">
											<strong>Share</strong>
											<ul class="social-list">
					                           <li class="facebook">
					                              <a href="javascript:void(0);" class="ms_share_facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink($aid)); ?>', 'Share', width='200', height='150' )">
					                              <i class="icon-facebook"></i> Facebook
					                              </a>
					                           </li>
					                           <li class="twitter">
					                              <a href="javascript:void(0);" class="ms_share_twitter" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo get_the_title($aid); ?>&amp;url=<?php echo esc_url(get_permalink($aid)); ?>&amp;via=<?php echo get_bloginfo( 'name' ); ?>' , 'Share', width='200', height='150' )">
					                              <i class="icon-twitter"></i> Twitter
					                              </a>
					                           </li>
					                           <li class="linkedin">
					                              <a href="javascript:void(0);" class="ms_share_linkedin" onclick="window.open('https://www.linkedin.com/cws/share?url=<?php echo esc_url(get_permalink($aid)); ?>', 'Share', width='200', height='150' )">
					                              <i class="icon-linkedin"></i> LinkedIn
					                              </a>
					                           </li>
					                           <li class="google-plus">
					                              <a href="javascript:void(0);" class="ms_share_googleplus" onclick="window.open('https://plus.google.com/share?url=<?php echo esc_url(get_permalink($aid)); ?>', 'Share', width='200', height='150' )">
					                              <i class="icon-google-plus"></i> Google+
					                              </a>
					                           </li>
					                        </ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="items-area">
				<div class="area-holder">
					<div class="items-table">
						<div class="tr head">
							<div class="cell title">Name</div>
							<div class="cell rating">Duration</div>
							<div class="cell">Play</div>
						</div>
						<div class="row-group">

						<?php
				               $ms_album_post_meta_option = '';
				               $length = 00;
				               $sec = 00;
				               
				               if( function_exists('fw_get_db_post_option') ):
				                  $ms_album_post_meta_option = fw_get_db_post_option($aid);
				               endif;
				               
				               $album_songs = $ms_album_post_meta_option['album_songs'];
				               
				               if(!empty($album_songs)):
									$i = 1;
									foreach($album_songs as $mst_music_option): 
										$attach_meta = array();
										$mpurl = get_post_meta($mst_music_option, 'fw_option:mp3_full_songs', true);
										if($mpurl) {
											$attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
										}

                     ?>
							<div class="tr main-row">
								<div class="cell title"><?php echo get_the_title( $mst_music_option ); ?></div>
								<div class="cell">
									<span><?php echo !empty($attach_meta) ? $attach_meta['length_formatted'] : '' ?></span>
								</div>
								<div class="cell">
									<a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
										<span class="play_all btn-play">Play All</span>
										<span class="pause_all btn-pause">Pause</span>
									</a>
								</div>
							</div>
							
					<?php 
						$i++; 
						endforeach; 
						endif;
					?>
						</div>
					</div>
				</div>
				<?php if(count($album_songs) > 5){?>
				<div class="btn-control-holder">
					<a href="#" class="button button-default btn-close">Hide tracks</a>
					<a href="#" class="button btn-opener">Show all (<?php echo count($album_songs);?> tracks)</a>
				</div>
				<?php } ?>
			</div>

		<?php


		}
		
		die();

    }

    function create_albumzip($files,$title){

    	$zip = new ZipArchive();

	    # create a temp file & open it
	    $tmp_file = tempnam('.','');
	    $zip->open($tmp_file, ZipArchive::CREATE);

	    # loop through each file
	    foreach($files as $file){

	        # download file
	        $download_file = file_get_contents($file);

	        #add it to the zip
	        $zip->addFromString(basename($file),$download_file);

	    }

	    $zip->close();

	   
		header("Pragma: public");
		header("Content-Type: application/zip");
		header('Content-disposition: attachment; filename='.$title.'.zip');
		header("Content-Length: " . filesize($download_file));
		header("Content-Transfer-Encoding: binary");

		ob_start();
        readfile($tmp_file);
        ob_end_flush();

        unlink($tmp_file);
        exit;

	    
    }
    
    function miraculous_album_download($album_id)
    {

    	$albumtitle=get_the_title($album_id);
    	 if( function_exists('fw_get_db_post_option') ):
              $ms_album_post_meta_option = fw_get_db_post_option($album_id);
               endif;
         $album_songs = $ms_album_post_meta_option['album_songs'];
         //print_r($album_songs);
        foreach($album_songs as $mst_music_option): 
        	$music_type = get_post_meta($mst_music_option, 'fw_option:music_type', true);
          $attach_meta = array();
              $mpurl= get_post_meta($mst_music_option, 'fw_option:mp3_full_songs', true);
              if($music_type=='free'){
              $mp3url[]=  'https:'.$mpurl['url'];
             }
      endforeach;
     // $files=array('https://wordpresssites.dapldevelopment.com/music/wp-content/uploads/2018/09/file_example_MP3_700KB.mp3','https://wordpresssites.dapldevelopment.com/music/wp-content/uploads/2018/09/file_example_MP3_700KB.mp3');
    create_albumzip($mp3url,$albumtitle);
    //exit;
    	
    }

        // Redefine user notification function
if ( !function_exists('child_miraculous_new_user_notification') ) {
    function child_miraculous_new_user_notification( $user_id, $plaintext_pass = '' ) {
        $user = new WP_User($user_id);

        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);

        $message  = sprintf(__('New user registration on your blog %s:'), get_option('blogname')) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

        //@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message);
        @wp_mail('arvind@digitalaptech.com', sprintf(__('[%s] New User Registration'), get_option('blogname')), $message);

        if ( empty($plaintext_pass) )
            return;

        $message  = __('Hi there,') . "\r\n\r\n";
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
        $message .= wp_login_url() . "\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n";
        $message .= sprintf(__('If you have any problems, please contact me at %s.'), get_option('admin_email')) . "\r\n\r\n";
        $message .= __('Adios!');

        @wp_mail($user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message);

    }
}


/*04-06-2019*/

add_action('wp_ajax_unreadMessage', 'unreadMessage');
add_action('wp_ajax_nopriv_unreadMessage', 'unreadMessage');

function unreadMessage($userid){
	if ( is_user_logged_in()) {
        $userid = get_current_user_id(); 
        $msgcount = new Message();
        $countMsg = $msgcount->_get_count_total_unread_message($userid);
        /*echo "<pre>";
        print_r($countMsg);
        echo '</pre>';*/

		$data['status'] = esc_html__('success','miraculous');
		$data['count'] = count($countMsg);

        echo json_encode($data);
        die();
	}
}

/*04-06-2019*/
