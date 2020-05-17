<?php

namespace Polly\Controller;

class LocalStorage {

  public $dir = 'polly';

  public function save( $fileContents ) {

    // make dir if not exists
    if( !$this->dirExists() ) {
      $this->makeDir();
    }

    // save file
    $uploadDir = $this->getUploadDir();
    $file = $uploadDir . '/test123.mp3';
    file_put_contents($file, $fileContents);

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
