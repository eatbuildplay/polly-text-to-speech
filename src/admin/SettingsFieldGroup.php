<?php

namespace SaberTTS\Admin;

class SettingsFieldGroup extends \SaberCore\Fields\FieldGroup {

  public function fields() {

    return [
      new SettingsFieldApiKey(),
      new SettingsFieldApiKey(),
      new SettingsFieldS3BucketName(),
      new SettingsFieldS3BucketRegion(),
    ];

  }

}
