<?php
use Twilio\Rest\Client;


class SIP_FUNCTIONS extends ADDABLE{
	public $TWI_SID = 'AC224aa9a347959fc6471cf8e7b81d3e98';
	public $TWI_TOKEN = 'a22e6f5cd92801ddbe25502ee221a9c2';

	public function SIP_DUMP(){
		$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
		foreach ($client->api->accounts->read() as $account) {
			var_dump($account);
		}
	}

	public function RETURN_SIP_ACCOUNTS(){
		$return = array();
		$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
		foreach ($client->api->accounts->read() as $account) {
			$return[] = array(
				'AccountId' => $account->sid,
				'AccountName' => $account->friendlyName,
				'AccountStatus' => $account->status,
				'AccountParent' => $account->ownerAccountSid,
				'AccountType' => $account->type,
				'AccountAuthToken' => $account->authToken,
				'AccountDateCreated' => $account->dateCreated,
				'AccountDateUpdated' => $account->dateUpdated
			);
		}
		return $return;

	}

	public function CREATE_SIP_ACCOUNT($subAccountName = null){
		if(!empty($subAccountName)){
			$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
			$account = $client->api->accounts->create(array(
				'FriendlyName' => $subAccountName,
			));

			// Acc Disabled
			$account_status = 0;
			if($account->status == 'active'){
				// Acc Active
				$account_status = 1;
			} else if($account->status == 'suspended'){
				// Acc Suspended
				$account_status = 2;
			}

			$account_ownerAccountSid = $account->ownerAccountSid;
			if($account->sid == $account->ownerAccountSid){
				$account_ownerAccountSid = '';
			}

			$this->QUERY(array(
				'query' => '
					INSERT INTO accounts (
						account_uid,
						account_name,
						account_status,
						account_parent,
						account_type,
						account_auth_token,
						account_date_created,
						account_date_updated					
					) VALUES (
						:AccountId,
						:AccountName,
						:AccountStatus,
						:AccountParent,
						:AccountType,
						:AccountAuthToken,
						:AccountDateCreated,
						:AccountDateUpdated
					)',
				'replacementArray' => array(
					'AccountId' => $account->sid,
					'AccountName' => $account->friendlyName,
					'AccountStatus' => $account_status,
					'AccountParent' => $account_ownerAccountSid,
					'AccountType' => $account->type,
					'AccountAuthToken' => $account->authToken,
					'AccountDateCreated' => $account->dateCreated->date,
					'AccountDateUpdated' => $account->dateUpdated->date

				),
				'returnArray' => array()
			));

			return true;
		} else {
			return false;
		}
	}

	public function SYNC_SIP_ACCOUNTS(){
		$return = array();
		$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
		foreach ($client->api->accounts->read() as $account){
			$account_count = $this->QUERY(array(
				'query' => 'SELECT * FROM accounts WHERE account_uid = :AccountId',
				'replacementArray' => array('AccountId' => $account->sid),
				'returnArray' => array('account_uid')
			));

			if(count($account_count) < 1){
				// Acc Disabled
				$account_status = 0;
				if($account->status == 'active'){
					// Acc Active
					$account_status = 1;
				} else if($account->status == 'suspended'){
					// Acc Suspended
					$account_status = 2;
				}

				$account_ownerAccountSid = $account->ownerAccountSid;
				if($account->sid == $account->ownerAccountSid){
					$account_ownerAccountSid = '';
				}

				$this->QUERY(array(
					'query' => '
						INSERT INTO accounts (
							account_uid,
							account_name,
							account_status,
							account_parent,
							account_type,
							account_auth_token,
							account_date_created,
							account_date_updated					
						) VALUES (
							:AccountId,
							:AccountName,
							:AccountStatus,
							:AccountParent,
							:AccountType,
							:AccountAuthToken,
							:AccountDateCreated,
							:AccountDateUpdated
						)',
					'replacementArray' => array(
						'AccountId' => $account->sid,
						'AccountName' => $account->friendlyName,
						'AccountStatus' => $account_status,
						'AccountParent' => $account_ownerAccountSid,
						'AccountType' => $account->type,
						'AccountAuthToken' => $account->authToken,
						'AccountDateCreated' => $account->dateCreated->date,
						'AccountDateUpdated' => $account->dateUpdated->date
					),
					'returnArray' => array()
				));
			}
		}
		return $return;
	}

