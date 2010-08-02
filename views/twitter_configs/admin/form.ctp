<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] Twitterプラグイン設定画面
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
 * @package			twitter.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
?>
<h2>
	<?php $baser->contentsTitle() ?>
	&nbsp;<?php echo $html->image('img_icon_help_admin.gif',array('id'=>'helpAdmin','class'=>'slide-trigger','alt'=>'ヘルプ')) ?></h2>
<div class="help-box corner10 display-none" id="helpAdminBody">
	<h4>ユーザーヘルプ</h4>
	<p>Twitterプラグインでは次の二つの機能を提供しています。</p>
	<ul>
		<li>任意のユーザーのTwitterユーザータイムラインを任意の場所に表示</li>
		<li>ブログ記事編集画面へのTwitter投稿フォームの表示</li>
	</ul>
	<h5>Twitterタイムラインを表示するには</h5>
	<p>Twitterのユーザー名と表示件数を下のフォームに入力します。その後、<?php $baser->link('ウィジェットエリア管理',array('plugin'=>null,'controller'=>'widget_areas','action'=>'index')) ?>より「Twitterユーザータイムライン」を選択します。</p>
	<h5>ブログ記事の編集画面からTwitterの投稿を行うには</h5>
	<p>BaserCMSからTwitterへ投稿するには、Twitter公式サイトより「Twitterアプリケーション」としての登録を行い、許可をもらう必要があります。サイドメニューの「Twitterアプリケーション登録」を開き、ヘルプメッセージに従ってください。<br />
	登録が完了しましたら、下のフォームの「ブログ記事」にチェックを入れて保存してください。</p>
</div>
<p><small><span class="required">*</span> 印の項目は必須です。</small></p>
<?php echo $formEx->create('TwitterConfig',array('action'=>'form')) ?>
<table cellpadding="0" cellspacing="0" class="admin-row-table-01">
	<tr>
		<th class="col-head"><?php echo $formEx->label('TwitterConfig.username', 'Twitterユーザー名') ?></th>
		<td class="col-input">
			<?php echo $formEx->text('TwitterConfig.username', array('size'=>35,'maxlength'=>255)) ?>
			<?php echo $html->image('img_icon_help_admin.gif',array('id'=>'helpUsername','class'=>'help','alt'=>'ヘルプ')) ?>
			<?php echo $formEx->error('TwitterConfig.username') ?>
			<div id="helptextUsername" class="helptext">
				<ul>
					<li>アルファベットのユーザー名を入力します。</li>
					<li>Twitterのタイムライン出力に利用します。</li>
					<li>Twitterにサインアップされていない方は、<a href="http://twitter.com/signup" target="_blank">こちら</a>より取得します。</li>
				</ul>
			</div>
		</td>
	</tr>
	<tr>
		<th class="col-head"><?php echo $formEx->label('TwitterConfig.view_num', 'タイムライン表示件数') ?></th>
		<td class="col-input">
			<?php echo $formEx->text('TwitterConfig.view_num', array('size'=>5,'maxlength'=>3)) ?> 件
			<?php echo $html->image('img_icon_help_admin.gif',array('id'=>'helpViewNum','class'=>'help','alt'=>'ヘルプ')) ?>
			<?php echo $formEx->error('TwitterConfig.view_num') ?>
			<div id="helptextViewNum" class="helptext">タイムラインに表示する件数を入力します。</div>
		</td>
	</tr>
	<tr>
		<th class="col-head"><?php echo $formEx->label('TwitterConfig.description', 'Twitter投稿機能') ?></th>
		<td class="col-input">
			<?php echo $formEx->hidden('TwitterConfig.tweet_settings') ?>
			<?php if(!$formEx->value('TwitterConfig.consumer_secret') || !$formEx->value('TwitterConfig.access_token_secret')): ?>
			<div class="error">Twitterアプリケーションとしての登録が完了していないのでこの機能はまだ利用できません。</div>
			<?php endif ?>
			<?php if($formEx->value('TwitterConfig.tweet_settings_array')): ?>
				<?php foreach($formEx->value('TwitterConfig.tweet_settings_array') as $key => $setting): ?>
					<?php echo $formEx->checkbox('TwitterConfig.tweet_setting_'.$key, array('label'=>$setting['name'])) ?><br />
				<?php endforeach ?>
			<?php endif ?>
		</td>
	</tr>
</table>
<div class="align-center"> <?php echo $formEx->end(array('label'=>'更　新','div'=>false,'class'=>'btn-orange button')) ?> </div>