<?php

namespace SaberTTS\Admin;

class FieldKey extends \SaberCore\Fields\Types\Text {

  public function key() {
    return 'field_access_id';
  }

  public function labelText() {
    return 'API Key';
  }

}
