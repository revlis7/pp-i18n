<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller
{
  public function index()
  {
    $this->load->helper(array('form'));

    $this->output->enable_profiler(true);

    // benchmark start
    $this->benchmark->mark('format_messages_start');

    // get all messages from poppen & gays, and merge them together
    $gays_collection   = $this->config->item('gays_collection');
    $poppen_collection = $this->config->item('poppen_collection');

    $param = $this->input->get();

    $search_in = !empty($param['search_in']) ? $param['search_in'] : 'STRING_NAME';
    $keyword   = !empty($param['keyword'])   ? preg_replace('/\*/', '.*', $param['keyword']) : '.*';
    switch($search_in) {
      case 'STRING_NAME':
        $regex  = array('$regex' => new MongoRegex("/^".$keyword."$/"));
        $g_docs = $this->tnc_mongo->db->$gays_collection->find(array('string_name' => $regex));
        $g_docs->sort(array('updated_at' => 1));
        $p_docs = $this->tnc_mongo->db->$poppen_collection->find(array('string_name' => $regex));
        $p_docs->sort(array('updated_at' => 1));
        break;
      default:
        $g_docs = $this->tnc_mongo->db->$gays_collection->find();
        $g_docs->sort(array('updated_at' => 1));
        $p_docs = $this->tnc_mongo->db->$poppen_collection->find();
        $p_docs->sort(array('updated_at' => 1));
        break;
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