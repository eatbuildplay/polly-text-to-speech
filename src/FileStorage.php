<?php

namespace Polly;

class FileStorage {

  public function save() {

    $s3bucket = 'bucketname';
    $s3region = 'yourbucketregion'

    $filename = time().'-polly.mp3';
    $client_s3 = new Aws\S3\S3Client([
      'version' => 'latest',
      'credentials' => $credentials,
      'region' => $s3region ]
    );

  }

}
