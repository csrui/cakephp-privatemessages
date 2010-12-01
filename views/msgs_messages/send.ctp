<?php echo $this->Html->css('/msgs/css/msgs', null, array('inline' => false)); ?>

<div id="secondary-nav" class="actions nav">
	<ul>
		<li><?php echo $this->Html->link(__('Inbox', true), array('action' => 'inbox')); ?></li>
		<li><?php echo $this->Html->link(__('Sent Messages', true), array('action' => 'sent')); ?></li>
	</ul>
</div>

<h2><?php __('Send a new message') ?></h2>

<?php

echo $this->Form->create('MsgsMessage', array('url' => array('action' => 'send')));
echo $this->Form->input('to');
echo $this->Form->input('title');
echo $this->Form->input('body', array('class' => 'mceEditor'));
echo $this->Form->end('Send');

?>
