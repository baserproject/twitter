<?php $this->BcBaser->js('Twitter.twitter_update') ?>
<?php $this->BcBaser->css('Twitter.twitter') ?>
<?php $this->BcBaser->element('Twitter.status/'.$statusTemplate, array('plugin'=>'twitter')) ?>
<div id="TwitterUpdateBox" class="corner5">
	<div class="clearfix">
		<?php echo $this->BcForm->create('Twitter', array('url'=> array('plugin'=>'twitter', 'controller'=>'twitter','action'=>'tinyurl'),'action'=>'tinyurl'), false) ?>
		<span id="TextCounter">0</span>
		<strong>Twitterへ送信</strong>　　<?php echo $this->BcForm->checkbox('Twitter.tinyurl',array('label'=>'URLを短くする')) ?>　
		<?php $this->BcBaser->img('/img/admin/ajax-loader-s.gif',array('alt'=>'loding...','id'=>'AjaxLoader','class'=>'display-none')) ?>
		<?php echo $this->BcForm->end(null, false) ?>
	</div>
	<?php echo $this->BcForm->create('Twitter', array('url'=> array('plugin'=>'twitter','controller'=>'twitter', 'action'=>'update'), 'action'=>'update'), false) ?>
	<?php echo $this->BcForm->textarea('Twitter.status',array('cols'=>76)) ?>
	<div class="submit" style="display:inline;"><?php echo $this->BcForm->end(array('lable'=>'ツイート','div'=>false,'id'=>'TwitterUpdateSubmit', 'class' => 'button'), false) ?></div>
	<div id="ResultMessage" style="display:none">&nbsp;</div>
</div>
