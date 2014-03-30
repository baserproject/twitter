<?php
/* SVN FILE: $Id$ */
/**
 * Twitter設定コントローラー
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
 * Twitter設定コントローラー
 *
 * @package			twitter.controllers
 */
class TwitterConfigsController extends BcPluginAppController {
/**
 * コントローラー名
 * @var		string
 * @access	public
 */
	public $name = 'TwitterConfigs';
/**
 * モデル
 * @var		array
 * @access	public
 */
	public $uses = array('Twitter.TwitterConfig', 'Twitter.Twitter');
/**
 * コンポーネント
 * @var     array
 * @access  public
 */
	public $components = array('BcAuth','Cookie','BcAuthConfigure');
/**
 * ヘルパー
 * 
 * @var array
 * @access public
 */
	public $helpers = array('BcForm');
/**
 * ぱんくずナビ
 *
 * @var array
 * @access public
 */
	public $crumbs = array(
		array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index')),
		array('name' => 'Twitter管理', 'url' => array('controller' => 'twitter_configs', 'action' => 'form'))
	);
/**
 * サブメニューエレメント
 *
 * @var array
 * @access public
 */
	public $subMenuElements = array('twitter');
/**
 * コンストラクタ
 *
 * @access	public
 */
	public function __construct($request = null, $response = null){
		// セッションのセキュリティレベルが、medium の場合、session.referer_check が設定されてしまい、
		// Twitter からのリダイレクトでセッションが引き継げない為、一旦 low に設定する
		// 但し、ノーマルモードの場合、bootstrapでセッションがスタートされてしまうので、
		// デバッグモードが前提
		Configure::write('Security.level', 'low');
		parent::__construct($request, $response);
	}
/**
 * beforeFilter
 * @return	void
 * @access	public
 */
	public function beforeFilter(){
		
		parent::beforeFilter();
		$this->BcAuth->allow('authorize_callback');

	}
/**
 * Twitterアプリケーション認証
 * @return	void
 * @access	public
 */
	public function admin_authorize () {
		$data = $this->TwitterConfig->findExpanded();
		$redirectUri = Router::url('/twitter/twitter_configs/authorize_callback',true);
		$authorizeUri = $this->Twitter->authorize($data['consumer_key'],
													$data['consumer_secret'],
													$redirectUri,
													$this->Session);
		if($authorizeUri){
			$this->redirect($authorizeUri);
		} else {
			$this->setMessage('Twitterへのアクセスに失敗しました。', true);
		}

		$this->redirect(array('admin'=>true, 'action'=>'form'));
	}
/**
 * Twitterアプリケーション認証コールバック処理
 * @return	void
 * @access	public
 */
	public function authorize_callback () {

		if (isset($this->params['url']['denied'])) {

			$this->Session->SetFlash('アプリケーションの登録が拒否されました。');
			$this->redirect(array('admin'=>true, 'action'=>'authorize'));

		}elseif(isset($this->params['url']['oauth_verifier'])) {

			$data = $this->TwitterConfig->findExpanded();

			if($this->Twitter->createConsumer($data['consumer_key'], $data['consumer_secret'])){
				$accessToken = $this->Twitter->getAccessToken($this->Session);
				if($accessToken){
					$data['access_token_key'] = $accessToken->key;
					$data['access_token_secret'] = $accessToken->secret;
					if($this->TwitterConfig->saveKeyValue($data)){
						$result = true;
					} else {
						$result = false;
					}
				} else {
					$result = false;
				}
			} else {
				$result = false;
			}

			if($result){
				$this->Session->SetFlash('アプリケーションの登録が完了しました。');
			} else {
				$this->Session->SetFlash('アプリケーションの登録に失敗しました。');
			}

			$this->redirect(array('admin'=>true, 'action'=>'form'));

		}

		$this->notFound();

	}
/**
 * Twitter設定
 * @return	void
 * @access	public
 */
	public function admin_form() {

		if(!$this->request->data){

			$this->request->data['TwitterConfig'] = $this->TwitterConfig->findExpanded();
			if(!empty($this->request->data['TwitterConfig']['tweet_settings'])){
				$this->request->data['TwitterConfig']['tweet_settings_array'] = BcUtil::unserialize($this->request->data['TwitterConfig']['tweet_settings']);
				foreach($this->request->data['TwitterConfig']['tweet_settings_array'] as $key => $settings) {
					$this->request->data['TwitterConfig']['tweet_setting_'.$key] = $settings['status'];
				}
			}
		} else {

			if($this->TwitterConfig->validates()){

				// テストデータ生成用↓
				//$tweetSettings = array(array('id'=>1,'name'=>'ブログ記事','plugin'=>'blog','controller'=>'blog_posts','action'=>'edit','status_template'=>'blog','status'=>1));

				$tweetSettings = BcUtil::unserialize($this->request->data['TwitterConfig']['tweet_settings']);
				$i = 0;
				while(isset($this->request->data['TwitterConfig']['tweet_setting_'.$i])) {
					$tweetSettings[$i]['status'] = $this->request->data['TwitterConfig']['tweet_setting_'.$i];
					unset($this->request->data['TwitterConfig']['tweet_setting_'.$i]);
					$i++;
				}

				$this->request->data['TwitterConfig']['tweet_settings'] = BcUtil::serialize($tweetSettings);

				if($this->TwitterConfig->saveKeyValue($this->request->data)) {
					$message = 'Twitterプラグイン設定を保存しました。';
					$this->setMessage($message);
					$this->TwitterConfig->saveDbLog($message);
					$this->redirect(array('action'=>'form'));
				}else{
					$this->setMessage('データベース保存時にエラーが発生しました。', true);
				}

			} else {
				$this->setMessage('入力エラーです。内容を修正してください。', true);
			}

		}

		$this->pageTitle = 'Twitterプラグイン設定';
		$this->help = 'twitter_configs_form';

	}

}

