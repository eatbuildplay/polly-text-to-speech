<?php

namespace SaberTTS\Admin;

class FieldGroupSettings extends \SaberCore\Fields\FieldGroup {

  public function fields() {

    return [
      new FieldAccessId(),
      new FieldKey()
    ];

  }

  public static function renderField1() {

    $field = new FieldAccessId();
    $field->render();

  }

}
