<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] Twitterアプリケーション登録画面
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
	<p>TwitterへこのサイトをTwitterアプリケーションとして登録します。<br />
	事前に<a href="http://twitter.com/apps" target="_blank">Twitterアプリケーションの登録ページ</a>で必要情報の入力を行い、Consumer key と Consumer secret の取得が必要です。</p>
	<p><small>※ Twitterのアカウントをお持ちでない方はTwitterへのサインアップが必要です。</small></p>
	<p>アプリケーション名、アプリケーションの説明、アプリケーションのウェブサイトURLについては任意ですが、次のようにご入力頂けると幸いです。</p>
	<ul>
		<li>「アプリケーション名」欄には、「<strong>BaserCMS</strong>」と入力してください。</li>
		<li>「アプリケーションの説明」欄には、「<strong>国産オープンソース！コーポレートサイトにちょうどいいCMS</strong>」と入力してください。</li>
		<li>「アプリケーションのウェブサイトURL」欄には、「<strong>http://basercms.net/</strong>」と入力してください。</li>
		<li>「アプリケーションの種類」欄では「<strong>ブラウザアプリケーション</strong>」を選択します。</li>
		<li>「コールバックURL」欄では、次のURLを入力します。<br />「<strong><?php echo Router::url('/twitter/twitter_configs/authorize_callback',true) ?></strong>」</li>
		<li>「Default Access type」欄では、「<strong>Read & Write</strong>」を選択します。</li>
		<li>「Twitterでログインする」欄へのチェックは不要です。</li>
	</ul>
	<p>取得ができたら、下のフォームに「Consumer key」と「Consumer secret」入力し、「更新」ボタンをクリックします。<br />
		その後、Twitterの認証画面が表示されますので、「許可する」をクリックすると完了となります。</p>
</div>
<p><small><span class="required">*</span> 印の項目は必須です。</small></p>
<?php echo $form->create('TwitterConfig',array('action'=>'authorize')) ?>
<?php echo $form->hidden('TwitterConfig.id') ?>
<table cellpadding="0" cellspacing="0" class="admin-row-table-01">
	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $form->label('TwitterConfig.consumer_key', 'Consumer key') ?></th>
		<td class="col-input">
			<?php echo $form->text('TwitterConfig.consumer_key', array('size'=>35,'maxlength'=>255)) ?>
			<?php echo $html->image('img_icon_help_admin.gif',array('id'=>'helpConsumerKey','class'=>'help','alt'=>'ヘルプ')) ?>
			<?php echo $form->error('TwitterConfig.consumer_key') ?>
			<div id="helptextConsumerKey" class="helptext">
				<ul>
					<li>Twitterのアプリケーション登録で発行された Consumer key を入力してください。</li>
				</ul>
			</div>
		</td>
	</tr>
	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $form->label('TwitterConfig.consumer_secret', 'Consumer secret') ?></th>
		<td class="col-input">
			<?php echo $form->text('TwitterConfig.consumer_secret', array('size'=>35,'maxlength'=>255)) ?>
			<?php echo $html->image('img_icon_help_admin.gif',array('id'=>'helpConsumerSecret','class'=>'help','alt'=>'ヘルプ')) ?>
			<?php echo $form->error('TwitterConfig.consumer_secret') ?>
			<div id="helptextConsumerSecret" class="helptext">
				<ul>
					<li>Twitterのアプリケーション登録で発行された Consumer Secret を入力してください。</li>
				</ul>
			</div>
		</td>
	</tr>
</table>
<div class="align-center"> <?php echo $form->end(array('label'=>'更　新','div'=>false,'class'=>'btn-orange button')) ?> </div>
