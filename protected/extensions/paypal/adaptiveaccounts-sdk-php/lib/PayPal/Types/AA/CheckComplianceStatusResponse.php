<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Returned values are: ALLOW|DENY 
 */
class CheckComplianceStatusResponse  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ResponseEnvelope	 
	 */ 
	public $responseEnvelope;

	/**
	 * Returned values are: ALLOW|DENY 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $execStatus;

	/**
	 * Returned values are: CLIENT_NOT_SUPPORTED,
	 * COUNTRY_NOT_SUPPORTED, VERIFICATION_NOT_COMPLETED,
	 * DOCUMENTS_UNDER_REVIEW, DENIED 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $denialReason;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ErrorData	 
	 */ 
	public $error;


}
