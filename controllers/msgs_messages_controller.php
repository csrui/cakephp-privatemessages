<?php
/**
 * undocumented class
 *
 * @package Messages
 * @author Rui Cruz
 */
class MsgsMessagesController extends MsgsAppController {

	var $components = array(
		'CronMailer.EmailQueue'
	);

	var $paginate = array(
		'MsgsMessage' => array(
			'order' => 'MsgsMessage.created DESC'
		)
	);

	#var $helpers = array('Bbcode');

	/**
	 * Send new messages
	 * @param string $screen_name
	 * @return void
	 */
	function send($screen_name = null) {

		if (!is_null($screen_name)) {
			
			$this->data['MsgsMessage']['to'] = $screen_name;

		} elseif (!empty($this->data)) {

			$cond = array(
				'MsgsRecipient.screen_name' => $this->data['MsgsMessage']['to']
			);
				
			$this->MsgsMessage->MsgsRecipient->Contain();
			$recipient = $this->MsgsMessage->MsgsRecipient->findByScreenName($this->data['MsgsMessage']['to']);
				
			if (!$recipient) {
				$this->MsgsMessage->invalidate('to', __('Sorry but we can\'t find that username', true));
			}
			
			$this->data['MsgsMessage']['to_id'] = $recipient['MsgsRecipient']['id'];
			
			if ($this->MsgsMessage->send($this->data['MsgsMessage']['to_id'], $this->data['MsgsMessage']['title'], $this->data['MsgsMessage']['body'], $this->Account->id())) {
			
				$this->afterSend($this->data);
				$this->Session->setFlash(__('Your private message was sent', true));
				$this->redirect(array('action' => 'inbox'));

			}

		}

	}

	/**
	 * Send an e-mail with the message content to the user
	 * @param array $data
	 * @return void
	 */
	private function afterSend($data) {
		
		$this->set('body', $data['MsgsMessage']['body']);
		
		$this->EmailQueue->to = $this->controller->data['UacUser']['email'];
		$this->EmailQueue->from = Configure::read('Email.username');
		$this->EmailQueue->subject = sprintf('%s %s', Configure::read('App.name'), __('private message received', true));
		$this->EmailQueue->template = $this->controller->action;
		$this->EmailQueue->sendAs = 'both';
		$this->EmailQueue->delivery = 'db';
		$this->EmailQueue->send();
		
		return;
		
		
		
		# TODO REMOVE AFTER TESTING

		// $this->MsgsMessage->UaUser->Contain();
		// $destUser = $this->MsgsMessage->UaUser->findById($data['MsgsMessage']['to_id'], array('username', 'first_name', 'last_name', 'email'));
		// 
		// $this->Email->smtpOptions = Configure::read('Email');
		// $this->Email->from = sprintf('%s <%s>', Configure::read('App.name'), Configure::read('App.email'));
		// $this->Email->subject = 'You recieved a new message on ' . Configure::read('App.name');
		// 
		// $name = $destUser['UaUser']['username'];
		// 
		// if (!empty($destUser['UaUser']['first_name']) && !empty($destUser['UaUser']['last_name']))
		// {
		// 	$name = $destUser['UaUser']['first_name'] . ' ' . $destUser['UaUser']['last_name'];
		// }
		// 
		// $this->Email->to = sprintf('"%s" <%s>', $name, $destUser['UaUser']['email']);
		// $this->Email->template = 'new_message';
		// $this->Email->sendAs = 'html';
		// 
		// $this->set('fromUsername', $this->Auth->user('username'));
		// $this->set('toUsername', $destUser['UaUser']['username']);
		// $this->set('body', $data['MsgsMessage']['body']);
		// 
		// if (!$this->Email->send())
		// {
		// 	$this->log('Error sending email "New Message".', LOG_ERROR);
		// 	$this->log($this->Email->smtpError, LOG_ERROR);
		// 	$this->Session->setFlash(sprintf(__('There was an error sending the e-mail, please contact us at %s', true), Configure::read('App.email')));
		// }

	}

	/**
	 * Messages Sent to the Session User
	 * @return
	 */
	function inbox() {

		$cond = array(
			'MsgsMessage.to_id' => $this->Account->id()
		);

		$messages = $this->paginate($cond);

		$this->set('messages', $messages);

	}


	/**
	 * Messages Sent from the Session User
	 * @return
	 */
	function sent() {

		$cond = array(
			'MsgsMessage.from_id' => $this->Account->id()
		);

		$messages = $this->paginate($cond);

		$this->set('messages', $messages);

	}

	function view($id) {

		$cond = array('MsgsMessage.id' => $id);

		if ($msg = $this->MsgsMessage->find('first', array('conditions' => $cond))) {

			if ($msg['MsgsMessage']['from_id'] == $this->Account->id() || $msg['MsgsMessage']['to_id'] == $this->Account->id()) {

				if ($msg['MsgsMessage']['to_id'] == $this->Account->id()) {

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

		if ($msg['MsgsMessage']['to_id'] != $this->Account->id()) {

			$this->Session->setFlash(__('You don\' have permission', true));
			$this->redirect($this->referer());

		}
		$this->set('original', $msg);
		unset($msg);		

		if (!empty($this->data)) {
			
			$this->MsgsMessage->create($this->data['MsgsMessage']);
			$this->data['MsgsMessage']['from_id'] = $this->Account->id();
			if ($this->MsgsMessage->save($this->data['MsgsMessage'])) {

				$this->Session->setFlash(__('Your reply was sent', true));
				$this->redirect(array('controller' => $this->name, 'action' => 'inbox'));

			}

		}


	}

}

?>