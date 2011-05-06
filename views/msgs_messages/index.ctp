<?php echo $this->Html->css('/msgs/css/msgs', null, array('inline' => false)); ?>

<div id="secondary-nav" class="actions nav">
	<ul>
		<li><?php echo $this->Html->link(__('New Message', true), array('action' => 'send')); ?></li>
		<li><?php echo $this->Html->link(__('Sent Messages', true), array('action' => 'sent')); ?></li>
	</ul>
</div>

<h2><?php __('Inbox') ?></h2>

<table id="message-inbox" class="message-table">
	<thead>
		<tr>
			<th width="15%"><?php __('From') ?></th>
			<th width="65%"><?php __('Subject') ?></th>
			<th width="20%"><?php __('Recieved') ?></th>
		</tr>
	</thead>
	<tbody>
<?php

foreach($messages as $msg) :

	$classes = array();

	if ($msg['MsgsMessage']['read'] == 1)
	{
		$classes[] = 'read';
	}

?>
<tr class="<?php echo implode(' ', $classes) ?>">
	<td>
		<?php echo $this->element('avatar', array('user' => $msg['UacProfile'], 'avatar_size' => 'tiny')) ?>
	</td>
	<td>
		<span class="title"><?php echo $this->Html->link($msg['MsgsMessage']['title'], array('action' => 'view', $msg['MsgsMessage']['id'])) ?></span>
		<span class="body"><?php echo $this->Text->truncate($msg['MsgsMessage']['body']) ?></span>
	</td>
	<td align="right">
		<span class="timestamp"><?php echo $this->Time->niceShort($msg['MsgsMessage']['created']) ?></span>
	</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo $this->element('paging'); ?>
