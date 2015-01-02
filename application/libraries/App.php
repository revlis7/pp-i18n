<?php

class App 
{
  private $CI;

  function __construct()
  {
    $this->CI =& get_instance();
  }

  function get($item_name)
  {
    $this->CI->config->load('app', true);
    
    $item = $this->CI->config->item($item_name, 'app');
    return $item;
  }

  function get_communities()
  {
    return $this->get('community');
  }

  function get_search_range_list()
  {
    $list = array(
      'string_name' => 'String Name',
    );

    $communities = $this->get_communities();
    foreach($communities as $community => $comm_name) {
      $languages = $this->get_languages_by_community($community);
      foreach($languages as $language) {
        $key   = $community.'_'.$language;
        $value = $comm_name.' '.$this->get_language_name($language);
        $list[$key] = $value;
      }
    }
    return $list;
  }

  function get_language_name($language)
  {
    return element($language, $this->get('language'));
  }

  function get_language_field($language)
  {
    return 'trans_'.strtolower($language);
  }

  function get_setting_cookie($name)
  {
    return $this->CI->input->cookie($name, true);
  }

  function get_current_community($side = 'left')
  {
    $side = $side == 'left' ? $side : 'right';
    $cookie_name = 'community_'.$side;
    $value = $this->get_setting_cookie($cookie_name);
    if (empty($value)) {
      $key = 'default_community_'.$side;
      return $this->get($key);
    }
    return $value;
  }

  function get_current_language($side = 'right')
  {
    $side = $side == 'left' ? $side : 'right';
    $cookie_name = 'language_'.$side;
    $value = $this->get_setting_cookie($cookie_name);
    if (empty($value)) {
      $key = 'default_language_'.$side;
      return $this->get($key);
    }
    return $value;
  }
}