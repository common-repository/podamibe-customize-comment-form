<?php
/**
 * Plugin Name: Podamibe Customize Comment Form
 * Plugin URI: http://podamibenepal.com/
 * Description: Add custom basic fields to wordpress comment form.
 * Version: 1.0.1
 * Author: Podamibe Nepal
 * Author URI: https://profiles.wordpress.org/podamibe
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @author Podamibenepal
 * @copyright Copyright (c) 2017, Podamibenepal
 **/

/* ------------------- Do not access this file directly ----------------------- */

if ( ! defined( 'ABSPATH' ) ) 
	exit;


/* ------------------- Constants ----------------------- */

  !defined('PCCF_VERSION')     ? define( 'PCCF_VERSION', '1.0.0' )                          	  : null;
  !defined('PCCF_TEXT_DOMAIN') ? define( 'PCCF_TEXT_DOMAIN', 'podamibe-customize-comment-form' )  : null;
  !defined('PCCF_PATH')        ? define( 'PCCF_PATH', plugin_dir_path( __FILE__ ) .'inc/' ) 	  : null;
  !defined('PCCF_URI')         ? define( 'PCCF_URI', plugin_dir_url( __FILE__ ) )           	  : null;


/* ------------------------ Includes ------------------ */

require_once( PCCF_PATH . 'functions.php' );

