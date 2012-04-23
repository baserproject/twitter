<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] Twitterプラグイン設定画面
 *
 * PHP versions 4 and 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								9-5 nagao 3-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2011, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			twitter.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
?>
<?php echo $bcForm->create('TwitterConfig',array('action'=>'form')) ?>
<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
	<tr>
		<th class="col-head"><?php echo $bcForm->label('TwitterConfig.username', 'Twitterユーザー名') ?></th>
		<td class="col-input">
			<?php echo $bcForm->text('TwitterConfig.username', array('size'=>35,'maxlength'=>255)) ?>
			<?php echo $html->image('admin/icn_help.png', array('id' => 'helpUsername', 'class' =>'btn help','alt' => 'ヘルプ')) ?>
			<?php echo $bcForm->error('TwitterConfig.username') ?>
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
		<th class="col-head"><?php echo $bcForm->label('TwitterConfig.view_num', 'タイムライン表示件数') ?></th>
		<td class="col-input">
			<?php echo $bcForm->text('TwitterConfig.view_num', array('size'=>5,'maxlength'=>3)) ?> 件
			<?php echo $html->image('admin/icn_help.png', array('id'=>'helpViewNum', 'class'=>'btn help', 'alt'=>'ヘルプ')) ?>
			<?php echo $bcForm->error('TwitterConfig.view_num') ?>
			<div id="helptextViewNum" class="helptext">タイムラインに表示する件数を入力します。</div>
		</td>
	</tr>
	<tr>
		<th class="col-head"><?php echo $bcForm->label('TwitterConfig.description', 'Twitter投稿機能') ?></th>
		<td class="col-input">
			<?php echo $bcForm->hidden('TwitterConfig.tweet_settings') ?>
			<?php if(!$bcForm->value('TwitterConfig.consumer_secret') || !$bcForm->value('TwitterConfig.access_token_secret')): ?>
			<div class="error">
				Twitterアプリケーションとしての登録が完了していないのでこの機能はまだ利用できません。
				<?php if(Configure::read('debug') < 1): ?>
				<br />この機能を有効にするには、<?php $baser->link('システム設定',array('plugin'=>null, 'controller'=>'site_configs', 'action'=>'form')) ?>より、
				「制作・開発モード」をデバッグモードに切り替えると、ここに認証リンクが表示されますのでクリックします。
				<?php endif ?>
			</div>
				<?php if(Configure::read('debug') > 0): ?>
					<br /><?php $baser->link('≫ Twitterアプリ認証',array('action'=>'authorize')) ?>
				<?php endif ?>
			<?php else: ?>
				<?php if($bcForm->value('TwitterConfig.tweet_settings_array')): ?>
					<?php foreach($bcForm->value('TwitterConfig.tweet_settings_array') as $key => $setting): ?>
						<?php echo $bcForm->checkbox('TwitterConfig.tweet_setting_'.$key, array('label'=>$setting['name'])) ?><br />
					<?php endforeach ?>
				<?php endif ?>
			<?php endif ?>
		</td>
	</tr>
</table>

<div class="submit">
	<?php echo $bcForm->end(array('label'=>'更　新','div'=>false,'class'=>'btn-orange button')) ?>
</div>
