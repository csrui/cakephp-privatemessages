<?php echo $this->Html->css('/msgs/css/msgs', null, array('inline' => false)); ?>

<div id="secondary-nav" class="actions nav">
	<ul>
		<li><?php echo $this->Html->link(__('New Message', true), array('action' => 'send')); ?></li>
		<li><?php echo $this->Html->link(__('Inbox', true), array('action' => 'inbox')); ?></li>
	</ul>
</div>

<h2><?php __('Sent') ?></h2>

<table id="messages-sentbox" class="message-table">
	<thead>
		<tr>
			<th width="15%"><?php __('To') ?></th>
			<th width="65%"><?php __('Subject') ?></th>
			<th width="20%"><?php __('Sent') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($messages as $msg) : ?>
			<tr>
				<td>
					<?php echo $msg['MsgsRecipient']['username'] ?>
				</td>
				<td><?php echo $this->Html->link($msg['MsgsMessage']['title'], array('action' => 'view', $msg['MsgsMessage']['id'])) ?></td>
				<td align="right">
					<span class="timestamp"><?php echo $time->niceShort($msg['MsgsMessage']['created']) ?></span>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>



<?php echo $this->element('paging'); ?>