<?php
   /**
    * The template for displaying the footer
    *
    * Contains the closing of the #content div and all content after.
    *
    * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
    *
    * @package Miraculous
    */
   
   $miraculous_data = fw_get_db_settings_option();
   
   
   
   ?>
<footer id="footer">
   <div class="container">
      <div class="copy">
         <p>&copy; <?php if(!empty($miraculous_data)): echo $miraculous_data['footer_copyrigth']; endif; ?></p>
      </div>
      <div class="footer-nav-panel">
         <!-- <div class="fb-like" data-href="<?php //echo get_the_permalink(get_the_id());?>" data-layout="standard" data-action="like" data-show-faces="true"></div> -->
         <ul>
            <li><a href="#">Copyright</a></li>
         </ul>
         <ul class="social-networks">
            <li class="facebook"><a href="#">Facebook</a></li>
            <li class="twitter"><a href="#">Twitter</a></li>
         </ul>
         <?php  wp_nav_menu( array('menu' => 'footer-menu','theme_location' => '', 'container' => 'false', 'menu_id' => 'false', 'menu_class'  => 'footer-nav' ) );  ?>
         <a href="#wrapper" class="back-to-top">Back to top</a>
      </div>
   </div>
</footer>
<!-- <div class="player-panel"> -->
<!-- <div class="player-holder"> -->
<?php
   $miraculous_core = '';
   if(class_exists('Miraculouscore')):
    $miraculous_core = new Miraculouscore();
    $miraculous_core->miraculous_audio_jplayer();
    //$miraculous_core->miraculous_login_register_popup();
    $miraculous_core->miraculous_language_selector(); 
    $miraculous_core->miraculous_create_playlist_popup(); 
    $miraculous_core->miraculous_add_music_in_playlist_popup();
   endif;
   ?>
<?php
   /** 
   *Login & Register Popup
   */
   
   $miraculous_loginbar_data = '';
    if(function_exists('fw_get_db_settings_option')):  
          $miraculous_loginbar_data = fw_get_db_settings_option();     
    endif; 
   $loginregister_image = '';
   if(!empty($miraculous_loginbar_data['loginregister_image']['url'])):
    $loginregister_image = $miraculous_loginbar_data['loginregister_image']['url'];
   else:
    $loginregister_image = get_template_directory_uri().'/assets/images/register_img.png';
   endif;
   
   $genres = get_categories('taxonomy=genre&type=ms-artists');
   ?>
