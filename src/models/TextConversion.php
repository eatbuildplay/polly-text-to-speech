<?php

namespace Polly\Model;

class TextConversion {

  public $id;
  public $title;
  public $s3url;

  public function save() {

    $args = [
      'post_type'  => 'text_conversion',
      'post_title' => time()
    ];
    $postId = wp_insert_post($args);
    update_post_meta( $postId, 's3_url', $this->s3url );

  }

}
