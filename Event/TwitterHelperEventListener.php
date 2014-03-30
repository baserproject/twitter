<?php
class TwitterHelperEventListener extends BcHelperEventListener {
	
	public $events = array('Form.afterCreate');
	
	public function formAfterCreate (CakeEvent $event) {
		
		$id = $event->data['id'];
		$out = $event->data['out'];
		$View = $event->subject();
		
		if($View->Form->model() == 'Twitter') {
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
		
		if(empty($View->Form->params['admin'])){
			return $out;
		}
		if(!empty($View->Form->params['plugin'])){
			$plugin = $View->Form->params['plugin'];
		}
		$controller = $View->Form->params['controller'];
		$action = $View->Form->params['action'];

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
			return $View->element('Twitter.twitter_update', array('statusTemplate' => $setting['status_template'])).$out;
		}
		
		return $out;
		
	}
	
}