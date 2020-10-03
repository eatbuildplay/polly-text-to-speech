<?php

namespace SaberTTS\Admin;

class SettingsFieldS3BucketRegion extends \SaberCore\Fields\Types\Text {

  public function key() {

    return 's3_bucket_region';

  }

  public function labelText() {

    return 'S3 Bucket Region';

  }

}
