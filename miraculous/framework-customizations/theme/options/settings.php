<?php if (!defined('FW')) die('Forbidden');

$options = array(
    fw()->theme->get_options( 'customizer/miraculous-general-settings'),
    fw()->theme->get_options( 'customizer/miraculous-header-settings'),
    fw()->theme->get_options( 'customizer/miraculous-breadcrumbs-setting'),
	fw()->theme->get_options( 'customizer/miraculous-login-register-setting'),
    fw()->theme->get_options( 'customizer/miraculous-sidebar-setting'),
    fw()->theme->get_options( 'customizer/miraculous-layout-setting'),
    fw()->theme->get_options( 'customizer/miraculous-404-settings'),
    fw()->theme->get_options( 'customizer/miraculous-page-setting'),
    fw()->theme->get_options( 'customizer/miraculous-footer-settings'),
    fw()->theme->get_options( 'customizer/miraculous-api-setting'),
   ); 