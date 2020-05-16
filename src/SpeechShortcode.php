<?php

namespace Polly;

class ShortcodeSpeech extends Shortcode {

  public $tag = 'polly-speech';

  public function __construct() {
    $this->templateName = 'speech';
    $this->templateData = [
      'url' => 'https://s10audio.s3.us-east-2.amazonaws.com/1589641833-polly.mp3'
    ];
    parent::__construct();
  }

}
