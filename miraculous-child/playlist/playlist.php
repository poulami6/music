<?php
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
/* for get admin playlist */
if(!function_exists('get_admin_playlist')){
    function get_admin_playlist(){

      $message = array();

        $userid = get_current_user_id();

        if (isset($_POST['display_playlist']) && $userid ) {

          if($_POST['display_playlist']!=''){

            $display_playlist =  $_POST['display_playlist'];
            $key_prefix = "admin_playlist_meta_key";

            if( get_user_meta($userid, $key_prefix, true) ){

                update_user_meta($userid, $key_prefix, $display_playlist);

                $message['status'] = esc_html__('success','miraculous');
                $message['class'] = 'notice-success';
                $message['msg'] = esc_html__('Admin Playlist selected successfully.','miraculous');

            }else{

                add_user_meta($userid, $key_prefix, $display_playlist);

                $message['status'] = esc_html__('success','miraculous');
                $message['class'] = 'notice-success';
                $message['msg'] = esc_html__('Admin Playlist selected successfully.','miraculous');
            }
          }else{
            $message['class'] = 'notice-error';
            $message['status'] = esc_html__('error','miraculous');
            $message['msg'] = esc_html__('Please select any Playlist.','miraculous');
          }
        }

        echo "<h1 class='wp-heading-inline'>All Playlist</h1>";

       if(!empty($message)): ?>
        <div class="notice <?php echo $message['class'];?> is-dismissible">
            <p><?php _e($message['msg']); ?></p>
        </div>
        
        <?php endif; 

        $playlist_key = array();
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
   
    echo '<form action="" class="admin-playlist-form" method="post">';
    echo '<input type="submit" name="save_admin_playlist" value="Update" class="button button-primary playlist-button">';
        
        $admin_playlist_meta_key = get_user_meta($userid,'admin_playlist_meta_key',true);

       if(!empty($playlist_key)){
            foreach ($playlist_key as $key => $playlist_val) {
                $playlist_data = explode('_',$playlist_val);
                $user_id = $playlist_data[2];
                $user = get_user_by('id', $user_id);
                $user_meta=get_userdata($user_id);
                    
                $user_roles = $user_meta->roles[0];

                if($user_roles=='administrator'){

                    $admin_playlist_name = str_replace("-"," ",$playlist_data[3]);
                    $admin_playlist_songs = get_user_meta($user_id,$playlist_val,true);
                ?>
                <div class="select-panel-content">
                  <div class="title-box">
                  <input type="radio" name="display_playlist" value="<?php echo $playlist_val;?>" <?php if($admin_playlist_meta_key == $playlist_val){echo 'checked';}?>>
                     <h4><?php echo $admin_playlist_name;?></h4>
                  </div>
                   <div class="list-panel">
                      <ol class="outer-border">
                      <?php 
                        if(!empty($admin_playlist_songs)){
                            foreach ($admin_playlist_songs as $song_key => $admin_playlist_song) {
                      ?>
                         <li class="name">
                            <!-- <input type="checkbox" class="checkbox cb-select-<?php echo $key;?>" name="admin_playlist[]" value="<?php echo $admin_playlist_song;?>" data-id="<?php echo $key;?>"> -->
                            <?php echo get_the_title($admin_playlist_song);?>
                         </li>
                    <?php } }else{?>
                        <li class="name">Playlist Empty</li>
                    <?php }?>
                      </ol>
                   </div>
               </div>
                <?php
                }
            }
       }
    echo '</form>';
    }
}

