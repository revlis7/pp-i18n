<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller
{
  public function index()
  {
    $this->load->library('pagination');

    $config['base_url'] = '/messages/page/';
    $config['total_rows'] = $this->tnc_mongo->db->PoppenMessage_MigrationTest->count();
    $config['per_page'] = 10;
    $config['use_page_numbers'] = true;
    $config['num_links'] = 4;
    $config['full_tag_open']  = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = '&laquo;';
    $config['first_tag_open']  = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['next_link'] = false;
    $config['prev_link'] = false;
    $config['cur_tag_open']  = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open']  = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['last_link'] = '&raquo;';
    $config['last_tag_open']  = '<li>';
    $config['last_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page_links = $this->pagination->create_links();

    $this->output->enable_profiler(true);

    $this->benchmark->mark('fetch_gays_start');
    $g_assoc_docs = array();
    $g_docs = $this->tnc_mongo->db->GaysMessage_MigrationTest->find();
    foreach($g_docs as $g_doc) {
      $g_assoc_docs[$g_doc['string_name']] = $g_doc;
    }
    $this->benchmark->mark('fetch_gays_end');


    $this->benchmark->mark('get_messages_start');
    $messages = array();
    $p_docs = $this->tnc_mongo->db->PoppenMessage_MigrationTest->find();
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
    $this->benchmark->mark('get_messages_end');




    $page_messages = array_slice($messages, ($this->pagination->cur_page - 1) * $config['per_page'], $config['per_page']);
    $data = array('page_links' => $page_links, 'page_messages' => $page_messages);
    $this->template->load('default', 'messages/index', $data);
  }
}