<div class="ms_register_popup">
   <div id="myModal" class="modal  centered-modal" role="dialog">
      <div class="modal-dialog register_dialog">
         <!-- Modal content-->
         <div class="modal-content lightbox-block signup-lightbox">
            <button type="button" class="close" data-dismiss="modal">
            <i class="fa_icon form_close"></i>
            </button>
            <div class="modal-body">
               <div class="heading-holder">
                  <h2><?php echo esc_html__('Sign Up', 'miraculous'); ?></h2>
                  <div class="cell">
                     <p><?php echo esc_html__('Already have an account?', 'miraculous'); ?>  <a href="#myModal1" data-toggle="modal" class="ms_modal hideCurrentModel"><?php echo esc_html__('Login', 'miraculous'); ?></a></p>
                  </div>
               </div>
               <div class="switcher-box">
                  <div class="switcher-item">
                     <div class="item-holder">
                        <input type="radio" name="who-i-am" id="i-user" checked="checked" value="subscriber">
                        <label for="i-user"><span><?php echo esc_html__('I am an User', 'miraculous'); ?></span></label>
                     </div>
                  </div>
                  <div class="switcher-item">
                     <div class="item-holder">
                        <input type="radio" name="who-i-am" id="i-artist" value="artist">
                        <label for="i-artist"><span><?php echo esc_html__('I am an Artist', 'miraculous'); ?></span></label>
                     </div>
                  </div>
               </div>
               <div class="decor-heading">
                  <h3><?php echo esc_html__('PROFILE DETAILS', 'miraculous'); ?></h3>
               </div>
               
                <form id="user_form_register" method="post" class="signup-form">
                  <fieldset>
                     <div class="fields-holder">
                        <div class="field-item">
                           <label for="input-signup-first-name"><?php echo esc_html__('First Name', 'miraculous'); ?></label>
                           <input type="text" name="full_name" value="" id="full_name" class="required">
                          <span id="errorname" class="error-row"></span>
                        </div>
                        <div class="field-item">
                           <label for="input-signup-last-name"><?php echo esc_html__('Last Name', 'miraculous'); ?></label>
                           <input type="text" name="last_name" value="" id="last_name" class="required">
                          <span id="errorlname" class="error-row"></span>
                        </div>
                        <div class="field-item">
                           <label for="input-signup-user-name"><?php echo esc_html__('User Name', 'miraculous'); ?></label>
                           <input type="text" name="username" id="username1" value="" class="form-control required">
                           <span id="erroruser" class="error-row"></span>
                        </div>
                        <div class="field-item">
                           <label for="input-signup-email"><?php echo esc_html__('Email', 'miraculous'); ?></label>
                            <input type="text" name="useremail" value="" id="useremail" class="form-control required">
                            <span id="erroremail" class="error-row"></span>
                        </div>
                        <div class="field-item">
                           <label for="input-signup-pass"><?php echo esc_html__('Password', 'miraculous'); ?>   
                           <i class="fa fa-info-circle" title="Password must be have at least 6 characters with alphanumeric" aria-hidden="true"></i>
                           </label>
                           <input type="password" name="password" value="" id="password1" class="form-control required check-password">
                           <span id="result"></span>
                          <span id="errorpass" class="error-row"></span>
                        </div>
                        <div class="field-item">
                           <label for="input-signup-pass2"><?php echo esc_html__('Repeat Password', 'miraculous'); ?></label>
                           <input type="password" name="confirmpass" value="" id="confirmpass" class="form-control required">
                          <span id="errorcpass" class="error-row"></span>
                        </div>
                        <div class="form-group signup-genre">
                          <p class="usergenre">Genres</p>
                          <?php if(!empty($genres)){
                             foreach ($genres as $genre_key => $genre) {
                             ?>
                          <label class="checkbox-inline">
                          <input type="checkbox" name="user_genres[]" value="<?php echo $genre->slug;?>" id="user_genres_<?php echo $genre_key;?>" class="form-control user_genres"><?php echo $genre->name;?>
                          </label>
                          <?php
                             }
                             }
                             ?>
                       </div>
                     </div>
                     <div class="buttons-row">
                        <div class="btn-box">
                        <button class="hst_loader" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i><?php esc_html_e('Loading','miraculous'); ?></button>
                           <input type="submit" name="register_one" id="register_one1" class="button password-validate" value="Register">
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div id="myModal1" class="modal  centered-modal" role="dialog">
      <div class="modal-dialog login_dialog">
         <!-- Modal content-->
         <div class="modal-content lightbox-block login-lightbox">
            <button type="button" class="close" data-dismiss="modal">
            <i class="fa_icon form_close"></i>
            </button>
            <div class="modal-body">
               <!-- <div class=""> -->
               <div class="heading-holder">
                  <h2><?php esc_html_e('Log In','miraculous'); ?></h2>
                  <?php 
                    global $wp;
                    $current_url = home_url(add_query_arg(array(), $wp->request));
                  ?>
                  <div class="cell">
                     <p>or <a href="#myModal" data-toggle="modal" class="ms_modal1 hideCurrentModel"><?php esc_html_e('Sign Up','miraculous'); ?></a></p>
                  </div>
               </div>
               <div class="columns">
                  <div class="col">
                     <form id="child_form_login" class="login-form" method="post">
                        <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo $current_url; ?>" />
                        <fieldset>
                           <div class="field-item">
                              <label for="input-login-name"><?php esc_html_e('Username','miraculous'); ?></label>
                              <input type="text" placeholder="Enter Your Email or Username" id="lusername" >
                           </div>
                           <div class="field-item">
                              <label for="input-login-pas"><?php esc_html_e('Password','miraculous'); ?></label>
                              <input type="password" placeholder="Enter Password" id="lpassword" class="form-control">
                           </div>
                           <div class="field-item">
                              <label>
                              <input type="checkbox" name="rem_check" id="rem_check">
                              <span class="checkmark"></span>
                              <?php esc_html_e('Keep me signed in','miraculous'); ?>
                              </label>
                           </div>
                           <div class="buttons-row">
                              <div class="links-box">
                                 <a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a>
                              </div>
                              <div class="btn-box">
                                 <button class="hst_loader" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i><?php esc_html_e('Loading','miraculous'); ?></button>
                                 <!-- <input type="submit" value="Login" class="button"> -->
                                 <input type="submit" name="login_one" id="login_one1" class="button" value="Login">
                              </div>
                           </div>
                        </fieldset>
                     </form>
                  </div>
                  <div class="col">
                     <div class="other-login">
                        <span class="or">Or</span>
                        <a href="#" class="button fb">login with facebook</a>
                     </div>
                  </div>
               </div>
               <!-- </div> -->
            </div>
         </div>
      </div>
   </div>
   <!-- Message popup -->
    <div id="message-popup" class="modal  centered-modal" role="dialog">
      <div class="modal-dialog login_dialog">
         <!-- Modal content-->
         <div class="modal-content lightbox-block message-lightbox">
            <button type="button" class="close" data-dismiss="modal">
            <i class="fa_icon form_close"></i>
            </button>
            <div class="modal-body">
               <!-- <div class=""> -->
               <div class="heading-holder">
                  <h2><?php esc_html_e('Send Message','miraculous'); ?></h2>
                  
               </div>
               <div class="columns">
                   <form class="message-form" id="message-form" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="receiver" id="receiver" value="">
                      <fieldset>
                        <div class="field-item">
                          <label for="input-message-subject">Subject</label>
                          <input type="text" name="subject" id="subject">
                          <p class="error subject-error"></p>
                        </div>
                        <div class="field-item">
                          <label for="input-message">Message</label>
                          <textarea id="message" name="message" cols="40" rows="6"></textarea>
                          <p class="error message-error"></p>
                        </div>
                        <div class="buttons-row">
                          <div class="links-box">
                            <div class="attach-item">
                              <input type="file" name="message-file" class="file-size-2mb" id="message-file" data-jcf='{"buttonText": "", "placeholderText": "attach file"}'>
                              <i class="icon-upload"></i>
                              <p class="error file-size-error"></p>
                            </div>
                          </div>
                          <div class="btn-box">
                          <button class="hst_loader" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i><?php esc_html_e('Loading','miraculous'); ?></button>
                            <input type="submit" name="submit-message" id="submit-message" value="SEND Message" class="button">
                          </div>
                        </div>
                      </fieldset>
                    </form>
                </div>
               <!-- </div> -->
            </div>
         </div>
      </div>
   </div>


      <!-- Albums popup -->
    <div id="albums-popup" class="modal  centered-modal" role="dialog">
      <div class="modal-dialog login_dialog">
         <!-- Modal content-->
         <div class="modal-content lightbox-block signup-lightbox items-lightbox">
            <button type="button" class="close" data-dismiss="modal">
            <i class="fa_icon form_close"></i>
            </button>
            <div class="modal-body" id="albums-popup-content">
             
            </div>
         </div>
      </div>
   </div>

