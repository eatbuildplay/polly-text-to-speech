<?php

namespace Polly;

class FileStorage {

  public function __construct() {

    $this->accessId   = 'AKIAU4ANHID7VOOJKIBA';
    $this->secretKey  = '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';
    $this->credentials = new \Aws\Credentials\Credentials(
      $this->accessId,
      $this->secretKey
    );

  }

  public function save( $pollyResponse ) {

    $s3bucket = 's10audio';
    $s3region = 'us-east-2';

    $filename = time().'-polly.mp3';
    $client_s3 = new \Aws\S3\S3Client([
      'version' => 'latest',
      'credentials' => $this->credentials,
      'region' => $s3region
    ]);

    $result_s3 = $client_s3->putObject([
      'Key'     => $filename,
      'ACL'     => 'public-read',
      'Body'    => $pollyResponse,
      'Bucket'  => $s3bucket,
      'ContentType' => 'audio/mpeg'
    ]);

    return $result_s3;

  }

}
