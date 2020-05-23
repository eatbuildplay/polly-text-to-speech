<?php

namespace SaberTTS;

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

    // default engine and filter engine
    $engine = 'standard';
    $engine = apply_filters( 'polly_engine', $engine, $voiceId, $text );

    // default TextType and filter TextType
    $textType = 'text';
    $textType = apply_filters( 'polly_text_type', $textType, $voiceId, $text );

    // make options and do call to Polly
    $pollyOptions = [
      'Engine'        => $engine,
      'OutputFormat'  => 'mp3',
      'TextType'      => $textType,
      'Text'          => $text,
      'VoiceId'       => $voiceId
    ];
    $result = $client->synthesizeSpeech( $pollyOptions );
    $resultData = $result->get('AudioStream')->getContents();
    return $resultData;

  }

}
