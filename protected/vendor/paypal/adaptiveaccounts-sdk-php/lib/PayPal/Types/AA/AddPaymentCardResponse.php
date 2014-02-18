<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Valid values are: FUNDING_SOURCE_ADDED,
 * WEB_URL_VERIFICATION_NEEDED 
 */
class AddPaymentCardResponse  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ResponseEnvelope	 
	 */ 
	public $responseEnvelope;

	/**
	 * Valid values are: FUNDING_SOURCE_ADDED,
	 * WEB_URL_VERIFICATION_NEEDED 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $execStatus;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $redirectURL;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $fundingSourceKey;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ErrorData	 
	 */ 
	public $error;


}
