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

	public function FORMAT_PHONE_NUMBER($phoneNumber = null,$countryCode = "GB"){
		$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
		return $client->lookups->v1->phoneNumbers($phoneNumber)
				   ->fetch(array("countryCode" => $countryCode))
				   ->nationalFormat;
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
			if($account->sid != $this->TWI_SID && $account->status == 'active'){
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

	public function CREATE_SIP_ACCOUNT($companyId = null){
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
				$account = $client->api->accounts
					->create(array(
						'FriendlyName' =>
						$company['company_name'][0],
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

				$client = new Client($account->sid, $account->authToken);
				$domain = $client->sip->domains
					->create(
						$company['company_name'][0].".addable.sip.twilio.com",
						array(
							"friendlyName" => $company['company_name'][0],
							"auth_type" => "CREDENTIAL_LIST"
						)
					);

				$cred = $client->sip->credentialLists
					->create("SIP Credentials");

				$credUser = 100;
				$credPass = $this->randomSimpleValue(12);
				while(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $credPass)){
					$credPass = $this->randomSimpleValue(12);
				}

				$credential = $client
					->sip
					->credentialLists($cred->sid)
					->credentials
					->create($credUser, $credPass);

				$this->QUERY(array(
					'query' => '
						UPDATE company 
						SET	
							company_sip_id = :AccountSipId,
							company_sip_domain_id = :DomainSID,
							company_sip_credential_id = :CredSID,
							company_sip_status = :AccountStatus,
							company_sip_authtoken = :AccountAuthToken,
							company_sip_created_timestamp = :AccountDateCreated,
							company_sip_updated_timestamp = :AccountDateUpdated
						WHERE 
							company_id = :CompanyId',
					'replacementArray' => array(
						'AccountSipId' => $account->sid,
						'DomainSID' => $domain->sid,
						'CredSID' => $cred->sid,
						'AccountStatus' => $account_status,
						'AccountAuthToken' => $account->authToken,
						'AccountDateCreated' => $account->dateCreated->format('Y-m-d H:i:s'),
						'AccountDateUpdated' => $account->dateUpdated->format('Y-m-d H:i:s'),
						'CompanyId' => $company['company_id'][0]
					),
					'returnArray' => array()
				));

				$this->QUERY(array(
					'query' => '
						INSERT INTO credential (
							credential_list_match,
							credential_user,
							credential_pass
						) VALUES (
							:CredentialMatch,
							:CredentialUser,
							:CredentialPass
						)',
					'replacementArray' => array(
						'CredentialMatch' => $cred->sid,
						'CredentialUser' => $credUser,
						'CredentialPass' => $credPass
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

	public function RENAME_SIP_ACCOUNT($companyId = null,$newCompanyName = null){
		if(!empty($companyId)){
			$company = $this->QUERY(array(
				'query' => '
					SELECT *
					FROM company
					WHERE company_id = :CompanyId',
				'replacementArray' => array(
					'CompanyId' => $companyId
				),
				'returnArray' => array('company_id','company_name','company_sip_id','company_sip_authtoken','company_sip_domain_id')
			));

			if(!empty($company['company_id'][0])){

				$client = new Client($company['company_sip_id'][0], $company['company_sip_authtoken'][0]);
				$client->api->v2010
					->accounts($company['company_sip_id'][0])
					->update(array("FriendlyName" => $newCompanyName));

				$client->sip
					->domains($company['company_sip_domain_id'][0])
					->delete();

				$client->sip->domains
					->create(
						$newCompanyName.".addable.sip.twilio.com",
						array(
							"friendlyName" => $newCompanyName,
							"auth_type" => "CREDENTIAL_LIST"
						)
					);

				$this->QUERY(array(
					'query' => '
						UPDATE company 
						SET	
							company_name = :CompanyName
						WHERE 
							company_id = :CompanyId',
					'replacementArray' => array(
						'CompanyName' => $newCompanyName,
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

	/* Stop calls but we will still be charged for the number */
	public function SUSPEND_SIP_ACCOUNT($companyId = null,$unsuspend = false){
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

			$client = new Client($this->TWI_SID, $this->TWI_TOKEN);

			if($unsuspend === true){
				$client->api->v2010
						->accounts($company['company_sip_id'][0])
						->update(array("status" => "active"));

				$this->QUERY(array(
					'query' => 'UPDATE company
						SET	company_sip_status = "1"
						WHERE company_id = :AccountId',
					'replacementArray' => array('AccountId' => $company['company_sip_id'][0]),
					'returnArray' => array()
				));
			} else {
				$client->api->v2010
						->accounts($company['company_sip_id'][0])
						->update(array("status" => "suspended"));

				$this->QUERY(array(
					'query' => 'UPDATE company
						SET	company_sip_status = "2"
						WHERE company_id = :AccountId',
					'replacementArray' => array('AccountId' => $company['company_sip_id'][0]),
					'returnArray' => array()
				));
			}



			return true;
		} else {
			return false;
		}
	}

	public function DELETE_SIP_ACCOUNT($companyId = null){
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

			$client = new Client($this->TWI_SID, $this->TWI_TOKEN);
			$client->api->v2010
				->accounts($company['company_sip_id'][0])
				->update(array("status" => "closed"));

			$this->QUERY(array(
				'query' => 'UPDATE company
					SET	company_sip_status = "3"
					WHERE company_id = :AccountId',
				'replacementArray' => array('AccountId' => $company['company_sip_id'][0]),
				'returnArray' => array()
			));

			return true;
		} else {
			return false;
		}
	}

	public function SYNC_SIP_ACCOUNT_PHONE_NUMBERS($companyId = null){
		if(!empty($companyId)){
			/* Delete all old records */
			$this->QUERY(array(
				'query' => '
					DELETE FROM line
					WHERE line_company_match = :CompanyId',
				'replacementArray' => array(
					'CompanyId' => $companyId
				),
				'returnArray' => array()
			));

			$company = $this->QUERY(array(
				'query' => '
					SELECT *
					FROM company
					WHERE company_id = :CompanyId',
				'replacementArray' => array(
					'CompanyId' => $companyId
				),
				'returnArray' => array('company_id','company_sip_id','company_sip_authtoken')
			));

			$client = new Client($company['company_sip_id'][0],$company['company_sip_authtoken'][0]);

			if(count($client->incomingPhoneNumbers->read()) > 0){
				foreach ($client->incomingPhoneNumbers->read() as $number) {
					echo $this->QUERY(array(
						'query' => '
							INSERT INTO line (
								line.line_company_match,
								line.line_number_sid,
								line.line_number
							) VALUES (
								:CompanyId,
								:LineNumberSid,
								:LineNumber
							)
						',
						'replacementArray' => array(
							'CompanyId' => $companyId,
							'LineNumberSid' => $number->sid,
							'LineNumber' => $number->phoneNumber
						),
						'returnArray' => array()
					));
				}

				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function GET_SIP_ACCOUNT_USAGE($companyId = null,$selectedMonth = null){
		if(!empty($companyId)){

			$company = $this->QUERY(array(
				'query' => '
					SELECT *
					FROM company
					WHERE company_id = :CompanyId',
				'replacementArray' => array(
					'CompanyId' => $companyId
				),
				'returnArray' => array('company_id','company_sip_id','company_sip_authtoken')
			));

			$company = $this->QUERY(array(
				'query' => '
					SELECT *
					FROM company
					WHERE company_id = :CompanyId',
				'replacementArray' => array(
					'CompanyId' => $companyId
				),
				'returnArray' => array('company_id','company_sip_id','company_sip_authtoken')
			));

			if(!empty($selectedMonth)){

			} else {
				#$client = new Client($company['company_sip_id'][0],$company['company_sip_authtoken'][0]);
				$client = new Client('AC295b1457694ce6293469f65a3cd8a7a8','7d713e8df7de067c03c7b757a7ac2c7b');


foreach ($client->usage->records->thisMonth->read() as $record) {
    print_r($record->usage);
}

/*
 * TODO: GET CALLS TO PRINT OUT SIMILAR TO:
 * INBOUND - 01985 492125 - £1.05
 * */
	/*			$calls = $client->calls->read(array("startTime" => new \DateTime('2018-7')));
print_r($calls);*/
			}
/*
				foreach ($calls as $record) {
					print($record);
				}*/





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
