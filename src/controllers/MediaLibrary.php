<?php

namespace SaberTTS\Controller;

class MediaLibrary {

  public $file;

  public function __construct( $file ) {
    $this->file = $file;
  }

  public function save() {

    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $tmp = download_url( $this->file );
    $files = array(
      'name' => basename( $this->file ),
      'tmp_name' => $tmp
    );
    $result = media_handle_sideload( $files );

  }

}
