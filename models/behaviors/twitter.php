<?php
/* SVN FILE: $Id$ */
/**
 * Twitterビヘイビア
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								18-1 nagao 1-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2011, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			twitter.models.behaviors
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * include files
 */
App::import('Vendor','oauth',array('file'=>'OAuth'.DS.'oauth_consumer.php'));
/**
 * Twitterビヘイビア
 *
 * @package			twitter.models.behaviors
 */
class TwitterBehavior extends ModelBehavior{
/**
 * consumer
 * @var		Consumer
 * @access	public
 */
	var $consumer = null;
/**
 * Request Token URI
 * @var		string
 * @access	public
 */
	var $requestTokenUri = 'https://api.twitter.com/oauth/request_token';
/**
 * Access Token URI
 * @var		string
 * @access	public
 */
	var $accessTokenUri = 'https://api.twitter.com/oauth/access_token';
/**
 *Authorize URI
 * @var		string
 * @access	public
 */
	var $authorizeUri = 'https://api.twitter.com/oauth/authorize';
/**
 * ユーザータイムライン取得用 URI
 * @var		string
 * @access	public
 */
	var $timelineUri = 'http://api.twitter.com/1.1/statuses/user_timeline.xml';
/**
 * ステータス更新用 URI
 * @var		string
 * @access	public
 */
	var $updateUri = 'http://api.twitter.com/1.1/statuses/update.xml';
/**
 * 認証時コールバック URI
 * @var		string
 * @access	public
 */
	var $callbackUri = '';
/**
 * Consumer Key
 * @var		string
 * @access	public
 */
	var $consumerKey = '';
/**
 * Consumer Secret
 * @var		string
 * @access	public
 */
	var $consumerSecret = '';
/**
 * Access Token Key
 * @var		string
 * @access	public
 */
	var $accessTokenKey = '';
/**
 * Access Token Secret
 * @var		string
 * @access	public
 */
	var $accessTokenSecret = '';
/**
 * setup
 * @param	Model
 * @param	array	ビヘイビアの設定値
 * @return	void
 */
	function setup(&$Model, $config = array()) {

		if(!empty($config['consumerKey'])){
			$this->consumerKey = $config['consumerKey'];
		}
		if(!empty($config['consumerKey'])){
			$this->consumerSecret = $config['consumerSecret'];
		}
		if(!empty($config['accessTokenKey'])){
			$this->accessTokenKey = $config['accessTokenKey'];
		}
		if(!empty($config['accessTokenSecret'])){
			$this->accessTokenSecret = $config['accessTokenSecret'];
		}
		if(!empty($config['statusFieldName'])){
			$this->statusFieldName = $config['statusFieldName'];
		}
	}
/**
 * 認証処理
 * @param	Model
 * @param	string	$consumerKey
 * @param	array	$consumerSecret
 * @param	string	$callbackUri
 * @param	Session	$Session
 * @return	void
 * @access	public
 */
	function authorize(&$Model, $consumerKey, $consumerSecret, $callbackUri, &$Session){

		$this->callbackUri = $callbackUri;
		$this->consumerKey = $consumerKey;
		$this->consumerSecret = $consumerSecret;

		if($this->createConsumer($Model)){
			$requestToken = $this->getRequestToken($Model);
			if($requestToken) {
				$data = array('key' => $requestToken->key, 'secret' => $requestToken->secret);
				$Session->write('request_token', $data);
				return $this->authorizeUri.'?oauth_token='.$requestToken->key;
			}
		}

		return false;

	}
/**
 * リクエストトークンを取得する
 * @param	Model			$Model
 * @return	RequestToken	$requestToken
 */
	function getRequestToken (&$Model) {

		$requestToken = $this->consumer->getRequestToken($this->requestTokenUri, $this->callbackUri);
		return $requestToken;

	}
/**
 * アクセストークンを取得する
 * @param	Model		$Model
 * @param	Session		$Session
 * @return	AccessToken	$accessToken
 */
	function getAccessToken(&$Model, &$Session){

		$token = $Session->read('request_token');
		$requestToken = new OAuthToken($token['key'], $token['secret']);
		$accessToken = $this->consumer->getAccessToken( $this->accessTokenUri, $requestToken);
		if($accessToken) {
			$this->accessTokenKey = $accessToken->key;
			$this->accessTokenSecret = $accessToken->secret;
		}
		return $accessToken;

	}
/**
 * Consumer を生成する
 * @param	Model	$Model
 * @param	string	$consumerKey
 * @param	string	$consumerSecret
 * @return	boolean
 */
	function createConsumer(&$Model,$consumerKey=null, $consumerSecret=null) {

		if($consumerKey){
			$this->consumerKey = $consumerKey;
		}
		if($consumerSecret){
			$this->consumerSecret = $consumerSecret;
		}
		if(!$this->consumerKey || !$this->consumerSecret){
			return false;
		}
		$this->consumer = new OAuth_Consumer($this->consumerKey,$this->consumerSecret);
		if($this->consumer){
			return true;
		} else {
			return false;
		}

	}
/**
 * タイムラインを取得する
 * @param	Model	$Model
 * @param	array	$conditions
 * @return	mixed	タイムラインデータ
 */
	function timeline(&$Model, $conditions) {
		$options['count'] = $conditions['limit'];
		return $this->consumer->get( $this->accessTokenKey, $this->accessTokenSecret, $this->timelineUri, $options);
	}
/**
 * ツイートを更新
 * @param	Model	$Model
 * @param	boolean	$status
 * @return	mixed	成功時：XML / 失敗時：エラーメッセージ
 */
	function update(&$Model, $status) {
		if(mb_strlen($status,'UTF-8')>140){
			return false;
		}
		return $this->consumer->post($this->accessTokenKey, $this->accessTokenSecret, $this->updateUri, array('status'=>$status));
	}

}
?>