<?php

namespace Polly;

class Polly {

  public $accessId;
  public $secretKey;
  public $credentials;

  public function __construct() {

    $this->accessId   = 'AKIAU4ANHID7VOOJKIBA';
    $this->secretKey  = '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';
    $this->credentials = new \Aws\Credentials\Credentials(
      $this->accessId,
      $this->secretKey
    );

  }

  public function synth() {

    $client = new \Aws\Polly\PollyClient([
      'version' => '2016-06-10',
      'credentials' => $this->credentials,
      'region' => 'us-east-1'
    ]);

    $result = $client->synthesizeSpeech(
      [
        'OutputFormat' => 'mp3',
        'Text' => "Hello how are you?",
        'TextType' => 'text',
        'VoiceId' => 'Amy'
      ]
    );

    $resultData = $result->get('AudioStream')->getContents();

    return $resultData;

  }

}

// new Polly();
