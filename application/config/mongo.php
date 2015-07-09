<?php

$config['mongo_server']  = 'mongodb://10.60.1.223:27018, moleman-poppen:27017';
$config['mongo_dbname']  = 'meteor';
$config['mongo_options'] = array('replicaSet' => 'rs1');

$config['poppen_collection'] = 'PoppenMessage';
$config['gays_collection']   = 'GaysMessage';

// $config['poppen_collection'] = 'PoppenMessage_MigrationTest';
// $config['gays_collection']   = 'GaysMessage_MigrationTest';