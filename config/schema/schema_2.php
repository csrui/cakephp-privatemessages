<?php 
/* SVN FILE: $Id$ */
/* msgs schema generated on: 2011-03-19 17:03:39 : 1300554939*/
class msgsSchema extends CakeSchema {

	var $name = 'msgs';

	var $file = 'schema_2.php';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 75, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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