<?php 
/* SVN FILE: $Id$ */
/* Planamatch schema generated on: 2010-06-13 15:06:22 : 1276440802*/
class PlanamatchSchema extends CakeSchema {
	var $name = 'Planamatch';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 75),
		'body' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'from_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'index'),
		'to_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'index'),
		'read' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_messages_users' => array('column' => 'from_id', 'unique' => 0), 'fk_messages_recipients' => array('column' => 'to_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45, 'key' => 'unique'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45, 'key' => 'unique'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'avatar_file_name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'public' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'tel' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'tlm' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 75),
		'about' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'dob' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'time_zone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'language' => array('type' => 'string', 'null' => true, 'default' => 'EN', 'length' => 45),
		'location_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'address' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'lat' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'lng' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'activation_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'last_login' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'UNIQUE_username' => array('column' => 'username', 'unique' => 1), 'UNIQUE_email' => array('column' => 'email', 'unique' => 1), 'fk_users_locations' => array('column' => 'location_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
}
?>