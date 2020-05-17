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

  public function synth( $text, $voiceId ) {

    $client = new \Aws\Polly\PollyClient([
      'version' => '2016-06-10',
      'credentials' => $this->credentials,
      'region' => 'us-east-1'
    ]);

    $result = $client->synthesizeSpeech(
      [
        'Engine'        => 'standard',
        'OutputFormat'  => 'mp3',
        'TextType'      => 'text',
        'Text'          => $text,
        'VoiceId'       => $voiceId
      ]
    );

    $resultData = $result->get('AudioStream')->getContents();

    return $resultData;

  }

}
