<?php

namespace SaberTTS\Admin;

class SettingsFieldApiKey extends \SaberCore\Fields\Types\Text {

  public function key() {

    return 'api_key';

  }

  public function labelText() {

    return 'API Key';

  }

}
