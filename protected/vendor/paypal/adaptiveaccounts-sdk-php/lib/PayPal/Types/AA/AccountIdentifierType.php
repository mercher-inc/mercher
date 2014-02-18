<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Identifies a PayPal account to which this request is
 * targeted. Caller of this API has to provide ONLY one of
 * these inputs: emailAddress, accountId or phoneNumber. 
 */
class AccountIdentifierType  
  extends PPMessage   {

	/**
	 * Identifies the PayPal account based on the emailAddress. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $emailAddress;

	/**
	 * Identifies the PayPal account based on the phoneNumber. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $mobilePhoneNumber;

	/**
	 * Identifies the PayPal account based on the accountId. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountId;

	/**
	 * Constructor with arguments
	 */
	public function __construct($emailAddress = NULL, $mobilePhoneNumber = NULL, $accountId = NULL) {
		$this->emailAddress = $emailAddress;
		$this->mobilePhoneNumber = $mobilePhoneNumber;
		$this->accountId = $accountId;
	}


}
