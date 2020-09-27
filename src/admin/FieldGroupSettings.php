<?php

namespace SaberTTS\Admin;

class FieldGroupSettings extends \SaberCore\Fields\FieldGroup {

  public function fields() {

    return [
      new FieldAccessId()
    ];

  }

}
