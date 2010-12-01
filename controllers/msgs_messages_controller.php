<?php

class MsgsMessagesController extends MsgsAppController {

	var $paginate = array('MsgsMessage' => array('order' => 'MsgsMessage.created DESC'));

	var $components = array('Email');

	var $helpers = array('Bbcode');

	/**
	 * Send new messages
	 * @param string $user Works with username or user ID
	 * @todo Send e-mail with the message
	 * @return void
	 */
	function send($user = null)
	{

		if (!is_null($user))
		{
			$cond = array('OR' => array(
				'UaUser.id' => $user,
				'UaUser.username' => $user
			));
			if ($user = $this->MsgsMessage->UaUser->find('first', array('conditions' => $cond)))
			{
				$this->data['MsgsMessage']['to'] = $user['UaUser']['username'];
			}

		}
		elseif (!empty($this->data))
		{

			$cond = array('OR' => array(
				'MsgsRecipient.id' => $this->data['MsgsMessage']['to'],
				'MsgsRecipient.username' => $this->data['MsgsMessage']['to']
			));

			if ($to = $this->MsgsMessage->MsgsRecipient->find('first', array('conditions' => $cond)))
			{

				$this->data['MsgsMessage']['from_id'] = $this->Auth->user('id');
				$this->data['MsgsMessage']['to_id'] = $to['MsgsRecipient']['id'];

				if ($this->MsgsMessage->save($this->data['MsgsMessage']))
				{
					$this->__notify($this->data);
					$this->Session->setFlash(__('Message sent', true));
					$this->redirect(array('action' => 'inbox'));
				}

			}
			else
			{
				$this->Session->setFlash(__('Username not found', true));
			}

		}


	}

	/**
	 * Send an e-mail with the message content to the user
	 * @param array $data
	 * @return void
	 */
	private function __notify($data)
	{

		$this->MsgsMessage->UaUser->Contain();
		$destUser = $this->MsgsMessage->UaUser->findById($data['MsgsMessage']['to_id'], array('username', 'first_name', 'last_name', 'email'));

		$this->Email->smtpOptions = Configure::read('Email');
		$this->Email->from = sprintf('%s <%s>', Configure::read('App.name'), Configure::read('App.email'));
		$this->Email->subject = 'You recieved a new message on ' . Configure::read('App.name');

		$name = $destUser['UaUser']['username'];

		if (!empty($destUser['UaUser']['first_name']) && !empty($destUser['UaUser']['last_name']))
		{
			$name = $destUser['UaUser']['first_name'] . ' ' . $destUser['UaUser']['last_name'];
		}

		$this->Email->to = sprintf('"%s" <%s>', $name, $destUser['UaUser']['email']);
		$this->Email->template = 'new_message';
		$this->Email->sendAs = 'html';

		$this->set('fromUsername', $this->Auth->user('username'));
		$this->set('toUsername', $destUser['UaUser']['username']);
		$this->set('body', $data['MsgsMessage']['body']);

		if (!$this->Email->send())
		{
			$this->log('Error sending email "New Message".', LOG_ERROR);
			$this->log($this->Email->smtpError, LOG_ERROR);
			$this->Session->setFlash(sprintf(__('There was an error sending the e-mail, please contact us at %s', true), Configure::read('App.email')));
		}

	}

	/**
	 * Messages Sent to the Session User
	 * @return
	 */
	function inbox()
	{

		$cond = array(
			'MsgsMessage.to_id' => $this->Auth->user('id')
		);

		$messages = $this->paginate($cond);

		$this->set('messages', $messages);

	}


	/**
	 * Messages Sent from the Session User
	 * @return
	 */
	function sent()
	{

		$cond = array(
			'MsgsMessage.from_id' => $this->Auth->user('id')
		);

		$messages = $this->paginate($cond);

		$this->set('messages', $messages);

	}

	function view($id) {

		$cond = array('MsgsMessage.id' => $id);

		if ($msg = $this->MsgsMessage->find('first', array('conditions' => $cond))) {

			if ($msg['MsgsMessage']['from_id'] == $this->Auth->user('id') || $msg['MsgsMessage']['to_id'] == $this->Auth->user('id')) {

				if ($msg['MsgsMessage']['to_id'] == $this->Auth->user('id')) {

					$this->MsgsMessage->saveField('read', 1);

				}

				$this->set('message', $msg);

			}

		}

	}

	/**
	 * Reply to a private message
	 * @param int $id
	 * @return void
	 */
	function reply($id) {

		$msg = $this->MsgsMessage->read(null, $id);

		if ($msg['MsgsMessage']['to_id'] != $this->Auth->user('id')) {

			$this->Session->setFlash(__('You don\' have permission', true));
			$this->redirect($this->referer());

		}
		$this->set('original', $msg);
		unset($msg);		

		if (!empty($this->data)) {
			
			$this->MsgsMessage->create($this->data['MsgsMessage']);
			$this->data['MsgsMessage']['from_id'] = $this->Auth->user('id');
			if ($this->MsgsMessage->save($this->data['MsgsMessage'])) {

				$this->Session->setFlash(__('Your reply was sent', true));
				$this->redirect(array('controller' => $this->name, 'action' => 'inbox'));

			}

		}


	}

}

?>