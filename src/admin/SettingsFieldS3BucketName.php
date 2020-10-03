<?php

namespace SaberTTS\Admin;

class SettingsFieldS3BucketName extends \SaberCore\Fields\Types\Text {

  public function key() {

    return 's3_bucket_name';

  }

  public function labelText() {

    return 'S3 Bucket Name';

  }

}
