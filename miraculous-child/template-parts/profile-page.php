

<?php
   /**
    * Template Name: Profile Page
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


   $page = isset($wp_query->query_vars['tab']) ? $wp_query->query_vars['tab'] : '';
   
  $user_id = get_current_user_id(); 
  $user_meta=get_userdata($user_id);
  $user_roles =$user_meta->roles;


   ?>
    <main id="main">
      <div class="container">
        <div class="section-header page-header">
          <h1>My Account</h1>
        </div>
        <div class="content-tabs">
          <ul class="side-tab">
            <li <?php if($page == ''){?> class="active" <?php } ?> >
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>">
                <i class="icon-user"></i> <strong>My Profile</strong>
              </a>
            </li>
            <li <?php if($page == 'playlist'){?> class="active" <?php } ?>>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>/playlist">
                <i class="icon-list"></i> <strong>My Playlist</strong>
              </a>
            </li>
            <li <?php if($page == 'friends'){?> class="active" <?php } ?>>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>/friends">
                <i class="icon-list"></i> <strong>My Friends</strong>
              </a>
            </li>
            <li <?php if($page == 'pictures'){?> class="active" <?php } ?>>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>pictures">
                <i class="fa fa-user-circle-o"></i> <strong>My Pictures</strong>
              </a>
            </li>
            <li <?php if($page == 'favorites'){?> class="active" <?php } ?>>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>favorites">
                <i class="icon-star-2"></i> <strong>My Favorites</strong>
              </a>
            </li>
            <li <?php if($page == 'downloads'){?> class="active" <?php } ?>>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>downloads">
                <i class="icon-upload"></i> <strong>My Downloads</strong>
              </a>
            </li>
          <?php if(!empty($user_roles) && in_array('artist', $user_roles)){?>
            <li <?php if($page == 'albums' || $page == 'add-albums'){?> class="active" <?php } ?>>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>albums">
                <i class="icon-play"></i> <strong>My Albums</strong>
              </a>
            </li>
          <?php } ?>
            <!-- <li <?php //if($page == 'lessons'){?> class="active" <?php //} ?>>
              <a href="<?php //echo esc_url(get_permalink(get_page_by_path('profile'))); ?>lessons">
                <i class="icon-lesson"></i> <strong>My Lessons</strong>
              </a>
            </li> -->
          </ul>

          <div class="tab-content">

            <?php

              switch ($page) {
                case 'playlist':
                  get_template_part( 'template-parts/user/user', 'playlist' );
                  break;

                  case 'friends':
                  get_template_part( 'template-parts/user/user', 'friends' );
                  break;

                   case 'pictures':
                  get_template_part( 'template-parts/user/user', 'pictures' );
                  break;


                  case 'favorites':
                  get_template_part( 'template-parts/user/user', 'favorites' );
                  break;

                  case 'downloads':
                  get_template_part( 'template-parts/user/user', 'downloads' );
                  break;

                  case 'albums':
                  get_template_part( 'template-parts/user/user', 'albums' );
                  break;

                  case 'add-albums':
                  get_template_part( 'template-parts/user/user', 'add-albums' );
                  break;
                
                default:
                  get_template_part( 'template-parts/user/user', 'profile' );
                  break;
              }
            ?>
            
          </div>
        </div>
      </div>
    </main>
<?php get_footer();?>

