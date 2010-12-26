<?php

class MsgsMessage extends MsgsAppModel {
	
	var $useTable = 'messages';
	
	var $actsAs = array('Containable');
	
	var $belongsTo = array(
		'UacProfile' => array('className' => 'Uac.UacProfile', 'foreignKey' => 'from_id'),
		'MsgsRecipient' => array('className' => 'Msgs.MsgsRecipient', 'foreignKey' => 'to_id'),
	);
	
	var $validate = array(
		'title' => array(
        	'empty' => array('rule' => 'notEmpty', 'allowEmpty' => false)
        ),
        'body' => array(
        	'rule' => 'notEmpty',
        	'allowEmpty' => false
        ),       
        'to_id' => array('rule' => 'numeric')
    );

    /*
     * Create a new message
     * 
     * @param int $user_id
     * @param string $subject
     * @param string $body
     * @param int $from_id
     * @return bol
     */
    function send($to_id, $subject, $body, $from_id) {
    	
    	$data['MsgsMessage'] = array(
			'to_id' => $to_id,
			'from_id' => $from_id,
			'title' => $subject,
			'body' => $body
		);
			
		$this->create($data['MsgsMessage']);
		return $this->save($data['MsgsMessage']);
    	
    }
	
}

?>