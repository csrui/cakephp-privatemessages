<?php echo $this->Html->css('/msgs/css/msgs', null, array('inline' => false)); ?>

<div id="secondary-nav" class="actions nav">
	<ul>
		<li><?php echo $this->Html->link(__('Inbox', true), array('action' => 'inbox')); ?></li>
		<li><?php echo $this->Html->link(__('Sent Messages', true), array('action' => 'sent')); ?></li>
	</ul>
</div>

<h2><?php __('Reply to the message') ?></h2>

<?php

$title = (empty($this->data['MsgsMessage']['title'])) ? 'Re: ' .$original['MsgsMessage']['title'] : $this->data['MsgsMessage']['title'];

echo $this->Form->create('MsgsMessage', array('url' => array('action' => 'reply', $original['MsgsMessage']['id'])));
echo $this->Form->hidden('to_id', array('value' => $original['UaUser']['id']));
echo $this->Form->input('title', array('value' => $title ));
echo $this->Form->input('body', array('class' => 'mceEditor'));
echo $this->Form->end('Send');

?>