<?php

namespace SaberTTS;

class Shortcode {

  public $tag = 'shortcode';
  public $templatePath = 'templates/';

  public function __construct() {
    add_action('init', array( $this, 'init'));
  }

  public function init() {
    add_shortcode($this->tag, array($this, 'doShortcode'));
  }

  public function doShortcode( $atts ) {

    $atts = shortcode_atts(
      array('id' => 0), 
      $atts,
      $this->tag
    );
    $template = new Template();
    $template->path = $this->templatePath;
    $template->name = $this->templateName;
    $template->data = $this->loadData($atts);
    return $template->get();

  }

  public function loadData($atts) {
    return [];
  }

}
