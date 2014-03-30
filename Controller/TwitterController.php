<?php
/* SVN FILE: $Id$ */
/**
 * Twitterコントローラー
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								18-1 nagao 1-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2011, Catchup, Inc.
 * @link			http://basercms.net baserCMS Project
 * @package			twitter.controllers
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * Twitterコントローラー
 *
 * @package			twitter.controllers
 */
class TwitterController extends BcPluginAppController {
/**
 * コントローラー名
 * @var		string
 * @access	public
 */
	public $name = 'Twitter';
	
/**
 * コンポーネント
 * @var     array
 * @access  public
 */
	public $components = array('RequestHandler', 'BcAuth','Cookie','BcAuthConfigure');

/**
 * beforeFilter
 */
	public function beforeFilter() {
		
		parent::beforeFilter();
		$this->BcAuth->allow('ajax_api');
		
	}

/**
 * [AJAX] Twitterのステータスを更新する（ツイート）
 * @return	mixid	TwitterユーザープロフィールへのURL / false
 * @access	public
 */
	public function admin_update(){

		if(!$this->request->data){
			$this->notFound();
		}else{
			
			$result = false;
			if(!empty($this->request->data['Twitter']['status'])){
				if($this->Twitter->setupTwitterBehavior()){
					$result = $this->Twitter->api('statuses/update.json', array('status' => $this->request->data['Twitter']['status']));
					
					if($result){
						$result = json_decode($result);
						if(isset($result->user->screen_name)) {
							$result = 'https://twitter.com/'.$result->user->screen_name;
						} else {
							$result = false;
						}
					}
				}
			}
			$this->set('result',$result);
		}
		Configure::write('debug', 0);
		$this->render('ajax_result');
		
	}
	
/**
 * [AJAX] URLを短いURLに変換する（tinyurl）
 * @return	mixed	変換後のURL / false
 * @access	public
 */
	public function admin_tinyurl(){
		if(!$this->request->data){
			$this->notFound();
		}else{
			$url = $this->_convertTinyurl($this->request->data['Twitter']['url']);
			if($url){
				$this->set('result', $url);
			}else{
				$this->set('result', false);
			}
		}
		$this->render('ajax_result');
	}
	
/**
 * TinyUrlのWebサービスを利用して短いURLに変換する
 * TinyUrlのサイトに接続できなかった場合は変換せずに返却
 * @param	string	$url
 * @return	string	成功した場合は変換後のURL / 失敗した場合は元のURL
 * @access	public
 */
	public function _convertTinyurl($url){
		$requestUrl = 'http://tinyurl.com/api-create.php?url='.$url;
		App::uses('HttpSocket', 'Network/Http');
		$sock = new HttpSocket();
		$tinyurl = $sock->get($requestUrl);
		if($tinyurl) {
			return $tinyurl;
		} else {
			return $url;
		}
	}
	
/**
 * Twitter API
 */
	public function ajax_api () {
		
		$args = func_get_args();
		$version = $args[0];
		unset($args[0]);
		$method = implode('/', $args);
		$query = $this->request->query;
		$callback = null;
		if(!empty($query['callback'])) {
			$callback = $query['callback'];
			unset($query['callback']);
		}
		if($this->Twitter->setupTwitterBehavior()){
			$result = $this->Twitter->api($method, $query);
			echo $callback  . '(' . $result. ')';		
			exit();
		}
		
	}

}

