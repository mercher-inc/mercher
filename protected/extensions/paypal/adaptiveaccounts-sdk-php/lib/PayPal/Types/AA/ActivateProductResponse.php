<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Valid values are: SUCCESS, FAILED 
 */
class ActivateProductResponse  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ResponseEnvelope	 
	 */ 
	public $responseEnvelope;

	/**
	 * Valid values are: SUCCESS, FAILED 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $execStatus;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $productActivationErrors;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ErrorData	 
	 */ 
	public $error;


}
