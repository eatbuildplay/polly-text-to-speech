<?php

namespace Polly;

class FileStorage {

  public $awsCredentials;

  public function __construct() {

    $settings = new Model\Settings();
    $this->credentials = new \Aws\Credentials\Credentials(
      $settings->awsAccessId,
      $settings->awsSecretKey
    );

  }

  public function save( $pollyResponse ) {

    $settings = new Model\Settings();

    $filename = time().'-polly.mp3';
    $client_s3 = new \Aws\S3\S3Client([
      'version' => 'latest',
      'credentials' => $this->credentials,
      'region' => $settings->s3BucketRegion
    ]);

    $result_s3 = $client_s3->putObject([
      'Key'     => $filename,
      'ACL'     => 'public-read',
      'Body'    => $pollyResponse,
      'Bucket'  => $settings->s3BucketName,
      'ContentType' => 'audio/mpeg'
    ]);

    return $result_s3;

  }

}
