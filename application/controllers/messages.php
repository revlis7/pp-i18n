<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller
{
  public function index()
  {
    $this->load->helper(array('form'));
    //$this->config->load('app', true);
    var_dump($this->app->get_communities());
    exit;
    $this->output->enable_profiler(true);

    // benchmark start
    $this->benchmark->mark('format_messages_start');

    // get all messages from poppen & gays, and merge them together
    $gays_collection   = $this->config->item('gays_collection');
    $poppen_collection = $this->config->item('poppen_collection');

    $param = $this->input->get();

    if(!empty($param)) {
      $search_in = $param['search_in'];
      $keyword   = !empty($param['keyword']) ? preg_replace('/\*/', '.*', $param['keyword']) : '';
      $g_docs = $this->tnc_mongo->db->$gays_collection->find(array('string_name' => $param['keyword']));
      $p_docs = $this->tnc_mongo->db->$poppen_collection->find(array('string_name' => $param['keyword']));
    } else {
      $g_docs = $this->tnc_mongo->db->$gays_collection->find();
      $p_docs = $this->tnc_mongo->db->$poppen_collection->find();
    }

    $g_assoc_docs = array();
    foreach($g_docs as $g_doc) {
      $g_assoc_docs[$g_doc['string_name']] = $g_doc;
    }

    $messages = array();
    foreach($p_docs as $p_doc) {
      $string_name = $p_doc['string_name'];
      $g_doc = isset($g_assoc_docs[$string_name]) ? $g_assoc_docs[$string_name] : null;
      $messages[$string_name] = array(
        'p' => $p_doc,
        'g' => $g_doc,
      );
    }

    foreach($g_docs as $g_doc) {
      $string_name = $g_doc['string_name'];
      if(!isset($messages[$string_name])) {
        $messages[$string_name] = array(
          'p' => null,
          'g' => $g_doc,
        );
      }
    }

    // benchmark end
    $this->benchmark->mark('format_messages_end');

    // pagination
    $this->config->load('pagination', true);
    $page_config = $this->config->item('pagination');
    $page_config['total_rows'] = count($messages);

    $this->load->library('pagination');
    $this->pagination->initialize($page_config);
    $page_links = $this->pagination->create_links();

    $page_messages = array_slice($messages, ($this->pagination->cur_page - 1) * $page_config['per_page'], $page_config['per_page']);
    $data = array(
      'search_in'     => $param['search_in'] ? $param['search_in'] : 0,
      'keyword'       => $param['keyword'] ? $param['keyword'] : '',
      'page_links'    => $page_links,
      'page_messages' => $page_messages);
    $this->template->load('default', 'messages/index', $data);
  }
}