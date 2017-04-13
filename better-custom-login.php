<?php

/**
 * Plugin Name: Better Custom Login
 * Plugin URI: https://github.com/avclark/better-custom-login
 * Description: Custom login screen for 10up.
 * Version: 1.0.0
 * Author: Adam Clark
 * Author URI: http://avclark.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: better-custom-login
 *
 * @link http://avclark.com
 * @since 1.0.0
 * @package Better_Custom_Login
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Load plugin stylesheet.
function bcl_load_styles() {
  wp_enqueue_style( 'bcl-styles', plugins_url( 'assets/css/bcl-styles.css', __FILE__ ) );
}
add_action('login_head', 'bcl_load_styles');

// Replace login page logo.
function bcl_login_logo_url() {
  return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'bcl_login_logo_url' );

// Update logo URL title.
function bcl_login_logo_url_title() {
  return '10up | finely crafted websites and tools';
}
add_filter( 'login_headertitle', 'bcl_login_logo_url_title' );

// Create a custom login message.
function bcl_message() {

  // Check if array indicies are set so we can display different messages for different pages.
  $action = array_key_exists('action', $_REQUEST) ? $_REQUEST['action'] : null;
  $loggedout = array_key_exists('loggedout', $_REQUEST) ? $_REQUEST['loggedout'] : null;

  // Message for new password page.
  if ( $action == 'lostpassword' ) {
    $message = '<p class="message">Please enter your username or email address. You will receive a link to create a new password via email.</p>';
    return $message;

    // Message for logged out page.
  } elseif ( $loggedout == true ) {
    $message = '';
    return $message;

    // Message for main login page.
  } else {

    // Display current day in welcome message.
    $current_day = date('l');
    $message = '<p class="welcome-message"><strong>Happy '. $current_day .'</strong>. Please Login.</p>';
    return $message;
  }
}
add_filter('login_message', 'bcl_message');

// Make 'remember me' checkbox checked by default.
function bcl_remember_me() {
  add_filter( 'login_footer', 'bcl_remember_me_checked' );
}
add_action( 'init', 'bcl_remember_me' );

// Insert some old-fasioned JS to check if the 'rememberme' element exists and, if so, make it checked by default.
function bcl_remember_me_checked() {
  echo 
    "<script>
      var rememberMe = document.getElementById('rememberme');
      if (typeof(rememberMe) != 'undefined' && rememberMe != null) {
        rememberMe.checked = true;
      }
    </script>";
}
