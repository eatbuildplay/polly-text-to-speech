<?php

namespace Polly;

class Polly {

  public $accessId;
  public $secretKey;
  public $credentials;

  public function __construct() {

    $settings = new Model\Settings();
    $this->credentials = new \Aws\Credentials\Credentials(
      $settings->awsAccessId,
      $settings->awsSecretKey
    );

  }

  public function synth( $text ) {

    $client = new \Aws\Polly\PollyClient([
      'version' => '2016-06-10',
      'credentials' => $this->credentials,
      'region' => 'us-east-1'
    ]);

    $result = $client->synthesizeSpeech(
      [
        'OutputFormat' => 'mp3',
        'Text' => $text,
        'TextType' => 'text',
        'VoiceId' => 'Amy'
      ]
    );

    $resultData = $result->get('AudioStream')->getContents();

    return $resultData;

  }

}

// new Polly();
