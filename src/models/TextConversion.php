<?php

namespace SaberTTS\Model;

class TextConversion {

  public $id;
  public $title;
  public $url;

  public function save() {

    $args = [
      'post_type'  => 'text_conversion',
      'post_title' => time(),
      'post_status' => 'publish'
    ];
    $postId = \wp_insert_post($args);
    \update_post_meta( $postId, 'url', $this->url );

  }

}
