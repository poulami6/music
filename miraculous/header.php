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
    <?php wp_head();?>
</head> 
<body <?php body_class(); ?>>
<?php 
$miraculous_setting = '';
if(class_exists('Miraculous_setting')):
   if(function_exists('miraculous_multi_color')):
	  miraculous_multi_color();
   endif;
   $miraculous_setting = new Miraculous_setting();
   $miraculous_setting->miraculous_header_setting();
   $miraculous_setting->miraculous_breadcrumbs_setting();
endif; 
$miraculouscore = '';
if(class_exists('Miraculouscore')):
 $miraculouscore = new Miraculouscore();
 $miraculouscore->miraculous_theme_loader();
endif;
?> 
<?php global $template; $template_file = basename($template);?> 
<script type="text/javascript">
  console.log('<?php echo $template_file;?>');
</script> 