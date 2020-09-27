<?php

namespace SaberTTS\Admin;

class Settings extends \SaberCore\Settings\SettingsPage {

  public function parentSlug() {
    return 'test-123';
  }

  public function pageTitle() {
    return 'Settings';
  }

  public function callback() {

    $fgs = new FieldGroupSettings();
    $fgs->render();

  }

}
