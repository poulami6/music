

<?php
   /**
    * Template Name: Users Profile
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   get_header();

   global $wp_query;
   global $wpdb;

  

if(!isset($wp_query->query_vars['username'])){
  
?>
<script language="javascript" type="text/javascript">
var url = '<?php echo home_url();?>';
//alert(url);
document.location = url;
</script>
<?php
exit();
  
}else{
 $username = $wp_query->query_vars['username']; 
}
   
  $user = get_user_by('login',$username);
  $user_id = $user->ID;
  $register_date = $user->user_registered;

  setUserProfileVisitorss($user_id);

  $last_active = get_user_meta($user->ID,'wc_last_active',true);
  $description = get_user_meta($user->ID,'description',true);
  $user_genres = unserialize(get_user_meta($user->ID,'user_genres',true));
  $user_gender = get_user_meta($user->ID,'user_gender',true);

  $user_profile_img = get_user_meta($user->ID, 'user_profile_img', true);
  $user_country = get_user_meta($user->ID, 'billing_country', true);

  //die();
  $user_avatar = get_avatar_url( $user->ID );

  if($user_profile_img!=''){
     $profile_img = $user_profile_img;
  }else{
     $profile_img = $user_avatar;
  }
  
  

$playlist_key = get_users_playlist($user_id);

$userid = get_current_user_id();
$following_users = get_user_meta($userid, 'following_users'.$userid, true);
$follower_users = get_user_meta($user->ID, 'follower_users'.$user->ID, true);




$table_name = $wpdb->prefix . "friends"; 
$friend_rs = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE FID = ".$user->ID. " AND UID=".$userid);

?>


    <main id="main">
      <div class="container">
        <div id="twocolumns">
        
          <div id="content">
          <?php if(!empty($user)):?>
            <div class="section-header">
              <h1><?php echo $user->first_name . ' ' . $user->last_name;?></h1>

              <?php 

                if(is_user_logged_in()){
                  if($userid != $user->ID){ 
             ?>
              <div class="cell">

              <?php

                if(isset($friend_rs) && $friend_rs->status == 'Pending'){
                  $type = 'remove';
                  $class = 'remove-icon';
                  $text = 'Request Sent';
                }else if(isset($friend_rs) && $friend_rs->status == 'Confirmed'){
                  $type = 'remove';
                  $class = 'remove-icon';
                  $text = 'Remove Friend';
                }else if(isset($friend_rs) && $friend_rs->status == 'Denied'){
                  $type = 'remove';
                  $class = 'remove-icon';
                  $text = 'Remove Request';
                }else{
                  $type = 'add';
                  $class = 'add-icon';
                  $text = 'Add Friend';
                }

              ?>
              <a href="javascript:;" class="btn btn-danger <?php echo $class;?> add-remove-friend"  data-page="user" data-type="<?php echo $type;?>" data-fid="<?php echo $user->ID;?>"><?php echo $text;?></a>

              <?php if(isset($following_users) && !empty($following_users) && in_array($user->ID, $following_users)):?>
                <a href="javascript:;" class="btn btn-danger icon_unfollow" id="user-follow" data-follow="<?php echo $user->ID;?>">UNFOLLOW</a>
              <?php else:?>
                <a href="javascript:;" class="btn btn-danger icon_follow" id="user-follow" data-follow="<?php echo $user->ID;?>">FOLLOW</a>
              <?php endif;?>
                
                <a href="javascript:;" class="btn send-message" data-receiver="<?php echo $user->ID;?>" >Message</a>
              </div>
              <?php 
                    } 
                }else{
              ?>
                  <div class="cell">
                    <a href="javascript:;" class="btn btn-danger add-icon" data-toggle="modal" data-target="#myModal1">Add Friend</a>
                    <a href="javascript:;" class="btn btn-danger icon_follow" data-toggle="modal" data-target="#myModal1">FOLLOW</a>
                    <a href="javascript:;" class="btn" data-toggle="modal" data-target="#myModal1" >Message</a>
                  </div>
              <?php }?>
            </div>
            <div class="content-block about-block">
              <div class="section-header">
                <h1>About</h1>
              </div>
              <div class="img-box">
                <img src="<?php echo $profile_img;?>" alt="photo" width="160" height="192">
              </div>
              <div class="text-holder">
                <p><?php echo $description;?></p>
                <div class="info-spec">
                  <div class="col">
                    <dl>
                      <dt>Last Online:</dt>
                      <dd><?php echo ($last_active!='') ? date("d.m.Y",$last_active): 'Not Active';?></dd>
                    </dl>
                    <dl>
                      <dt>Register:</dt>
                      <dd><?php echo ($register_date!='') ? date_format(date_create($register_date),"M d, Y"):'';?></dd>
                    </dl>
                    <dl>
                      <dt>Gender:</dt>
                      <dd><?php echo ($user_gender!='') ? $user_gender : ''; ?></dd>
                    </dl>
                  </div>
                  <div class="col">
                    <dl>
                      <dt>Country:</dt>
                      <dd><?php echo ($user_country!='') ? WC()->countries->countries[$user_country] : 'Not Available';?></dd>
                    </dl>
                    <dl>
                      <dt>Followers:</dt>
                      <dd id="followers-count"><?php echo !empty($follower_users) ? count($follower_users): 0; ?></dd>
                    </dl>
                    <dl>
                      <dt>Music:</dt>
                      <dd><?php echo !empty($user_genres) ? ucwords(implode(', ',$user_genres)) : 'Not Available' ?></dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
            <?php
              if( !isset($playlist_key['msg'])){
                foreach ($playlist_key as $key => $playlist_val) {
                    $playlist_data = explode('_',$playlist_val);
                    $playlist_name = str_replace("-"," ",$playlist_data[3]);
                    $playlist_songs = get_user_meta($user_id,$playlist_val,true);

                    
                ?>
                <div class="col-6">
                <div class="content-block playlist-block">
                  <div class="section-header">
                    <h2><?php echo $playlist_name;?></h2>
                  </div>
                  <div class="list-song">
                  <ol class="playlist-item">
                    <?php 
                      if(!empty($playlist_songs)){
                          foreach ($playlist_songs as $song_key => $playlist_song) {

                            $data_type = '';
                            if('ms-albums' == get_post_type($playlist_song)){
                              $data_type = 'album';
                            }else if('ms-music' == get_post_type($playlist_song)){
                              $data_type = 'music';
                            }else if('ms-artists' == get_post_type($playlist_song)){
                              $data_type = 'artist';
                            }

                          $ms_album_post_meta_option = '';
                          if( function_exists('fw_get_db_post_option') ):
                          $ms_album_post_meta_option = fw_get_db_post_option($playlist_song);
                          endif;
                          

                          $attach_meta = array();
                          $mpurl = get_post_meta($playlist_song, 'fw_option:mp3_full_songs', true);
                          if($mpurl) {
                          $attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                          }
                    ?>
                    <li>
                      <strong class="item-name">
                      <a href="<?php echo esc_url( get_permalink($playlist_song) ); ?>">
                        <?php echo get_the_title($playlist_song);?>
                      </a>
                      </strong>
                      <div class="cell">
                        <span class="time"><?php echo (isset($attach_meta['length_formatted'])) ? $attach_meta['length_formatted'] : " "; ?></span>
                        <div class="menu-box">
                          <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                          <div class="menu-drop">
                            <div class="drop-holder">
                              <ul class="drop-list">
                                <li><a href="javascript:;" class="favourite_music" data-musicid="<?php echo $playlist_song;?>">Add To Favorite</a></li>
                                    <li>
                                       <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo $playlist_song;?>">Add To Playlist</a>
                                    </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo $playlist_song;?>" data-musictype="<?php echo $data_type;?>">
                        <span class="play_all btn-play">Play All</span>
                        <span class="pause_all btn-pause">Pause</span>
                        </a>
                      </div>
                    </li>
                    <?php } }else{?>
                    <li>Playlist Empty</li>
                    <?php }?>
                  </ol>
                  </div>
                </div>
              </div>
                <?php
                }
              }
            ?>
              
              
            </div>
          <?php else: ?>
          <div class="no-found-data">No User found</div>
          <?php endif; ?>
          </div>
        
          <?php 
            // Include the featured songs content template.
            get_template_part( 'template-parts/content', 'left-side-bar' );
          ?>
        </div>
      </div>
    </main>

<?php get_footer();?>

