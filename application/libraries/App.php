<?php

class App {
  private $CI;

  function __construct() {
    $this->CI =& get_instance();
  }

  function get($item_name) {
    $this->CI->config->load('app', true);
    
    $item = $this->CI->config->item($item_name, 'app');
    return $item;
  }

  function get_communities() {
    return $this->get('community');
  }
}