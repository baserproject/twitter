<?php 
/* SVN FILE: $Id$ */
/* TwitterConfigs schema generated on: 2010-11-06 23:11:15 : 1289052015*/
class TwitterConfigsSchema extends CakeSchema {
	public $name = 'TwitterConfigs';

	public $path = '/Users/ryuring/Documents/Projects/basercms/app/tmp/schemas/';

	public $file = 'twitter_configs.php';

	public $connection = 'baser';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $twitter_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>