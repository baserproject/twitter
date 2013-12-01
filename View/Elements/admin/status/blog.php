<?php
$url = $this->BcBaser->getUri('/'.$blogContent['BlogContent']['name'].'/archives/'.$this->BcForm->value('BlogPost.no'));
$title = $blogContent['BlogContent']['title'];
$comment = $this->BcForm->value('BlogPost.name');
?>
<div id="TwitterStatusSrc" style="display: none">
	[<?php echo $title ?>] <?php echo $comment ?> <?php echo $url ?>
</div>