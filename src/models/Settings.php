<?php

namespace SaberTTS\Model;

class Settings {

  public $awsAccessId;
  public $awsSecretKey;
  public $s3BucketName;
  public $s3BucketRegion;

  public function __construct() {
    $this->load();
  }

  public function load() {

    $keys = [
      'aws_access_id'     => 'awsAccessId',
      'aws_secret_key'    => 'awsSecretKey',
      's3_bucket_name'    => 's3BucketName',
      's3_bucket_region'  => 's3BucketRegion'
    ];

    foreach( $keys as $key => $prop ) {
      $this->{$prop} = get_option( 'options_'.$key );
    }

  }

}
