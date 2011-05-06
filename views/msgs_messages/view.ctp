<?php echo $this->Html->css('/msgs/css/msgs', null, array('inline' => false)); ?>

<div id="secondary-nav" class="actions nav">
	<ul>
		<li><?php echo $this->Html->link(__('Reply', true), array('controller' => 'msgs_messages', 'action' => 'reply', $message['MsgsMessage']['id'])); ?></li>
		<li><?php echo $this->Html->link(__('New Message', true), array('controller' => 'msgs_messages', 'action' => 'send')); ?></li>
		<li><?php echo $this->Html->link(__('Inbox', true), array('controller' => 'msgs_messages', 'action' => 'inbox')); ?></li>
		<li><?php echo $this->Html->link(__('Sent Messages', true), array('controller' => 'msgs_messages', 'action' => 'sent')); ?></li>
	</ul>
</div>

<h2><?php __('Messages') ?></h2>

<div>
	<h3><?php echo $message['MsgsMessage']['title'] ?></h3>
	<?php __('From') ?>: <?php echo $this->element('avatar', array('user' => $message['UacProfile'])) ?>
	<span class="clear"></span>
	<p><?php __('Sent')?>: <span class="timestamp"><?php echo $message['MsgsMessage']['created'] ?></span></p>
</div>

<span class="clear"></span>

<p class="body">
	<?php echo Sanitize::html(nl2br($message['MsgsMessage']['body'])) ?>
</p>