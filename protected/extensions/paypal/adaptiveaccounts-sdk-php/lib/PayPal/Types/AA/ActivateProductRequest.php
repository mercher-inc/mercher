<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * This operation is for internal purposes developed for a POC.
 * 
 */
class ActivateProductRequest  
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
	 * these inputs: emailAddress or accountId. 
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
