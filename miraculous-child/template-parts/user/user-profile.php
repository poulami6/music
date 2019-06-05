<?php

$userid = get_current_user_id();

$user = get_user_by('ID',$userid);

$user_meta=get_userdata($userid);
$user_roles =$user_meta->roles;


$register_date = $user->user_registered;

$follower_users = get_user_meta($userid, 'follower_users'.$userid, true);

$last_active = get_user_meta($userid,'wc_last_active',true);
$description = get_user_meta($userid,'description',true);
$user_genres = unserialize(get_user_meta($user->ID,'user_genres',true));
$user_gender = get_user_meta($user->ID,'user_gender',true);

$user_profile_img = get_user_meta($userid, 'user_profile_img', true);
$user_country = get_user_meta($userid, 'billing_country', true);

$user_avatar = get_avatar_url($userid);

if($user_profile_img!=''){
   $profile_img = $user_profile_img;
}else{
   $profile_img = $user_avatar;
}

global $woocommerce;
$countries_obj   = new WC_Countries();
$countries   = $countries_obj->__get('countries');

$genres = get_categories('taxonomy=genre&type=ms-artists');

global $wpdb;

$table_name = $wpdb->prefix . "friends";
$confirmed_friends = $wpdb->get_results("SELECT UID,FID,status,invite_date FROM ".$table_name." WHERE  UID=".$userid. " AND status = 'Confirmed' ORDER BY f_id DESC");


$miraculous_theme_data = '';
 if (function_exists('fw_get_db_settings_option')):  
  $miraculous_theme_data = fw_get_db_settings_option();     
 endif;

 $currency = '';
 if(!empty($miraculous_theme_data['paypal_currency']) && function_exists('miraculous_currency_symbol')):
   $currency = miraculous_currency_symbol( $miraculous_theme_data['paypal_currency'] );
 endif;

?>

