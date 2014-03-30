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
 * @link			http://basercms.net baserCMS Project
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
App::import('Vendor','OAuthClient', array('file' => 'OAuth' . DS . 'OAuthClient.php'));
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
	public $consumer = null;
	
/**
 * Request Token URI
 * @var		string
 * @access	public
 */
	public $requestTokenUri = 'https://api.twitter.com/oauth/request_token';
	
/**
 * Access Token URI
 * @var		string
 * @access	public
 */
	public $accessTokenUri = 'https://api.twitter.com/oauth/access_token';
	
/**
 *Authorize URI
 * @var		string
 * @access	public
 */
	public $authorizeUri = 'https://api.twitter.com/oauth/authorize';
	
/**
 * API URI
 * @var		string
 * @access	public
 */
	public $apiUri = 'https://api.twitter.com/1.1/';

/**
 * 認証時コールバック URI
 * @var		string
 * @access	public
 */
	public $callbackUri = '';
	
/**
 * Consumer Key
 * @var		string
 * @access	public
 */
	public $consumerKey = '';
	
/**
 * Consumer Secret
 * @var		string
 * @access	public
 */
	public $consumerSecret = '';
	
/**
 * Access Token Key
 * @var		string
 * @access	public
 */
	public $accessTokenKey = '';
	
/**
 * Access Token Secret
 * @var		string
 * @access	public
 */
	public $accessTokenSecret = '';
	
/**
 * setup
 * @param	Model
 * @param	array	ビヘイビアの設定値
 * @return	void
 */
	public function setup(Model $Model, $config = array()) {

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
	public function authorize(Model $Model, $consumerKey, $consumerSecret, $callbackUri, $Session){

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
	public function getRequestToken (Model $Model) {

		$requestToken = $this->consumer->getRequestToken($this->requestTokenUri, $this->callbackUri);
		return $requestToken;

	}
	
/**
 * アクセストークンを取得する
 * @param	Model		$Model
 * @param	Session		$Session
 * @return	AccessToken	$accessToken
 */
	public function getAccessToken(Model $Model, $Session){

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
	public function createConsumer(Model $Model, $consumerKey=null, $consumerSecret=null) {

		if($consumerKey){
			$this->consumerKey = $consumerKey;
		}
		if($consumerSecret){
			$this->consumerSecret = $consumerSecret;
		}
		if(!$this->consumerKey || !$this->consumerSecret){
			return false;
		}
		$this->consumer = new OAuthClient($this->consumerKey,$this->consumerSecret);
		if($this->consumer){
			return true;
		} else {
			return false;
		}

	}
	
/**
 * TwitterのAPIを呼び出す
 * 
 * @param type $method
 * @param type $params
 * @return type
 */
	public function api(Model $Model, $method, $options) {
		
		if(!preg_match('/\.json$/', $method)) {
			$method .= '.json';
		}
		$api = $this->apiUri . $method;
		$type = 'get';
		switch($method) {
			case 'statuses/update.json':
				if(mb_strlen($options['status'], 'UTF-8') > 140){
					return false;
				}
				$type = 'post';
				break;
		}
		return $this->consumer->{$type}($this->accessTokenKey, $this->accessTokenSecret, $api, $options);
		
	}
	
}
