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

  public function search($search = 'string_name', $keyword = '', $page = 1)
  {
    $this->load->helper(array('form', 'url'));

    // $this->output->enable_profiler(true);

    // $search  = $this->input->get('search') ? $this->input->get('search') : 'string_name';
    // $keyword = $this->input->get('keyword') ? $this->input->get('keyword') : '';
    // $page    = $this->input->get('page') ? $this->input->get('page') : 1;

    $keyword = html_entity_decode(rawurldecode($keyword));
    if (empty($keyword)) {
      redirect('/');
    }

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

  public function create()
  {
    $this->getParams();
    $tmp = explode(',', $this->stn);
    $string_name_list = array();
    foreach ($tmp as $string_name) {
      $string_name = trim($string_name);
      if (!empty($string_name) && preg_match('/^[A-Za-z0-9,%_-]+$/', $string_name)) {
        $string_name_list[] = $string_name;
      }
    }
    if (empty($string_name_list)) {
      echo json_encode(array('r' => 'ko', 'message' => 'Invalid string name'));
      return;
    }
    $communities = $this->app->get_communities();
    foreach ($communities as $community => $community_name) {
      foreach ($string_name_list as $string_name) {
        $doc = $this->i18n_mongo_handler->findOne($community, $string_name);
        // string name exists
        if ($doc) {
          echo json_encode(array('r' => 'ko', 'message' => 'String name: \''.$string_name.'\' exists'));
          return;
        }
      }
    }

    foreach ($communities as $community => $community_name) {
      foreach ($string_name_list as $string_name) {
        $update_ts = $this->i18n_mongo_handler->insert($community, $string_name);
      }
    }
    if ($update_ts) {
      echo json_encode(array('r' => 'ok', 'message' => '', 'update_ts' => date('Y-m-d H:i:s', $update_ts), 'keyword' => '^'.implode('|', $string_name_list).'$'));
    } else {
      echo json_encode(array('r' => 'ko', 'message' => 'Create failed'));
    }
  }

  public function save()
  {
    $this->getParams();
    // insert or update
    $doc = $this->i18n_mongo_handler->findOne($this->comm, $this->stn);
    if ($doc) {
      $update_ts = $this->i18n_mongo_handler->update($this->comm, $this->stn, $this->lang, $this->message);
    } else {
      $update_ts = $this->i18n_mongo_handler->insert($this->comm, $this->stn, $this->lang, $this->message);
    }
    if ($update_ts) {
      echo json_encode(array('r' => 'ok', 'message' => htmlspecialchars($this->message), 'update_ts' => date('Y-m-d H:i:s', $update_ts)));
    } else {
      echo json_encode(array('r' => 'ko', 'message' => 'Update failed'));
    }
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

    switch($search) {
      case 'string_name':
        $regex  = array('$regex' => new MongoRegex("/".$keyword."/"));
        $g_docs = $this->tnc_mongo->db->$gays_collection->find(array('string_name' => $regex));
        $g_docs->sort(array('updated_at' => -1));
        $p_docs = $this->tnc_mongo->db->$poppen_collection->find(array('string_name' => $regex));
        $p_docs->sort(array('updated_at' => -1));
        break;
      case 'translation':
        $regex  = array('$regex' => new MongoRegex("/".$keyword."/"));
        $g_docs = $this->tnc_mongo->db->$gays_collection->find(array('$or' => array(
          array('trans_en' => $regex),
          array('trans_de' => $regex),
          array('trans_es' => $regex),
        )));
        $g_docs->sort(array('updated_at' => -1));
        $p_docs = $this->tnc_mongo->db->$poppen_collection->find(array('$or' => array(
          array('trans_en' => $regex),
          array('trans_de' => $regex),
          array('trans_es' => $regex),
        )));
        $p_docs->sort(array('updated_at' => -1));
        break;
      default:
        $g_docs = $this->tnc_mongo->db->$gays_collection->find();
        $g_docs->sort(array('updated_at' => -1));
        $p_docs = $this->tnc_mongo->db->$poppen_collection->find();
        $p_docs->sort(array('updated_at' => -1));
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

  public function export()
  {
    $filename = 'i18n-export-'.date('YmdHis');
    $left_language   = $this->input->get('left_language');
    $left_community  = $this->input->get('left_community');
    $right_language  = $this->input->get('right_language');
    $right_community = $this->input->get('right_community');

    $left_language_field  = $this->app->get_language_field($left_language);
    $right_language_field = $this->app->get_language_field($right_language);

    $search  = $this->input->get('search');
    $keyword = $this->input->get('keyword');

    $keyword = html_entity_decode(rawurldecode($keyword));
    if (empty($keyword)) {
      $search  = 'string_name';
      $keyword = '';
    }

    // query i18n strings
    $messages = $this->searchInMongo($search, $keyword);

    // Create new PHPExcel object
    $objPHPExcel = $this->phpexcel;

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("The Netcircle")
                                 ->setTitle($filename);

    // Add some data
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'STRING_NAME')
                ->setCellValue('B1', strtoupper($left_community.'_'.$left_language_field))
                ->setCellValue('C1', strtoupper($right_community.'_'.$right_language_field));

    if (!empty($messages)) {
      $row = 2;
      foreach ($messages as $string_name => $message) {
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row, $string_name)
                    ->setCellValue('B'.$row, $message[$left_community][$left_language_field])
                    ->setCellValue('C'.$row, $message[$right_community][$right_language_field]);
        $row++;
      }
    }

    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
  }
}