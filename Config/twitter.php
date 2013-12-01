<?php
/* SVN FILE: $Id$ */
/**
 * フィード設定
 *
 * PHP versions 4 and 5
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2012, baserCMS Users Community <http://sites.google.com/site/baserusers/>
 *
 * @copyright		Copyright 2008 - 2012, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			baser.config
 * @since			baserCMS v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * システムナビ
 */
$config['BcApp.adminNavi.twitter'] = array(
		'name'		=> 'Twitterプラグイン',
		'contents'	=> array(
			array('name' => 'Twitterプラグイン設定', 'url' => array('admin' => true, 'plugin' => 'twitter', 'controller' => 'twitter_configs', 'action' => 'form'))
	)
);