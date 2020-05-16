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

    $polly = new Polly();
    $pollyResponse = $polly->synth();

    $fs = new FileStorage;
    $fs->save( $pollyResponse );
    
  }

}

new Plugin();
