<?php

$config['mongo_server']  = 'mongodb://10.60.1.223:27024,10.60.1.223:27025';
$config['mongo_dbname']  = 'meteor';
$config['mongo_options'] = array('replicaSet' => 'rs1');

$config['poppen_collection'] = 'GaysMessage';
$config['gays_collection']   = 'GaysMessage_Compare';

// $config['poppen_collection'] = 'PoppenMessage_MigrationTest';
// $config['gays_collection']   = 'GaysMessage_MigrationTest';