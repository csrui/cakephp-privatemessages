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
}
?>