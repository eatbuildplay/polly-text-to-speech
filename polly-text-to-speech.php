<?php

/**
 *
 * Plugin Name: Polly Text-to-Speech
 * Plugin URI: https://eatbuildplay.com/plugins/polly-text-to-speech/
 * Description: Provides integration of AWS Polly text-to-speech service.
 * Version: 1.0.0
 * Author: Casey Milne, Eat/Build/Play
 * Author URI: https://eatbuildplay.com/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace Polly;

define( 'POLLY_TTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'POLLY_TTS_URL', plugin_dir_url( __FILE__ ) );
define( 'POLLY_TTS_VERSION', '1.0.0' );

class Plugin {

  public function __construct() {

    require_once(POLLY_TTS_PATH.'vendor/aws/aws-autoloader.php');
    require_once(POLLY_TTS_PATH.'src/Polly.php');
    require_once(POLLY_TTS_PATH.'src/FileStorage.php');

    require_once(POLLY_TTS_PATH.'src/Template.php');
    require_once(POLLY_TTS_PATH.'src/Shortcode.php');

    require_once(POLLY_TTS_PATH.'src/PostType.php');
    require_once(POLLY_TTS_PATH.'src/TextConversionPostType.php');

    require_once(POLLY_TTS_PATH.'src/models/TextConversion.php');

    require_once(POLLY_TTS_PATH.'src/SpeechShortcode.php');


    new ShortcodeSpeech();

    /*

      // make and save an MP3 file

      $polly = new Polly();
      $pollyResponse = $polly->synth();

      $fs = new FileStorage;
      $fs->save( $pollyResponse );

    */

    // post type init
    add_action('init', [$this, 'cptRegister']);

    add_action('init', [$this, 'optionsPages'], 20);

    add_action('acf/save_post', [$this, 'optionSave'], 20);
    add_action('admin_notices', [$this, 'adminNotices']);

  }

  public function cptRegister() {
    $pt = new TextConversionPostType();
    $pt->register();
  }

  public function adminNotices() {

    $url = get_option('polly_notice', false);

    if( !$url ) {
      return;
    }

    $messageText = '<figure>
      <figcaption>Listen to the T-Rex:</figcaption>
      <audio
        controls
        src="' . $url . '">
            Your browser does not support the
            <code>audio</code> element.
      </audio>
    </figure>';

    $class = 'notice notice-success';
    $message = __( $messageText, 'polly' );
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
    delete_option('polly_notice');

  }

  public function optionSave() {

    $screen = get_current_screen();
    if (strpos($screen->id, "acf-options-convert-text") != true) {
      return;
    }

    $text = get_option('options_text');

    $polly = new Polly();
    $pollyResponse = $polly->synth( $text );

    $fs = new FileStorage;
    $save = $fs->save( $pollyResponse );

    if( $save ) {
      //$notice = '<pre>' . print_r($save,1) . '</pre>';
      $notice = $save['ObjectURL'];

      // save text_conversion post
      $tc = new Model\TextConversion;
      $tc->s3url = $save['ObjectURL'];
      $tc->save();

    }

    update_option('polly_notice', $notice);

  }

  public function optionsPages() {

    if( function_exists('\acf_add_options_page') ) {

      // main dashboard
      \acf_add_options_page(array(
    		'page_title' 	=> 'Polly TTS',
    		'menu_title'	=> 'Polly TTS',
    		'menu_slug' 	=> 'polly',
    		'capability'	=> 'edit_posts',
    		'redirect'		=> false
    	));

      // convert text
      \acf_add_options_sub_page(array(
    		'page_title' 	=> 'Convert Text',
    		'menu_title'	=> 'Convert Text',
    		'parent_slug'	=> 'polly',
    	));


      \acf_add_options_sub_page(array(
    		'page_title' 	=> 'AWS Credentials',
    		'menu_title'	=> 'AWS Credentials',
    		'parent_slug'	=> 'polly',
    	));

    }

  }

}

new Plugin();
