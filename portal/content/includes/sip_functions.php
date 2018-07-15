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
			if($account->sid != 'AC224aa9a347959fc6471cf8e7b81d3e98'){
				$return[] = array(
					'AccountId' => $account->sid,
					'AccountName' => $account->friendlyName,
					'AccountStatus' => $account->status,
					'AccountParent' => $account->ownerAccountSid,
					'AccountAuthToken' => $account->authToken,
					'AccountDateCreated' => $account->dateCreated,
					'AccountDateUpdated' => $account->dateUpdated
				);
			}
		}
		return $return;
	}

	public function RETURN_ACTIVE_SIP_ACCOUNTS(){
		$return = array();
		$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
		foreach ($client->api->accounts->read() as $account) {
			if($account->sid != 'AC224aa9a347959fc6471cf8e7b81d3e98' && $account->status == 'active'){
				$return[] = array(
					'AccountId' => $account->sid,
					'AccountName' => $account->friendlyName,
					'AccountParent' => $account->ownerAccountSid,
					'AccountAuthToken' => $account->authToken,
					'AccountDateCreated' => $account->dateCreated,
					'AccountDateUpdated' => $account->dateUpdated
				);
			}
		}
		return $return;
	}

	public function CREATE_SIP_ACCOUNT($companyId){
		if(!empty($companyId)){
			$company = $this->QUERY(array(
				'query' => '
					SELECT *
					FROM company
					WHERE company_id = :CompanyId',
				'replacementArray' => array(
					'CompanyId' => $companyId
				),
				'returnArray' => array('company_id','company_name','company_sip_id')
			));

			if(empty($company['company_sip_id'][0])){
				$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
				$account = $client->api->accounts->create(array(
					'FriendlyName' => $company['company_name'][0],
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

				$this->QUERY(array(
					'query' => '
						UPDATE company 
						SET	
							company_sip_id = :AccountSipId,
							company_sip_status = :AccountStatus,
							company_sip_authtoken = :AccountAuthToken,
							company_sip_created_timestamp = :AccountDateCreated,
							company_sip_updated_timestamp = :AccountDateUpdated
						WHERE 
							company_id = :CompanyId',
					'replacementArray' => array(
						'AccountSipId' => $account->sid,
						'AccountStatus' => $account_status,
						'AccountAuthToken' => $account->authToken,
						'AccountDateCreated' => $account->dateCreated->format('Y-m-d H:i:s'),
						'AccountDateUpdated' => $account->dateUpdated->format('Y-m-d H:i:s'),
						'CompanyId' => $company['company_id'][0]
					),
					'returnArray' => array()
				));

				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function SUSPEND_SIP_ACCOUNT($subAccountId = null){
		if(!empty($subAccountId)){
			$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
			$client->api->accounts($subAccountId)->update(
				array('status' => 'suspended')
			);

			$this->QUERY(array(
				'query' => 'UPDATE company
					SET	company_sip_status = "2"
					WHERE company_id = :AccountId',
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
				'query' => 'UPDATE company
					SET	company_sip_status = "1"
					WHERE company_id = :AccountId',
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
/*
			$this->QUERY(array(
				'query' => 'UPDATE company
					SET	company_sip_status = "0"
					WHERE company_id = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array()
			));
*/
			return true;
		} else {
			return false;
		}
	}

	public function GET_SIP_ACCOUNT_PHONE_NUMBERS($subAccountId = null){
		if(!empty($subAccountId)){
			$user = $this->QUERY(array(
				'query' => 'SELECT * FROM company WHERE company_id = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array('company_sip_authtoken')
			));

			$client = new Client($subAccountId,$user['company_sip_authtoken'][0]);

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
				'query' => 'SELECT * FROM company WHERE company_id = :AccountId',
				'replacementArray' => array('AccountId' => $subAccountId),
				'returnArray' => array('company_sip_authtoken')
			));

			$client = new Client("a",$user['account_auth_token'][0]);

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
