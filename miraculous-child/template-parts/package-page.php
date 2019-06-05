<?php
   /**
    * Template Name: Package Page
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   get_header();
   
   $previous = "javascript:history.go(-1)";
   if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
   }

   global $wp_query;
   
   $heading = '';
   if(!empty($atts['manage_plan_heading'])):
   $heading = $atts['manage_plan_heading'];
   endif;
   $priceplan = '';
   if(!empty($atts['priceplan_switch'])):
    $priceplan = $atts['priceplan_switch'];
   endif;
   $miraculous_theme_data = '';
   if (function_exists('fw_get_db_settings_option')):  
    $miraculous_theme_data = fw_get_db_settings_option();     
   endif; 
   $currency = '';
   if(!empty($miraculous_theme_data['paypal_currency'])):
    $currency = $miraculous_theme_data['paypal_currency'];
   endif;
   
   $submit_url = plugins_url().'/miraculouscore/paypal/payments.php';
   
   $ms_args = array('post_type' => 'ms-plans',
                'numberposts' => -1,
                'order' => 'ASC'
                );
   $music_plans = new WP_Query( $ms_args );
   $current_user = wp_get_current_user();
   
   ?>
<main id="main">
   <div class="container">
      <div class="lightbox-block package-lightbox">
         <div class="heading-holder">
            <h2>Add Funds</h2>
            <div class="cell">
                <a href="<?php echo $previous;?>" id="back_page" class="button button-danger">Go Back</a>
             </div>
         </div>
         <div class="select-package">
            <div class="title-holder">
               <h3>Select Package</h3>
               <p>Proin gravida nibh vel velit auctor aliquet enean sollicitudin, lorem quis.</p>
            </div>
            <div class="msg_ajax_loader" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            <div class="package-items">
               <?php
                  if ( $music_plans->have_posts() ) :
                     while ( $music_plans->have_posts() ) : $music_plans->the_post();
                              $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );
                  ?>
               <div class="item packages-items" id="package-<?php echo get_the_id();?>">
                  <a class="item-holder" href="javascript:;">
                     <input type="radio" name="plans" value="<?php echo get_the_id()?>" class="package radio" onclick="checkUserWalletFunds('<?php echo get_the_id()?>');">
                     <h4><?php echo get_the_title();?></h4>
                     <p><?php printf( __('Monthly Downloads - %s Tracks', 'miraculous'), get_post_meta(get_the_id(), 'fw_option:plan_monthly_downloads', true) ); ?></p>
                     <p><?php printf( __('Plan Validity - %s Month', 'miraculous'), get_post_meta(get_the_id(), 'fw_option:plan_validity', true) ); ?></p>
                     <strong class="price">
                     <?php
                        if(function_exists('miraculous_currency_symbol')){
                                           echo miraculous_currency_symbol($currency);
                                       }
                        
                        echo get_post_meta(get_the_id(), 'fw_option:plan_price', true); 
                        ?>
                     </strong>
                  </a>
               </div>
               <?php endwhile;
                  else:
                  echo '<p class="no-found">No Plans Found.</p>';
                  endif;
                  ?>
               <?php 
                  if( !empty($current_user) && $current_user->ID ):
                          //if($priceplan =='on'):
                  ?>
               <div class="col-lg-12">
                  <div class="ms_package_overview">
                     <div class="ms_heading">
                        <h1><?php esc_html_e('Account Overview','miraculous'); ?></h1>
                     </div>
                     <?php   
                        global $wpdb;
                        $pmt_tbl = $wpdb->prefix . 'ms_payments'; 
                        $today = date('Y-m-d H:i:s');
                        $query = $wpdb->get_results( "SELECT * FROM `$pmt_tbl` WHERE user_id = $current_user->ID AND expiretime > '$today'" );
                        if($query): ?>
                     <div class="ms_acc_ovrview_list">
                        <?php $i=1; foreach($query as $row): ?>
                        <ul>
                           <?php 
                              $start = date_create($today);
                              $end = date_create($row->expiretime);
                              $days_between = date_diff($start, $end); ?>
                           <li><?php printf( __('Your Subscribed Plan <span>- %s</span>', 'miraculous'), get_the_title($row->itemid) ); ?></li>
                           <li><?php printf( __('Amount Paid <span>- &#36;%s</span>', 'miraculous'), $row->payment_amount ); ?></li>
                           <li><?php printf( __('Validity Expires In <span>- %s Days</span>', 'miraculous'), $days_between->format("%a") ); ?></li>
                           <li><?php printf( __('Downloads Remaining <span>- %s Tracks</span>'), $row->remains_upload ); ?></li>
                        </ul>
                        <?php if($i == 1){ ?>
                        <form class="paypal" action="<?php echo esc_url($submit_url); ?>" method="post">
                           <input type="hidden" name="cmd" value="_xclick" />
                           <input type="hidden" name="lc" value="UK" />
                           <input type="hidden" name="first_name" value="<?php echo esc_attr($current_user->user_firstname); ?>" />
                           <input type="hidden" name="last_name" value="<?php echo esc_attr($current_user->user_lastname); ?>" />
                           <input type="hidden" name="payer_email" value="<?php echo esc_attr($current_user->user_email); ?>" />
                           <input type="hidden" name="user_id" value="<?php echo esc_attr($current_user->ID); ?>" />
                           <input type="hidden" name="item_number" value="<?php echo esc_attr($row->itemid); ?>" / >
                           <input type="hidden" name="item_name" value="<?php echo the_title_attribute($row->itemid); ?>" / >
                           <input type="submit" name="submit" class="ms_btn" value="<?php esc_attr_e('renew now', 'miraculous'); ?>"/>
                        </form>
                        <?php } ?>
                        <?php endforeach; ?>
                     </div>
                     <?php else: ?>
                     <div>
                        <?php 
                           esc_html_e('You have not subscribed any plan yet.', 'miraculous'); ?>
                     </div>
                     <?php endif; ?>
                  </div>
               </div>
               <?php 
                  //endif;
                  endif; ?>
            </div>
         </div>
         <div class="pay-block">
            <h3>Pay with:</h3>
            <ul class="form-tabset">
               <li><a href="#tab-paypal"><span>Paypal</span></a></li>
               <li><a href="#tab-wallet"><span> My Wallet</span></a></li>
            </ul>
            <div class="tabs-holder">
               <div class="tab-item" id="tab-paypal">
               </div>
               <div class="tab-item" id="tab-wallet">
                  <?php $wallet_amount = woo_wallet()->wallet->get_wallet_balance( get_current_user_id() );?>
                  <div class="wallet-amount"> Wallet Amount : <?php echo $wallet_amount;?></div>
                  <div class="wallet-form">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
<?php get_footer();?>