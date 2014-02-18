<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Identifies a PayPal account to which this request is
 * targeted. Caller of this API has to provide ONLY one of
 * these inputs: emailAddress, accountId or mobilePhoneNumber. 
 */
class CheckComplianceStatusRequest  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\RequestEnvelope	 
	 */ 
	public $requestEnvelope;

	/**
	 * Identifies a PayPal account to which this request is
	 * targeted. Caller of this API has to provide ONLY one of
	 * these inputs: emailAddress, accountId or mobilePhoneNumber. 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AccountIdentifierType	 
	 */ 
	public $accountIdentifier;

	/**
	 * Constructor with arguments
	 */
	public function __construct($requestEnvelope = NULL, $accountIdentifier = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->accountIdentifier = $accountIdentifier;
	}


}
