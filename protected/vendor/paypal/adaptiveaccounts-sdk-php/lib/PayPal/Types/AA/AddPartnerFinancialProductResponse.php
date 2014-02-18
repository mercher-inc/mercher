<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Valid values are: CARD_ADDED 
 */
class AddPartnerFinancialProductResponse  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ResponseEnvelope	 
	 */ 
	public $responseEnvelope;

	/**
	 * Valid values are: CARD_ADDED 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $execStatus;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ErrorData	 
	 */ 
	public $error;


}
