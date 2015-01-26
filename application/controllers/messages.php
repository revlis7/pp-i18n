<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller
{
  public function template()
  {
    $this->template->load('default', 'messages/mockup');
  }

  public function index()
  {
    $this->load->helper(array('form'));

    // $this->output->enable_profiler(true);

    $messages = $this->searchInMongo();

    // pagination
    $this->config->load('pagination', true);
    $page_config = $this->config->item('pagination');
    $page_config['total_rows'] = count($messages);

    $this->load->library('pagination');
    $this->pagination->initialize($page_config);
    $page_links = $this->pagination->create_links();
    $page_messages = array_slice($messages, ($this->pagination->cur_page - 1) * $page_config['per_page'], $page_config['per_page']);
    $data = array(
      'communities'   => $this->app->get_communities(),
      'languages'     => $this->app->get('language'),
      'current_community_left'  => $this->app->get_current_community('left'),
      'current_community_right' => $this->app->get_current_community('right'),
      'current_language_left'   => $this->app->get_current_language('left'),
      'current_language_right'  => $this->app->get_current_language('right'),
      'search'        => $this->input->get('search'),
      'keyword'       => $this->input->get('keyword'),
      'page_links'    => $page_links,
      'page_messages' => $page_messages);
    $this->template->load('default', 'messages/index', $data);
  }

  public function search($search = 'string_name', $keyword = '*', $page = 1)
  {
    $this->load->helper(array('form'));

    // $this->output->enable_profiler(true);

    $messages = $this->searchInMongo($search, $keyword);

    // pagination
    $this->config->load('pagination', true);
    $page_config = $this->config->item('pagination');
    $page_config['base_url']    = '/search/'.$search.'/keyword/'.$keyword.'/page/';
    $page_config['uri_segment'] = 6;
    $page_config['total_rows']  = count($messages);

    $this->load->library('pagination');
    $this->pagination->initialize($page_config);
    $page_links = $this->pagination->create_links();
    $page_messages = array_slice($messages, ($this->pagination->cur_page - 1) * $page_config['per_page'], $page_config['per_page']);

    $data = array(
      'communities'   => $this->app->get_communities(),
      'languages'     => $this->app->get('language'),
      'current_community_left'  => $this->app->get_current_community('left'),
      'current_community_right' => $this->app->get_current_community('right'),
      'current_language_left'   => $this->app->get_current_language('left'),
      'current_language_right'  => $this->app->get_current_language('right'),
      'search'        => $search,
      'keyword'       => $keyword,
      'page_links'    => $page_links,
      'page_messages' => $page_messages);
    $this->template->load('default', 'messages/index', $data);
  }

  public function save()
  {
    $this->getParams();
    $this->i18n_mongo_handler->update($this->comm, $this->stn, $this->lang, $this->message);
    echo json_encode(array('r' => 'ok', 'message' => htmlspecialchars($this->message)));
  }

  private function getParams()
  {
    $this->comm = $this->input->post('comm');
    $this->lang = $this->input->post('lang');
    $this->stn  = $this->input->post('stn');
    $this->message = $this->input->post('message');
  }

  private function searchInMongo($search = 'string_name', $keyword = '')
  {
    // benchmark start
    $this->benchmark->mark('format_messages_start');

    // get all messages from poppen & gays, and merge them together
    $gays_collection   = $this->config->item('gays_collection');
    $poppen_collection = $this->config->item('poppen_collection');

    $search  = !empty($search)  ? $search : 'string_name';
    $keyword = !empty($keyword) ? preg_replace('/\*/', '.*', $keyword) : '.*';

    // if ($search != 'string_name') {

    // }


    switch($search) {
      case 'string_name':
        $regex  = array('$regex' => new MongoRegex("/^".$keyword."$/"));
        $g_docs = $this->tnc_mongo->db->$gays_collection->find(array('string_name' => $regex));
        $g_docs->sort(array('updated_at' => 1));
        $p_docs = $this->tnc_mongo->db->$poppen_collection->find(array('string_name' => $regex));
        $p_docs->sort(array('updated_at' => 1));
        break;
      case 'poppen_en':
        $regex  = array('$regex' => new MongoRegex("/^".$keyword."$/"));
        $g_docs = $this->tnc_mongo->db->$gays_collection->find(array('trans_en' => $regex));
        $g_docs->sort(array('updated_at' => 1));
        $p_docs = $this->tnc_mongo->db->$poppen_collection->find(array('trans_en' => $regex));
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
        'poppen' => $p_doc,
        'gays'   => $g_doc,
      );
    }

    foreach($g_docs as $g_doc) {
      $string_name = $g_doc['string_name'];
      if(!isset($messages[$string_name])) {
        $messages[$string_name] = array(
          'poppen' => null,
          'gays'   => $g_doc,
        );
      }
    }

    // benchmark end
    $this->benchmark->mark('format_messages_end');

    return $messages;
  }
}