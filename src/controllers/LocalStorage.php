<?php

namespace SaberTTS\Controller;

class LocalStorage {

  public $dir = 'saber';

  public function save( $fileContents ) {

    // make dir if not exists
    if( !$this->dirExists() ) {
      $this->makeDir();
    }

    // save file
    $uploadDir = $this->getUploadDir() . '/';
    $filename = time() . '-polly.mp3';
    $file = $uploadDir . $filename;
    file_put_contents($file, $fileContents);

    $fileUrl = WP_CONTENT_URL . '/uploads/polly/' . $filename;

    return $fileUrl;

  }

  public function getUploadDir() {
    $upload = wp_upload_dir();
    $uploadDir = $upload['basedir'] . '/' . $this->dir;
    return $uploadDir;
  }

  public function dirExists() {

    $uploadDir = $this->getUploadDir();

    if( is_dir($uploadDir) ) {
      return true;
    }
    return false;

  }

  public function makeDir() {

    $uploadDir = $this->getUploadDir();
    $permissions = 0755;
    $oldmask = umask(0);
    if (!is_dir($uploadDir)) mkdir($uploadDir, $permissions);
    $umask = umask($oldmask);
    $chmod = chmod($uploadDir, $permissions);

  }

}
