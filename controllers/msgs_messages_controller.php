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
	function send($id = null) {

		if (is_null($id)) {
			
			$id = $this->data['MsgsMessage']['to_id'];
			
		}
		
		if (!empty($this->data)) {
			
			if ($this->MsgsMessage->send($this->data['MsgsMessage']['to_id'], $this->data['MsgsMessage']['title'], $this->data['MsgsMessage']['body'], $this->Account->id())) {
			
				$this->afterSend($this->data);
				$this->Session->setFlash(__('Your private message was sent', true));
				$this->redirect($this->referer());

			}

		}
		
		$this->MsgsMessage->UacProfile->Contain();
		$recipient = $this->MsgsMessage->UacProfile->read(null, $id);
		$this->set('recipient', $recipient);
		$this->data['MsgsMessage']['to_id'] = $recipient['UacProfile']['id'];

	}

	/**
	 * Send an e-mail with the message content to the user
	 * @param array $data
	 * @return void
	 */
	private function afterSend($data) {
				
		$this->MsgsMessage->UacProfile->Contain('UacUser');
		$user = $this->MsgsMessage->UacProfile->read(array('UacProfile.screen_name', 'UacUser.email'), $this->data['MsgsMessage']['to_id']);
			
		$this->set('body', $data['MsgsMessage']['body']);
		$this->set('from', $this->Account->user('UacProfile.screen_name'));
		$this->set('to', $user['UacProfile']['screen_name']);
		
		$this->Notifier->send(sprintf('%s <%s>', $user['UacProfile']['screen_name'], $user['UacUser']['email']), 'You received a private message');

	}

	/**
	 * Messages Sent to the Session User
	 * @return
	 */
	function index() {

		$cond = array(
			'MsgsMessage.to_id' => $this->Account->id()
		);

		$messages = $this->paginate($cond);

		$this->set('messages', $messages);		

	}
	
	public function count() {
		
		$conditions = array(
			'MsgsMessage.to_id' => $this->Account->id(),
			'MsgsMessage.read' => 0
		);

		$total = $this->MsgsMessage->find('count', compact('conditions'));

		$this->set('total', array('unread' => $total));
		
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
	// function reply($id) {
	// 
	// 	$msg = $this->MsgsMessage->read(null, $id);
	// 
	// 	if ($msg['MsgsMessage']['to_id'] != $this->Account->id()) {
	// 
	// 		$this->Session->setFlash(__('You don\' have permission', true));
	// 		$this->redirect($this->referer());
	// 
	// 	}
	// 	$this->set('original', $msg);
	// 	unset($msg);		
	// 
	// 	if (!empty($this->data)) {
	// 		
	// 		$this->MsgsMessage->create($this->data['MsgsMessage']);
	// 		$this->data['MsgsMessage']['from_id'] = $this->Account->id();
	// 		if ($this->MsgsMessage->save($this->data['MsgsMessage'])) {
	// 
	// 			$this->Session->setFlash(__('Your reply was sent', true));
	// 			$this->redirect(array('controller' => $this->name, 'action' => 'inbox'));
	// 
	// 		}
	// 
	// 	}
	// 
	// 
	// }

}

?>