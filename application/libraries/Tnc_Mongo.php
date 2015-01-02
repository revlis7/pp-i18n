<?php

class Tnc_Mongo extends Mongo
{
  var $db;

  function Tnc_Mongo()
  {
    // Fetch CodeIgniter instance
    $ci = &get_instance();
    // Load Mongo configuration file
    $ci->load->config('mongo');

    // Fetch Mongo server and database configuration
    $server = $ci->config->item('mongo_server');
    $dbname = $ci->config->item('mongo_dbname');

    // Initialise Mongo
    if ($server)
    {
      parent::__construct($server);
    }
    else
    {
      parent::__construct();
    }
    $this->db = $this->$dbname;
    $this->db->setSlaveOkay(true);
  }
}