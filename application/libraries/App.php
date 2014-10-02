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

  function get_languages_by_community($community)
  {
    return element($community, $this->get('community_language'));
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
}