<div class="tab-item" id="tab-my-profile">
   <div class="content-block my-profile-block">
   <div id="user-profile-view">
      <div class="info-unit">
         <div class="heading-holder">
            <div class="title-holder">
               <h2><?php echo $user->first_name . ' ' . $user->last_name;?></h2>
               <!-- <strong class="sub-title">User</strong> -->
            </div>
            <div class="cell">
               <a href="javascript:;" id="profile-edit-button" class="button">Edit</a>
               <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>/woo-wallet/add/" class="button">Buy Credit</a>
            </div>
         </div>
         <div class="visual-box">
            <img src="<?php echo $profile_img;?>" alt="photo" width="160" height="192"><i class="fa_icon edit_icon"></i>
            <ul class="profile-info-list">
               <li><i class="icon-user"></i> <a href="javascript:;"><?php echo !empty($confirmed_friends) ? count($confirmed_friends) : 0 ?></a> Friends</li>
               <li><i class="icon-user"></i> <a href="javascript:;"><?php echo getUserProfileVisitors($userid);?></a> Visitors</li>
               <li><i class="icon-play"></i> <a href="javascript:;"><?php echo !empty($follower_users) ? count($follower_users) : 0 ?></a> Listeners</li>
            </ul>
         </div>
         <div class="text-holder">
            <?php echo $description;?>
         </div>
      </div>
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
               <dd><?php echo ($user_gender!='') ? ucwords($user_gender) : '' ?></dd>
            </dl>
         </div>
         <div class="col">
            <dl>
               <dt>Email:</dt>
               <dd><?php echo ($user->user_email!='') ? $user->user_email : 'Not Available';?></dd>
            </dl>
            <dl>
               <dt>Country:</dt>
               <dd><?php echo ($user_country!='') ? WC()->countries->countries[$user_country] : 'Not Available';?></dd>
            </dl>
            <dl>
               <dt>Music:</dt>
               <dd><?php echo !empty($user_genres) ? ucwords(implode(', ',$user_genres)) : 'Not Available' ?></dd>
            </dl>
            <!-- <dl>
               <dt>Other:</dt>
               <dd>Lorem Ipsum</dd>
            </dl> -->
            
         </div>
      </div>
    </div>
    <div id="user-profile-edit">
    <form id="child_profile_edit" method="post">
      <div class="info-unit">
         <div class="heading-holder">
            <div class="title-holder">
               
               <input type="text" name="first_name" value="<?php echo $user->first_name . ' ' . $user->last_name;?>" id="first_name">
            </div>
            <div class="cell">
               <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>" class="button">Back</a>
            </div>
         </div>
         <div class="visual-box">
         <i class="fa fa-pencil-square-o child_img_edit_plus"></i>
            <img src="<?php echo $profile_img;?>" alt="photo" width="160" height="192" id="img-preview" class="img-fluid">
         </div>
         <div class="text-holder">
            <textarea id="user-description"><?php echo $description;?></textarea>
            <?php

              $editor_id = 'user-description';
              $settings =   array(
                'wpautop' => true, //Whether to use wpautop for adding in paragraphs. Note that the paragraphs are added automatically when wpautop is false.
                'media_buttons' => true, //Whether to display media insert/upload buttons
                'textarea_name' => $editor_id, // The name assigned to the generated textarea and passed parameter when the form is submitted.
                //'textarea_rows' => get_option('default_post_edit_rows', 10), // The number of rows to display for the textarea
                'textarea_rows' => 3, // The number of rows to display for the textarea
                'tabindex' => '', //The tabindex value used for the form field
                'editor_css' => '', // Additional CSS styling applied for both visual and HTML editors buttons, needs to include <style> tags, can use "scoped"
                'editor_class' => '', // Any extra CSS Classes to append to the Editor textarea
                'teeny' => false, // Whether to output the minimal editor configuration used in PressThis
                'dfw' => false, // Whether to replace the default fullscreen editor with DFW (needs specific DOM elements and CSS)
                'tinymce' => true, // Load TinyMCE, can be used to pass settings directly to TinyMCE using an array
                'quicktags' => true, // Load Quicktags, can be used to pass settings directly to Quicktags using an array. Set to false to remove your editor's Visual and Text tabs.
                'drag_drop_upload' => true //Enable Drag & Drop Upload Support (since WordPress 3.9) 
              );

              //wp_editor( $description, $editor_id,$settings);
            ?>
         </div>
      </div>
      <div class="info-spec">
         <div class="col">
            <dl>
               <dt>Gender:</dt>
               <dd>
                 <input type="radio" name="user_gender" class="user_gender" value="male" <?php if($user_gender == 'male'){echo 'checked';}?>>Male
                 <input type="radio" name="user_gender" class="user_gender" value="female" <?php if($user_gender == 'female'){echo 'checked';}?>>Female
               </dd>
            </dl>
            <dl>
               <dt>Country:</dt>
               <dd>
                 <select name="user_country" id="input-country">
                  <option value="">Select country</option>
                 <?php
                    if(!empty($countries)){
                       foreach ($countries as $country_key => $country) {
                          ?>
                      <option value="<?php echo $country_key;?>" <?php if(isset($user_country) && $user_country==$country_key){echo 'selected';}?>> <?php echo $country; ?></option> 
                    <?php
                         
                       }
                    }
                 ?>
                 </select>
               </dd>
            </dl>
         </div>
         <div class="genre-list">
           <dl>
               <dt>Music:</dt>
               <dd>
                  <?php if(!empty($genres)){
                         foreach ($genres as $genre_key => $genre) {
                  ?>
                    <label class="checkbox-inline">
                      <input type="checkbox" name="user_genres[]" value="<?php echo $genre->slug;?>" class="form-control user_genres" <?php if(!empty($user_genres) && in_array($genre->slug, $user_genres)){echo 'checked';}?> ><?php echo $genre->name;?>
                    </label>
              
                    <?php
                        }
                      }
                    ?>
               </dd>
            </dl>
         </div>
         
        <div class="cell">
        <input type="checkbox" name="change_pass" value="on" class="button change_pass" id="change_pass"><?php esc_html_e('Change Password', 'miraculous'); ?>
        </div>
         <div class="change_password_slide">
         <dl>
             <dt><?php esc_html_e('Old Password *', 'miraculous'); ?></dt>
             <dd>
                <input type="password" placeholder="<?php esc_attr_e('******','miraculous'); ?>" id="old_password" class="form-control">
             </dd>
          </dl>
          <dl>
             <dt><?php esc_html_e('New Password *', 'miraculous'); ?>  <i class="fa fa-info-circle" title="Password must be have at least 6 characters with alphanumeric" aria-hidden="true"></i></dt>
             <dd>
                <input type="password" placeholder="<?php esc_attr_e('******','miraculous'); ?>" id="ed_password" class="form-control check-password">
                <span id="result"></span>
             </dd>
          </dl>
          <dl>
             <dt><?php esc_html_e('Confirm Password *', 'miraculous'); ?></dt>
             <dd>
               <input type="password" placeholder="<?php esc_attr_e('******','miraculous'); ?>" id="ed_confpassword" class="form-control">
             </dd>
          </dl>
           
        </div>
      </div>

      <div class="user-profile-save-section">
        <input type="hidden" id="image-url" value="<?php echo ($user_profile_img!='') ? $user_profile_img : '';?>">
        <input type="hidden" id="image-id" value="">
        <input type="submit" id="ms_profile_update" class="ms_btn password-validate" value="Save">
        <!-- <button class="hst_loader"><i class="fa fa-circle-o-notch fa-spin"></i> 
        <?php //esc_html_e('Loading', 'miraculous'); ?></button> -->
        <!-- <input type="reset" class="ms_btn reset_form" value="reset"> -->
      </div>
    </form>
    </div>

    <?php
        $userSubscription = new Subscription();
        $subscriptionDetails =  $userSubscription->_getUserSebscription($userid);
        
    ?>
      <div class="additional-info-block">
         <div class="info-box">
            <div class="col-holder">
               <h2>Package Details</h2>
               <div class="credit-box">
                  <?php

                  $packages_page_link = esc_url(home_url( '/packages/' )); 

                    if(!empty($subscriptionDetails)){
                      $extra_data = json_decode($subscriptionDetails->extra_data);

                      

                  ?>
                    <p>Package Name <mark> <?php echo get_the_title($subscriptionDetails->itemid);?> </mark></p>
                    <p>Package Amount <mark> <?php echo $currency.$subscriptionDetails->payment_amount;?> </mark></p>

                    <p>Monthly Download Limit <mark> <?php echo $subscriptionDetails->monthly_download;?> </mark></p>
                    <p>Remains Download Limit <mark> <?php echo $subscriptionDetails->remains_download;?> </mark></p>

                  <?php if(!empty($user_roles) && in_array('artist', $user_roles)){?>
                    <p>Monthly Upload Limit <mark> <?php echo $subscriptionDetails->monthly_upload;?> </mark></p>
                    <p>Remains Upload Limit <mark> <?php echo $subscriptionDetails->remains_upload;?> </mark></p>
                  <?php }?>

                    <p>Expiry Date  <mark> <?php echo date("d/m/Y H:m:s", strtotime($subscriptionDetails->expiretime));?> </mark></p>
                    
                    <p>Purchage Date <mark> <?php echo date("d/m/Y H:m:s", strtotime($subscriptionDetails->createdtime));?> </mark></p>
                    <p>Payment By <mark> <?php echo isset($extra_data->payment_via) ? $extra_data->payment_via : ' ';?> </mark></p>

                    <dl class="total">
                    <?php 
                            
                        $date1 = new DateTime(date('Y-m-d H:m:s'));  //current date or any date
                        $date2 = new DateTime($subscriptionDetails->expiretime);   //Future date
                        $diff = $date2->diff($date1)->format("%a");  //find difference
                        $days = intval($diff);   //rounding days
                        
                     if($days > 0){
                     ?>

                       <dt>Package renewal after </dt>
                       <dd>
                       <mark> <?php echo $days.' days later';?></mark>
                       <?php }else{?>
                       <a href="<?php echo $packages_page_link;?>" class="ms_btn" >Reniew</a>
                       <?php }?>
                    </dl>
                  <?php
                    }else{
                      echo "<p>No Package Available</p>";
                      echo '<a href="'.$packages_page_link.'" class="ms_btn" >Buy Now</a>';
                    }
                  ?>
                  


                  
               </div>
            </div>
         </div>
         <div class="info-box">
            <div class="col-holder">
               <h2>Credit History</h2>
               <p>Available credit <mark><?php echo woo_wallet()->wallet->get_wallet_balance( get_current_user_id() ); ?></mark> </p>
               <p>Latest 2 Transactions <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>/woo-wallet-transactions/" class="cm-transaction-amount"> show All</a></p>
               <?php 
                  $transactions = get_wallet_transactions(array( 'user_id' => $userid, 'limit' => 2 ) );
                  if(!empty($transactions)){
               ?>
               <ul class="history-list">
                  <?php foreach ($transactions as $key => $transactions_data) { ?>
                  <li>
                     <time datetime="2014-05-12T20:20"><?php echo date("d-m-Y ", strtotime($transactions_data->date));?> at <?php echo date("H:m:s", strtotime($transactions_data->date));?></time>
                     <p>
                        <?php 
                            echo $transactions_data->details;
                            if($transactions_data->type == 'credit'){
                              echo '<span class="woo-wallet-transaction-type-credit cm-transaction-amount">+'.$currency.$transactions_data->amount.'</span>';
                            }else{
                              echo '<span class="woo-wallet-transaction-type-debit cm-transaction-amount">-'.$currency.$transactions_data->amount.'</span>';
                            }
                        ?> 
                         
                      </p>
                  </li>
                  <?php } ?>
               </ul>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>