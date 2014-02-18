<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Identifying the PayPal account to which this request is
 * targetted to. Caller of this API has to either provided an
 * emailAddress or an accountId. 
 */
class SetFundingSourceConfirmedRequest  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\RequestEnvelope	 
	 */ 
	public $requestEnvelope;

	/**
	 * Identifying the PayPal account to which this request is
	 * targetted to. Caller of this API has to either provided an
	 * emailAddress or an accountId. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $emailAddress;

	/**
	 * Identifying the PayPal account to which this request is
	 * targetted to. Caller of this API has to either provided an
	 * emailAddress or an accountId. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountId;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $fundingSourceKey;

	/**
	 * Constructor with arguments
	 */
	public function __construct($requestEnvelope = NULL, $fundingSourceKey = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->fundingSourceKey = $fundingSourceKey;
	}


}
