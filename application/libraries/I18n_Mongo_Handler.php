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

  public function update($community, $string_name, $language, $message)
  {
    $old_trans = $this->collection_list[$community]->findOne(array('string_name' => $string_name));
    if (!$old_trans || $message == $old_trans['trans_'.$language]) {
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
}