</div>
<!-- <div class="left-controls">
   <button type="button" class="prev-button">Previous</button>
   <button type="button" class="play-button">Play</button>
   <button type="button" class="next-button">Next</button>
   <button type="button" class="volume-button"><span class="icon-speaker"></span> Volume</button>
   <span class="volume-bar progress-bar">
    <span class="current-line" style="width:44.7%"></span>
    <span class="handler" style="left:44.7%"></span>
   </span>
   <dl class="track">
    <dt>Playing Track:</dt>
    <dd>U2 - This Moment</dd>
   </dl>
   </div>
   <div class="time-controls">
   <div class="controls-holder">
    <span class="time-current">00.00</span>
    <span class="time-bar progress-bar">
      <span class="current-line" style="width:16%"></span>
      <span class="handler" style="left:16%"></span>
    </span>
    <span class="time-total">00.00</span>
   </div>
   </div>
   <div class="right-controls">
   <button type="button" class="snuffle-button"><span class="icon-shuffle"></span> Snuffle</button>
   <button type="button" class="repeat-button"><span class="icon-repeat"></span> Repeat</button>
   <button type="button" class="wifi-button"><span class="icon-wifi"></span> Wi-fi</button>
   <button type="button" class="list-button"><span class="icon-list"></span> Play-list</button>
   </div> -->
<!-- </div> -->
<!-- </div> -->
</div>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script>window.jQuery || document.write('<script src="<?php echo get_stylesheet_directory_uri();?>/js/jquery-1.11.1.min.js"><\/script>')</script>
<script src="<?php echo get_stylesheet_directory_uri();?>/js/jquery.main.js"></script>
<script type="text/javascript">
   function readCookie(name) {
       var nameEQ = name + "=";
       var ca = document.cookie.split(';');
       for(var i=0;i < ca.length;i++) {
           var c = ca[i];
           while (c.charAt(0)==' ') c = c.substring(1,c.length);
           if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
       }
       return null;
   }
   
   var MJTCURRENTTIME = readCookie('MJTCURRENTTIME');
   
   console.log(MJTCURRENTTIME);
   
   
   
</script>
<?php wp_footer(); ?>
</body> 
</html>




