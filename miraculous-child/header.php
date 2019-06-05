<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Miraculous
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php  wp_head();?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/css/all.css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">

    <script>(function(d, s, id) { 
        var js, fjs = d.getElementsByTagName(s)[0]; 
        if (d.getElementById(id)) return; 
        js = d.createElement(s); js.id = id; 
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=606793336427677'; 
        fjs.parentNode.insertBefore(js, fjs); 
        }(document, 'script', 'facebook-jssdk'));
     </script>
         
</head> 
<body <?php body_class(); ?>>
<?php 
//$miraculous_setting = '';
// if(class_exists('Miraculous_setting')):
//    if(function_exists('miraculous_multi_color')):
//     miraculous_multi_color();
//    endif;
//    $miraculous_setting = new Miraculous_setting();
//    $miraculous_setting->miraculous_header_setting();
//    $miraculous_setting->miraculous_breadcrumbs_setting();
// endif; 
$miraculouscore = '';
if(class_exists('Miraculouscore')):
 $miraculouscore = new Miraculouscore();
 $miraculouscore->miraculous_theme_loader();
endif;



?>  

<div id="wrapper">
    <header id="header">
      <div class="top-panel">
        <div class="logo">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo get_stylesheet_directory_uri();?>/images/logo.png" alt="Coregospel music" width="197" height="47">
          </a>
        </div>
        <div class="nav-holder">
          <a href="#" class="nav-opener">Open navigation</a>
          <nav id="nav">
            
            <?php  wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'false', 'menu_id' => '', 'menu_class'  => '' ) );  ?>
           
          </nav>
          <?php 
            if(is_user_logged_in()):

              global $current_user; wp_get_current_user(); 
          ?>
          <div class="user-box">
            <a href="#" class="name-box">
          <?php
            $user = wp_get_current_user();

              
              $user_profile_img = get_user_meta($user->ID, 'user_profile_img', true);
              //die();
              $user_avatar = get_avatar_url( $user->ID );

              if($user_profile_img!=''){
                  $profile_img = $user_profile_img;
              }else{
                  $profile_img = $user_avatar;
              }

              if ( $user ) :
            ?>
              <img src="<?php echo esc_url($profile_img); ?>" alt="photo" width="29" height="29">
          <?php endif; ?>
              
              <strong class="name"><?php echo $current_user->user_login;?></strong>
            </a>
            <div class="drop">
              <?php  wp_nav_menu( array('menu' => 'user-menu','theme_location' => '', 'container' => 'false', 'menu_id' => '', 'menu_class'  => '' ) );  ?>
            </div>
          </div>
        <?php else:?>
          <div class="login-register">
            <a href="javascript:;" class="name-box" data-toggle="modal" data-target="#myModal1">
              <strong class="name">Login</strong>
            </a>
            <strong class="name"> / </strong>
            <a href="javascript:;" class="name-box" data-toggle="modal" data-target="#myModal">
              <strong class="name">Register</strong>
            </a>
            
          </div>
        <?php endif;?>
        </div>
      </div>
      <div class="sub-panel">
      <?php if(!is_page('browse')){?>
        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" method="get" class="search-form">
          <fieldset>
            <input type="search"  value="<?php echo get_search_query(); ?>" name="s" placeholder="Search Here">

            <button type="submit"><i class="icon-magnify"></i> Search</button>
          </fieldset>
        </form>
        <?php } ?>
        <nav class="sub-nav">
          <button type="button" class="btn-prev">Previous</button>
          <button type="button" class="btn-next">Next</button>
          <div class="mask">
            <?php  wp_nav_menu( array('menu' => 'header-manu','theme_location' => '', 'container' => 'false', 'menu_id' => '', 'menu_class'  => '' ) );  ?>
          </div>
        </nav>
      </div>
    </header>
    <?php global $template; $template_file = basename($template);?> 
<script type="text/javascript">
  console.log('<?php echo $template_file;?>');
</script>