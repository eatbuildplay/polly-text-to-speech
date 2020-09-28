<?php

/**
 *
 * Plugin Name: Saber TTS
 * Plugin URI: https://eatbuildplay.com/plugins/saber-tts/
 * Description: Provides text-to-speech services with integration of AWS Polly text-to-speech service.
 * Version: 1.1.2
 * Author: Casey Milne, Eat/Build/Play
 * Author URI: https://eatbuildplay.com/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace SaberTTS;

define( 'SABER_TTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SABER_TTS_URL', plugin_dir_url( __FILE__ ) );
define( 'SABER_TTS_VERSION', '1.1.1' );

class Plugin {

  public function __construct() {

    /*
     * Init autoloading
     */
    spl_autoload_register([$this, 'autoload']);

    require_once(SABER_TTS_PATH.'vendor/aws/aws-autoloader.php');

    // move to autoloader
    require_once(SABER_TTS_PATH.'src/Polly.php');
    require_once(SABER_TTS_PATH.'src/Template.php');
    require_once(SABER_TTS_PATH.'src/Shortcode.php');
    require_once(SABER_TTS_PATH.'src/PostType.php');
    require_once(SABER_TTS_PATH.'src/TextConversionPostType.php');
    require_once(SABER_TTS_PATH.'src/models/Settings.php');
    require_once(SABER_TTS_PATH.'src/models/TextConversion.php');
    require_once(SABER_TTS_PATH.'src/SpeechShortcode.php');
    require_once(SABER_TTS_PATH.'src/controllers/S3Storage.php');
    require_once(SABER_TTS_PATH.'src/controllers/LocalStorage.php');
    require_once(SABER_TTS_PATH.'src/controllers/MediaLibrary.php');

    new ShortcodeSpeech();

    // post type init
    add_action('init', [$this, 'loadFields']);
    add_action('init', [$this, 'cptRegister']);
    add_action('init', [$this, 'optionsPages'], 20);

    add_action('acf/save_post', [$this, 'optionSave'], 20);
    add_action('admin_notices', [$this, 'adminNotices']);

    // admin form processing
    require_once( SABER_TTS_PATH . 'vendor/saber-core/loader.php');
    add_action('admin_post_saber_form', ['\SaberCore\Fields\FieldGroup', 'process']);

    // setup admin menu
    add_action('admin_menu', function() {

      add_settings_section(
        'general_settings_section',         // ID used to identify this section and with which to register options
        'Sandbox Options',                  // Title to be displayed on the administration page
        ['\SaberTTS\Admin\FieldGroupSettings', 'renderSettings'], // Callback used to render the description of the section
        'general'                           // Page on which to add this section of options
      );

      add_settings_field(
        'show_header',                      // ID used to identify the field throughout the theme
        'Header',                           // The label to the left of the option interface element
        ['\SaberTTS\Admin\FieldGroupSettings', 'renderField1'],   // The name of the function responsible for rendering the option interface
        'general',                          // The page on which this option will be displayed
        'general_settings_section',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
          'Activate this setting to display the header.'
        )
      );

      register_setting(
        'general',
        'show_header'
      );

      // init dashboard page
      $dashboard = new \SaberTTS\Admin\Dashboard();
      $dashboard->create();

      // init settings page
      $settings = new \SaberTTS\Admin\Settings();
      $settings->create();

    });

  }

  public function autoload( $className ) {

    if ( 0 !== strpos( $className, 'SaberTTS\Admin' ) ) {
      return;
    }

		// strip the namespace leaving only the final class name
		$className = str_replace('SaberTTS\Admin\\', '', $className);
		require( SABER_TTS_PATH . 'src/admin/' . $className . '.php' );

  }

  public function loadFields() {

    $voiceList = [
      'Joanna' => 'Joanna (English US / Female)',
      'Kendra' => 'Kendra (English US / Female)',
      'Kimberly' => 'Kimberly (English US / Female)',
      'Salli' => 'Salli (English US / Female)',
      'Joey' => 'Joey (English US / Male)',
      'Matthew' => 'Matthew (English US / Male)',
    ];
    $voiceList = apply_filters('saber_voice_list', $voiceList);

    require_once(SABER_TTS_PATH.'fields/convert_text.php');
    require_once(SABER_TTS_PATH.'fields/text_conversion.php');
    require_once(SABER_TTS_PATH.'fields/settings.php');

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
      <figcaption>Listen:</figcaption>
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

    if( !function_exists('\get_current_screen') ) {
      return;
    }
    $screen = \get_current_screen();

    if (strpos($screen->id, "acf-options-convert-text") != true) {
      return;
    }

    $text = get_option('options_text');
    $voiceId = get_option('options_voice_id');

    $polly = new Polly();
    $pollyResponse = $polly->synth( $text, $voiceId );

    $fileStorageSetting = get_option('options_file_storage');

    // s3 file storage
    if( $fileStorageSetting == 's3') {
      $fs = new Controller\S3Storage;
      $fileUrl = $fs->save( $pollyResponse );
    }

    // local server storage
    if( $fileStorageSetting == 'server') {
      $ls = new Controller\LocalStorage;
      $fileUrl = $ls->save( $pollyResponse );
    }

    if( $fileUrl ) {

      // media library attach
      $mediaLibraryImportSetting = get_option('options_media_library_import');

      if( $mediaLibraryImportSetting == 1 ) {
        $ml = new Controller\MediaLibrary( $fileUrl );
        $ml->save();
      }

      // save text_conversion post
      $tc = new Model\TextConversion;
      $tc->url = $fileUrl;
      $tc->save();

      // setup for showing notice to user
      $notice = $fileUrl;
      update_option('polly_notice', $notice);

    }

  }

  public function optionsPages() {

    if( function_exists('\acf_add_options_page') ) {

      // main dashboard
      \acf_add_options_page(array(
    		'page_title' 	=> 'Saber TTS',
    		'menu_title'	=> 'Saber TTS',
    		'menu_slug' 	=> 'saber',
        'position'    => 4,
        'icon_url'    => 'dashicons-format-chat',
    		'capability'	=> 'edit_posts',
    		'redirect'		=> false
    	));

      // convert text
      \acf_add_options_sub_page(array(
    		'page_title' 	=> 'Convert Text',
    		'menu_title'	=> 'Convert Text',
        'update_button' => __('Convert Text', 'polly'),
        'updated_message' => __('Text Converted Successfully', 'polly'),
    		'parent_slug'	=> 'saber',
    	));

      // text conversions
      \add_submenu_page(
        'saber',
        'Text Conversions',
        'Text Conversions',
        'edit_posts',
        'edit.php?post_type=text_conversion'
      );

      \acf_add_options_sub_page(array(
    		'page_title' 	=> 'Settings',
    		'menu_title'	=> 'Settings',
    		'parent_slug'	=> 'saber',
    	));

    }

  }

}

new Plugin();
