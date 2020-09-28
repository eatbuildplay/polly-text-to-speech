<?php

namespace SaberTTS\Admin;

class FieldAccessId extends \SaberCore\Fields\Types\Text {

  public function key() {
    return 'field_access_id';
  }

  public function labelText() {
    return 'API Access ID';
  }

}
