<?php
$user_id = get_current_user_id();
global $wpdb;

$table_name = $wpdb->prefix . "friends";
$confirmed_friends = $wpdb->get_results("SELECT UID,FID,status,invite_date FROM ".$table_name." WHERE  UID=".$user_id. " AND status = 'Confirmed' ORDER BY f_id DESC");

$sent_friends = $wpdb->get_results("SELECT UID,FID,status,invite_date FROM ".$table_name." WHERE  UID=".$user_id. " AND status = 'Pending'");

$pending_friends = $wpdb->get_results("SELECT UID,FID,status,invite_date FROM ".$table_name." WHERE  FID=".$user_id. " AND status = 'Pending'");


 $following_users = get_user_meta($user_id, 'following_users'.$user_id, true);
 $follower_users = get_user_meta($user_id, 'follower_users'.$user_id, true);


?>
<div class="tab-item" id="tab-my-favorites">
   <div class="content-block my-favorites-block">
      <div class="section-header">
         <h2>Friends List</h2>
      </div>
      <ul class="inner-tabset">
         <li class="active"><a href="#tab-my-friends"><span>My Friends</span></a></li>
         <li><a href="#tab-my-followers"><span>My Followers</span></a></li>
         <li><a href="#tab-pending-friend"><span>Pending Request</span><?php echo (count($pending_friends) > 0) ? '<span class="badge badge-secondary">'.count($pending_friends).'</span>': ''; ?></a></li>
         <li><a href="#tab-sent-users"><span>Sent Request</span></a></li>
      </ul>
      <div class="tab-item" id="tab-my-friends">
            <div class="section-header">
               <h3>My Friends</h3>
               
            </div>
            <?php

              if(!empty($confirmed_friends)){
            ?>
            <ul class="persons-list friends-list">
            <?php 

                foreach ($confirmed_friends as $key => $confirmed_friend) {
                  $confirmed_fid = $confirmed_friend->FID;
                  $confirmed_friend_profile_img = get_user_meta($confirmed_fid, 'user_profile_img', true);

                  $confirmed_friend_avatar = get_avatar_url($confirmed_fid);

                  if($confirmed_friend_profile_img!=''){
                    $confirmed_profile_img = $confirmed_friend_profile_img;
                  }else{
                    $confirmed_profile_img = $confirmed_friend_avatar;
                  }

                  $confirmed_friend_details = get_user_by( 'id', $confirmed_fid );
              ?>
              <li id="list_<?php echo $confirmed_fid;?>">
                  <div class="item-holder">
                     <div class="img-box">
                        <img src="<?php echo $confirmed_profile_img;?>" alt="photo" width="122" height="122">
                        <div class="buttons">
                           <a href="<?php echo esc_url(home_url( '/users-profile')); ?>/<?php echo $confirmed_friend_details->user_login;?>" class="button">VIEW PROFILE</a>
                           <a href="javascript:;" class="btn-remove1 add-remove-friend" data-type="remove" data-page="list" data-fid="<?php echo $confirmed_fid;?>">REMOVE</a>
                        </div>
                     </div>
                     <div class="text-holder">
                        <strong class="name"><?php echo $confirmed_friend_details->first_name . ' ' . $confirmed_friend_details->last_name;?></strong>
                     </div>
                  </div>
               </li>
              <?php
                }
             
            ?>
            </ul>
            <?php
             }else{
                echo "<p class='no-found'>Friend list emplty.</p>";
              }
            ?>
            <!-- <div class="paging-holder">
               <ul class="paging">
                  <li class="prev"><a href="#">&laquo; Prev</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><strong>3</strong></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">6</a></li>
                  <li class="next"><a href="#">Next &raquo;</a></li>
               </ul>
            </div> -->
         
      </div>
      <div class="tab-item" id="tab-my-followers">
            <div class="section-header">
               <h3>My Followers</h3>
            </div>
            <?php  if(!empty($follower_users)){ ?>
              <ul class="persons-list friends-list">
              <?php
                  foreach ($follower_users as $key => $follower_user) {
                    
                    $follower_user_profile_img = get_user_meta($follower_user, 'user_profile_img', true);

                    $follower_user_avatar = get_avatar_url($follower_user);

                    if($follower_user_profile_img!=''){
                      $follower_user_img = $follower_user_profile_img;
                    }else{
                      $follower_user_img = $follower_user_avatar;
                    }

                    $follower_user_details = get_user_by( 'id', $follower_user );
                ?>
                <li id="list_<?php echo $pending_uid;?>">
                    <div class="item-holder">
                       <div class="img-box">
                          <img src="<?php echo $follower_user_img;?>" alt="photo" width="122" height="122">
                          <div class="buttons">
                             <a href="<?php echo esc_url(home_url( '/users-profile')); ?>/<?php echo $follower_user_details->user_login;?>" class="button">VIEW PROFILE</a>
                              
                              <a href="javascript:;" class="btn-remove1 icon_unfollow" id="user-follow" data-follow="<?php echo $follower_user;?>">UNFOLLOW</a>

                          </div>
                       </div>
                       <div class="text-holder">
                          <strong class="name"><?php echo $follower_user_details->first_name . ' ' . $follower_user_details->last_name;?></strong>
                       </div>
                    </div>
                 </li>
                <?php
                  }
              ?>
                
              </ul>
              <?php }else{ echo '<p class="no-found"> No follower found</p>';}?>
        
      </div>
      <div class="tab-item" id="tab-pending-friend">
            <div class="section-header">
               <h3>Pending Request</h3>
            </div>
            <?php  if(!empty($pending_friends)){ ?>
            <ul class="persons-list friends-list">
            <?php
                foreach ($pending_friends as $key => $pending_friend) {
                  $pending_uid = $pending_friend->UID;
                  $pending_friend_profile_img = get_user_meta($pending_uid, 'user_profile_img', true);

                  $pending_friend_avatar = get_avatar_url($pending_uid);

                  if($pending_friend_profile_img!=''){
                    $pending_profile_img = $pending_friend_profile_img;
                  }else{
                    $pending_profile_img = $pending_friend_avatar;
                  }

                  $pending_friend_details = get_user_by( 'id', $pending_uid );
              ?>
              <li id="list_<?php echo $pending_uid;?>">
                  <div class="item-holder">
                     <div class="img-box">
                        <img src="<?php echo $pending_profile_img;?>" alt="photo" width="122" height="122">
                        <div class="buttons">
                           <a href="<?php echo esc_url(home_url( '/users-profile')); ?>/<?php echo $pending_friend_details->user_login;?>" class="button">VIEW PROFILE</a>
                           
                           <a href="javascript:;" class="btn-add add-remove-friend" data-type="accept" data-page="list" data-fid="<?php echo $pending_uid;?>">Accept</a>
                           <a href="javascript:;" class="btn-remove1 add-remove-friend" data-type="remove" data-page="list" data-fid="<?php echo $pending_uid;?>">Remove</a>
                           
                        </div>
                     </div>
                     <div class="text-holder">
                        <strong class="name"><?php echo $pending_friend_details->first_name . ' ' . $pending_friend_details->last_name;?></strong>
                     </div>
                  </div>
               </li>
              <?php
                }
            ?>
              
            </ul>
            <?php }else{ echo '<p class="no-found"> Pending list empty</p>';}?>
            <!-- <div class="paging-holder">
               <ul class="paging">
                  <li class="prev"><a href="#">&laquo; Prev</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><strong>3</strong></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">6</a></li>
                  <li class="next"><a href="#">Next &raquo;</a></li>
               </ul>
            </div> -->
      </div>
      <div class="tab-item" id="tab-sent-users">
            <div class="section-header">
               <h3>Sent Request</h3>
            </div>
            <?php  if(!empty($sent_friends)){ ?>
            <ul class="persons-list friends-list">
            <?php
                foreach ($sent_friends as $key => $sent_friend) {
                  $sent_fid = $sent_friend->FID;
                  $sent_friend_profile_img = get_user_meta($sent_fid, 'user_profile_img', true);

                  $sent_friend_avatar = get_avatar_url($sent_fid);

                  if($sent_friend_profile_img!=''){
                    $sent_profile_img = $sent_friend_profile_img;
                  }else{
                    $sent_profile_img = $sent_friend_avatar;
                  }

                  $sent_friend_details = get_user_by( 'id', $sent_fid );
              ?>
              <li id="list_<?php echo $sent_fid;?>">
                  <div class="item-holder">
                     <div class="img-box">
                        <img src="<?php echo $sent_profile_img;?>" alt="photo" width="122" height="122">
                        <div class="buttons">
                           <a href="<?php echo esc_url(home_url( '/users-profile')); ?>/<?php echo $sent_friend_details->user_login;?>" class="button">VIEW PROFILE</a>
                           
                           <a href="javascript:;" class="btn-remove1 add-remove-friend" data-type="remove" data-page="list" data-fid="<?php echo $sent_fid;?>">Remove</a>
                           
                        </div>
                     </div>
                     <div class="text-holder">
                        <strong class="name"><?php echo $sent_friend_details->first_name . ' ' . $sent_friend_details->last_name;?></strong>
                     </div>
                  </div>
               </li>
              <?php
                }
            ?>
              
            </ul>
            <?php }else{ echo '<p class="no-found"> Pending list empty</p>';}?>
            <!-- <div class="paging-holder">
               <ul class="paging">
                  <li class="prev"><a href="#">&laquo; Prev</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><strong>3</strong></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">6</a></li>
                  <li class="next"><a href="#">Next &raquo;</a></li>
               </ul>
            </div> -->
      </div>
   </div>
</div>