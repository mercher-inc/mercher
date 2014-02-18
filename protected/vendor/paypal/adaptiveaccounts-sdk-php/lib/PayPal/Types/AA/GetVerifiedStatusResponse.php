<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Returned values are: VERIFIED|UNVERIFIED. 
 */
class GetVerifiedStatusResponse  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ResponseEnvelope	 
	 */ 
	public $responseEnvelope;

	/**
	 * Returned values are: VERIFIED|UNVERIFIED. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountStatus;

	/**
	 * Returns countryCode belonging to PayPal account. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $countryCode;

	/**
	 * Info about PayPal user such as emailAddress, accountId,
	 * firstName, lastName etc. 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\UserInfoType	 
	 */ 
	public $userInfo;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ErrorData	 
	 */ 
	public $error;


}