	public function SUSPEND_SIP_ACCOUNT($subAccountId = null){
		if(!empty($subAccountId)){
			$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
			$client->api->accounts($subAccountId)->update(
				array('status' => 'suspended')
			);

			$this->QUERY(array(
				'query' => 'UPDATE accounts
					SET	account_status = "2"
					WHERE account_uid = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array()
			));

			return true;
		} else {
			return false;
		}
	}

	public function UNSUSPEND_SIP_ACCOUNT($subAccountId = null){
		if(!empty($subAccountId)){
			$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
			$client->api->accounts($subAccountId)->update(
				array('status' => 'active')
			);

			$this->QUERY(array(
				'query' => 'UPDATE accounts
					SET	account_status = "1"
					WHERE account_uid = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array()
			));

			return true;
		} else {
			return false;
		}
	}

	public function DELETE_SIP_ACCOUNT($subAccountId = null){
		if(!empty($subAccountId)){
			$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
			$client->api->accounts($subAccountId)->update(
				array('status' => 'closed')
			);

			$this->QUERY(array(
				'query' => 'UPDATE accounts
					SET	account_status = "0"
					WHERE account_uid = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array()
			));

			return true;
		} else {
			return false;
		}
	}

	public function GET_SIP_ACCOUNT_PHONE_NUMBERS($subAccountId = null){
		if(!empty($subAccountId)){
			$user = $this->QUERY(array(
				'query' => 'SELECT * FROM accounts WHERE account_uid = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array('account_auth_token')
			));

			$client = new Client($subAccountId,$user['account_auth_token'][0]);

			$return = array();
			foreach ($client->incomingPhoneNumbers->read() as $number) {
				$return[] = array(
					'sid' => $number->sid,
					'number' => $number->phoneNumber
				);
			}

			return $return;
		} else {
			return false;
		}
	}

	public function GET_SIP_ACCOUNT_USAGE($subAccountId = null){
		if(!empty($subAccountId)){
			$user = $this->QUERY(array(
				'query' => 'SELECT * FROM accounts WHERE account_uid = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array('account_auth_token')
			));

			$client = new Client("ACfc09fb17c8ec8af2a4d0a27eeb7d747d",$user['account_auth_token'][0]);

			$getTotalMinutes = $client->usage->records->thisMonth->read(
				array(
					"category" => "calls"
				)
			);
			$getTotalPrice = $client->usage->records->thisMonth->read(

			);
			/*
			 * array(
					"category" => ""
				)
			 * */
			$return = array(
				'calls' => array(
					'usage' => '',
					'usageUnit' => ''
				),
				'totalPrice' => array(
					'price' => '',
					'priceUnit' => ''
				)
			);
			foreach ($getTotalPrice as $record) {
				if($record->category == 'calls'){
					$return['calls']['usage'] = $record->usage;
					$return['calls']['usageUnit'] = $record->usageUnit;
					$return['calls']['usageCount'] = $record->count;

				} else if($record->category == 'totalprice'){
					$return['totalPrice']['price'] = $record->price;
					$return['totalPrice']['priceUnit'] = $record->priceUnit;

				}

				  #$record->priceUnit.'




			}
var_dump($return);

/*
 * phonenumbers-setups
 * calls-sip-inbound
 * calls-inbound
 * trunking-termination
 * phonenumbers
 * calls-client
 * totalprice
 *
			var_dump($client->usage->records->thisMonth->read());
*/

		} else {
			return false;
		}
	}

}
