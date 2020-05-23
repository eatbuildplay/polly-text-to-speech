<?php

namespace SaberTTS;

class ShortcodeSpeech extends Shortcode {

  public $tag = 'saber-speech';

  public function __construct() {
    $this->templateName = 'speech';
    parent::__construct();
  }

  public function loadData( $atts ) {

    $id = $atts['id'];
    $post = get_post( $id );
    $url = get_field('s3_url', $id);

    return [
      'label' => $post->post_title,
      'url' => $url
    ];
  }

}
