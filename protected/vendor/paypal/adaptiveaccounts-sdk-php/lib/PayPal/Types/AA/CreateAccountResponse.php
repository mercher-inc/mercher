<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Valid values are: COMPLETED 
 */
class CreateAccountResponse  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ResponseEnvelope	 
	 */ 
	public $responseEnvelope;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $createAccountKey;

	/**
	 * Valid values are: COMPLETED 
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
	 * Identifies a PayPal account. Only premier and business
	 * accounts have an accountId 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountId;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ErrorData	 
	 */ 
	public $error;


}
