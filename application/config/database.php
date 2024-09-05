<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = true;

$db['default'] = array(
	'dsn' => '',
	// 'hostname' => 'localhost',
	// 'username' => 'axxpress2024',
	// 'password' => 'Axxpress2024',
	// 'database' => 'axxpress',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'prep_drop_shipping',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['main'] = array(
	'dsn' => '',
	// 'hostname' => 'localhost',
	// 'username' => 'u201590350_ecommerce',
	// 'password' => 'Ecommerce@2024',
	// 'database' => 'u201590350_ecommerce',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'prep_drop_shipping',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
