<?php

class I18n_Mongo_Handler
{
  var $CI;
  var $collection_list = array();

  public function __construct()
  {
    $this->CI =& get_instance();
    $communities = $this->CI->app->get_communities();
    foreach ($communities as $community => $community_name) {
      $collection_name = $this->CI->config->item($community.'_collection');
      $this->collection_list[$community] = $this->CI->tnc_mongo->db->$collection_name;
    }
  }

  public function findOne($community, $string_name)
  {
    $doc = $this->collection_list[$community]->findOne(array('string_name' => $string_name));
    if (!$doc) {
      return false;
    }
    return $doc;
  }

  public function insert($community, $string_name, $language = '', $message = '')
  {
    $doc = $this->findOne($community, $string_name);
    if ($doc) {
      return false;
    }
    $doc = $this->getDocument($string_name);
    if ($language && $field = $this->CI->app->get_language_field($language)) {
      $doc[$field] = $message;
    }
    $this->collection_list[$community]->insert($doc);
    return $doc['created_at'];
  }

  public function update($community, $string_name, $language, $message)
  {
    $doc = $this->findOne($community, $string_name);
    if (!$doc || $message == $doc['trans_'.$language]) {
      return false;
    }
    $field = $this->CI->app->get_language_field($language);
    $update_ts = time();
    $new_message = array('$set' => array(
      $field       => $message,
      "updated_at" => $update_ts,
    ));
    $this->collection_list[$community]->update(array('string_name' => $string_name), $new_message);
    return $update_ts;
  }

  public function remove($community, $string_name)
  {
    $result = $this->collection_list[$community]->remove(array('string_name' => $string_name));
  }

  private function getDocument($string_name)
  {
    $doc = array(
      'string_name' => $string_name,
      'cat_id'      => 2,
      'original'    => '',
      'trans_de'    => '',
      'trans_en'    => '',
      'trans_es'    => '',
      'created_at'  => time(),
      'updated_at'  => time(),
    );
    return $doc;
  }
}