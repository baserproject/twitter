<?php
/* SVN FILE: $Id$ */
/**
 * Twitterフックモデル
 *
 * PHP versions 4 and 5
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2010, Catchup, Inc.
 *								9-5 nagao 3-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2010, Catchup, Inc.
 * @link			http://basercms.net baserCMS Project
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
	public $registerHooks = array('afterFormCreate');
/**
 * formExCreate
 * @param	string	$out
 * @return	string	$out
 * @access	public
 */
	public function afterFormCreate($form, $id, $out){
		
		if($this->Form->model() == 'Twitter') {
			return $out;
		}
		$TwitterConfig = ClassRegistry::init('Twitter.TwitterConfig');
		$config = $TwitterConfig->findExpanded();
		if(empty($config['tweet_settings']) || empty($config['consumer_secret']) || empty($config['access_token_secret'])){
			return $out;
		}
		$settings = BcUtil::unserialize($config['tweet_settings']);

		if(!$settings) {
			return $out;
		}

		$plugin = $controller = $action = '';
		
		if(empty($this->Form->params['admin'])){
			return $out;
		}
		if(!empty($this->Form->params['plugin'])){
			$plugin = $this->Form->params['plugin'];
		}
		$controller = $this->Form->params['controller'];
		$action = $this->Form->params['action'];

		$id = "";
		if(preg_match('/id=\"([^\"]+)\"/', $out, $matches)) {
			$id = $matches[1];
		}

		$tweet = false;
		foreach ($settings as $setting) {
			// TODO 色々なフォームで使えるように設定値をデータベースに持っている仕様だが、
			// データベースの更新が 2.0.0 のリリースには間に合わない為、ブログ記事のみの暫定措置
			$setting['id'] = "BlogPostForm";
			if($plugin == $setting['plugin'] && $controller == $setting['controller'] && $action == $setting['action'] && $id == $setting['id'] && $setting['status']){
				$tweet = true;
				break;
			}
		}

		if($tweet) {
			$View = ClassRegistry::getObject('View');
			return $View->renderElement('admin/twitter_update', array('plugin' => 'twitter','statusTemplate'=>$setting['status_template'])).$out;
		}
		
		return $out;

	}
}

