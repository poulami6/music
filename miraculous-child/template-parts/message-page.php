

<?php
   /**
    * Template Name: Message Page
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   get_header();
   
if(!is_user_logged_in()){
?>
<script language="javascript" type="text/javascript">
var url = '<?php echo home_url();?>';
document.location = url;
</script>
<?php
exit();
}
   global $wp_query;

  $user_id = get_current_user_id(); 

$message_data = new Message();
$threads = $message_data->_get_threads_of_user();

  
?>
    <main id="main">
      <div class="container">
        <div class="section-header page-header">
          <h1>Messages</h1>
        </div>
        <div class="messages-area">
          <div class="messages-sidebar">
            <div class="messages-sort-block jcf-scrollable">
              <div class="sort-links">
                <strong class="ttl">Sort by:</strong>
                <ul>
                  <li class="active"><a href="javascript:;">Date</a></li>
                  <li><a href="javascript:;">Name</a></li>
                  <!-- <li><a href="#">Trash</a></li> -->
                </ul>
              </div>
              <?php if(!empty($threads)){?>
              <ul class="messages-sort-list">
              <?php
                  
                  foreach ($threads as $user_key => $message) {

                    if(is_user_logged_in() && $user_id == $message->sender_id){
                        $msg_userid = $message->receiver_id;
                    }else{
                        $msg_userid = $message->sender_id;
                    }

                    $user_info = get_userdata($msg_userid);

                    $unread_message = $message_data->_get_count_unread_message($user_id);
              ?>
                <li id="user-threads-<?php echo $user_key;?>" data-id="<?php echo $user_key;?>" class="user-threads" onclick="get_user_message('<?php echo $message->sender_id;?>','<?php echo $message->receiver_id;?>','<?php echo "user-threads-".$user_key;?>');">
                  <div class="title-holder">
                    <strong class="name"><?php echo $user_info->first_name .' '.$user_info->last_name; ?></strong>
                    <div class="cell">
                      <!-- <a href="javascript:;" class="delete" >DELETE</a> -->
                      <span class="number"><a href="#"><?php echo (count($unread_message) > 0) ? count($unread_message).' msg' : " " ?></a> </span>
                    </div>
                  </div>
                  <div class="text-holder">
                    <p><?php  echo $message->subject;?></p>
                  </div>
                </li>
              <?php } ?>
              </ul>
              <?php } ?>
            </div>
          </div>
          <div class="messages-content">

            <div class="content-block">
            <div class="msg_ajax_loader" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i>Loading</div>
              <div class="messages-list" id="get-message">
              <?php
                  $current_user_info = get_userdata($user_id);
                  $current_user_name = $current_user_info->first_name .' '.$current_user_info->last_name;
                  $current_user_profile_img = get_user_meta($user_id, 'user_profile_img', true);
                 
                  $current_user_avatar = get_avatar_url($user_id);

                  if($current_user_profile_img!=''){
                      $profile_img = $current_user_profile_img;
                  }else{
                      $profile_img = $current_user_avatar;
                  }
              ?>
                <div class="messages-block" id="message-loding">
                  <img src="<?php echo $profile_img; ?>" alt="">
                   <h2> Welcome <?php echo $current_user_name;?></h2>

                </div>
                
              </div>
              
            </div>

          </div>
        </div>
      </div>
    </main>
<?php get_footer();?>

