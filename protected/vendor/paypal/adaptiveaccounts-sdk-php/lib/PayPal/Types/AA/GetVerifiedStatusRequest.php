<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Deprecated, use accountIdentifier.emailAddress instead 
 */
class GetVerifiedStatusRequest  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\RequestEnvelope	 
	 */ 
	public $requestEnvelope;

	/**
	 * Deprecated, use accountIdentifier.emailAddress instead 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $emailAddress;

	/**
	 * Identifies a PayPal account to which this request is
	 * targeted. Caller of this API has to provide ONLY one of
	 * these inputs: emailAddress, accountId or mobilePhoneNumber. 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AccountIdentifierType	 
	 */ 
	public $accountIdentifier;

	/**
	 * matchCriteria determines which field(s) in addition to
	 * emailAddress is used to locate the account. Currently, we
	 * support matchCriteria of 'NAME' and 'NONE'. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $matchCriteria;

	/**
	 * Required if matchCriteria is NAME Optional if matchCriteria
	 * is NONE 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $firstName;

	/**
	 * Required if matchCriteria is NAME Optional if matchCriteria
	 * is NONE 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $lastName;

	/**
	 * Constructor with arguments
	 */
	public function __construct($requestEnvelope = NULL, $matchCriteria = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->matchCriteria = $matchCriteria;
	}


}