/* for create admin playlist  */
if(!function_exists('create_admin_playlist')){
    function create_admin_playlist(){

        $message = array();

        $userid = get_current_user_id();

        if (isset($_POST['playlistname']) && $userid ) {
          if($_POST['playlistname']!=''){
            $p_name = str_replace(' ', '-', $_POST['playlistname']);

            $key_prefix = "miraculous_playlist_".$userid."_".$p_name;

            if( get_user_meta($userid, $key_prefix, true) ){

                $message['class'] = 'notice-error';
                $message['status'] = esc_html__('error','miraculous');

                $message['msg'] = esc_html__('Playlist alreay created with this name.','miraculous');

            }else{

                add_user_meta($userid, $key_prefix, '');

                $message['status'] = esc_html__('success','miraculous');
                $message['class'] = 'notice-success';

                $message['msg'] = esc_html__('Playlist created successfully.','miraculous');

            }
          }else{
            $message['class'] = 'notice-error';
            $message['status'] = esc_html__('error','miraculous');
            $message['msg'] = esc_html__('Playlist name mandatory.','miraculous');
          }

            

        }

        if (isset($_POST['save_user_to_admin_playlist']) && $userid) {

             $admin_playlist_name = $_POST['admin_playlist_name'];
             $playlist_song_id    = isset($_POST['admin_playlist']) ? $_POST['admin_playlist']: array();

             if(!empty($playlist_song_id)){
                $exist_playlist_song_id = get_user_meta($userid, $admin_playlist_name, true);

            if($exist_playlist_song_id!=''){
              foreach ($playlist_song_id as $songkey => $song_id) {
                if(!in_array($song_id,$exist_playlist_song_id)){
                    array_push($exist_playlist_song_id, $song_id);
                    
                }
              }
              $admin_playlist_song_id = $exist_playlist_song_id;
            }else{
              $admin_playlist_song_id = $playlist_song_id;
            }

            if(update_user_meta($userid, $admin_playlist_name, $admin_playlist_song_id)){
              $message['status'] = esc_html__('success','miraculous');
              $message['class'] = 'notice-success';
              $message['msg'] = esc_html__('Playlist adopted successfully.','miraculous');
            }else{
              $message['class'] = 'notice-error';
              $message['status'] = esc_html__('error','miraculous');
              $message['msg'] = esc_html__('All songs already added in this Playlist.','miraculous');
            }

             }else{
              $message['class'] = 'notice-error';
              $message['status'] = esc_html__('error','miraculous');
              $message['msg'] = esc_html__('Please select songs for Playlist.','miraculous');
             }
            

        }

        ?>
        <h1 class='wp-heading-inline'>Add Playlist</h1>

        <?php if(!empty($message)):?>
        <div class="notice <?php echo $message['class'];?> is-dismissible">
            <p><?php _e($message['msg']); ?></p>
        </div>
        
        <?php endif; ?>

            <div id="nav-menu-header" class="nav-menu-header-new">
               <p class="playlist-heading">Create New Playlist</p>
               <div class="major-publishing-actions wp-clearfix">
               <form action="" method="post">
                  <label class="menu-name-label" for="playlistname">Playlist Name</label>
                  <input name="playlistname" id="playlistname" type="text" class="regular-text menu-item-textbox">
                  <!-- <div class="publishing-action"> -->
                     <input type="submit" name="save_playlist" id="save_playlist" class="button button-primary playlist-button" value="Create Playlist">             
                  <!-- </div> -->
                </form>
               </div>
            </div>
            
            
        <?php


        $playlist_key = array();
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
        ?>
        <form action="" class="playlist-form" method="post">
         <input type="submit" name="save_user_to_admin_playlist" value="Update" class="button button-primary playlist-button">
         <div class="playlist-select">
            <label class="menu-name-label" for="playlist-selection">Select Playlist</label>
            <select name="admin_playlist_name" class="playlist-selection" id="playlist-selection">
            <?php
                if(!empty($playlist_key)){
                foreach ($playlist_key as $play_key => $playlist_value) {
                    $playlist_name = explode('_',$playlist_value);
                    $user_id = $playlist_name[2];
                    $user = get_user_by('id', $user_id);
                    $user_name = $user->first_name . ' ' . $user->last_name;
                    $admin_playlist_name = str_replace("-"," ",$playlist_name[3]);

                    $user_meta=get_userdata($user_id);
                    
                    $user_roles = $user_meta->roles[0];

                    if($user_roles=='administrator'){
            ?>
                <option value="<?php echo $playlist_value;?>"><?php echo $admin_playlist_name;?></option>
            <?php }}}?>
            </select>
        </div>
        <p class="user-playlist-heading">Users Playlist</p>

        <?php
       if(!empty($playlist_key)){
            foreach ($playlist_key as $key => $playlist_val) {
                $playlist_data = explode('_',$playlist_val);
                $user_id = $playlist_data[2];
                $user = get_user_by('id', $user_id);
                $user_name = $user->first_name . ' ' . $user->last_name;
                $user_playlist_name = str_replace("-"," ",$playlist_data[3]);
                
                $playlist_songs = get_user_meta($user->ID,$playlist_val,true);

                $user_meta=get_userdata($user_id);
                $user_roles = $user_meta->roles[0];
                if($user_roles!='administrator'){
        ?>
           <div class="select-panel-content">
              <div class="title-box">
              <input class="cb-select-all" id="<?php echo $key;?>" type="checkbox">
                 <h4><?php echo $user_playlist_name;?></h4>
              </div>
               <div class="list-panel">
                  <ol class="outer-border">
                  <?php 
                    if(!empty($playlist_songs)){
                        foreach ($playlist_songs as $song_key => $playlist_song) {
                  ?>
                     <li class="name">
                        <input type="checkbox" class="checkbox cb-select-<?php echo $key;?>" name="admin_playlist[]" value="<?php echo $playlist_song;?>" data-id="<?php echo $key;?>">
                        <?php echo get_the_title($playlist_song);?>
                     </li>
                <?php } }?>
                  </ol>
               </div>
           </div>
        <?php
                }
            }
       }
       echo '</form>';
    }


}

add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
    add_menu_page( 'Playlist', 'Playlist', 'manage_options', 'playlist', 'get_admin_playlist', 'dashicons-tickets', 6);
    add_submenu_page( 'playlist', 'Playlist', 'Add Playlist', 'manage_options', 'add-playlist', 'create_admin_playlist' );
}

function enqueue_admin_style_script() {
    
    wp_enqueue_script( 'admin-script', get_stylesheet_directory_uri() . '/js/admin-script.js', array(), '1.0' );
    wp_enqueue_style( 'admin-script', get_stylesheet_directory_uri() . '/css/admin.css', array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_style_script' );

?>