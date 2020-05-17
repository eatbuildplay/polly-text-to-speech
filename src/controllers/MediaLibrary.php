<?php

namespace Polly\Controller;

class MediaLibrary {

  public $file;

  public function __construct( $file ) {
    $this->file = $file;
  }

  public function save() {

    $wpFiletype = wp_check_filetype($this->file, null );
    $attachment = array(
  		'post_mime_type' => $wpFiletype['type'],
  		'post_title' => 'Polly Speech MP3',
  	);
    $attachmentId = wp_insert_attachment( $attachment, $this->file );
    if (!is_wp_error($attachmentId)) {
  		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  		$attachmentData = wp_generate_attachment_metadata( $attachmentId, $this->file );
  		wp_update_attachment_metadata( $attachmentId,  $attachmentData );
  	}

  }

}
