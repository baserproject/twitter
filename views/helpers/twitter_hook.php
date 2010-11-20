<?php
/* SVN FILE: $Id$ */
/**
 * Twitterフックモデル
 *
 * PHP versions 4 and 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2010, Catchup, Inc.
 *								9-5 nagao 3-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2010, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			twitter.views.helpers
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * Twitterフックモデル
 *
 * @package			twitter.models
 */
class TwitterHookHelper extends AppHelper{
/**
 * 登録フック
 * @var		array
 * @access	public
 */
	var $registerHooks = array('formExCreate');
/**
 * formExCreate
 * @param	string	$out
 * @return	string	$out
 * @access	public
 */
	function formExCreate($out){

		$TwitterConfig = ClassRegistry::init('Twitter.TwitterConfig');
		$config = $TwitterConfig->findExpanded();
		if(empty($config['tweet_settings']) || empty($config['consumer_secret']) || empty($config['access_token_secret'])){
			return $out;
		}
		$settings = unserialize($config['tweet_settings']);

		if(!$settings) {
			return $out;
		}

		$plugin = $controller = $action = '';
		$View = ClassRegistry::getObject('View');
		if(empty($View->params['admin'])){
			return $out;
		}
		if(!empty($View->params['plugin'])){
			$plugin = $View->params['plugin'];
		}
		$controller = $View->params['controller'];
		$action = $View->params['action'];

		$tweet = false;
		foreach ($settings as $setting) {
			if($plugin == $setting['plugin'] && $controller == $setting['controller'] && $action == $setting['action'] && $setting['status']){
				$tweet = true;
				break;
			}
		}

		if($tweet) {
			return $View->renderElement('admin/twitter_update', array('plugin' => 'twitter','statusTemplate'=>$setting['status_template'])).$out;
		}
		
		return $out;

	}
}
?>