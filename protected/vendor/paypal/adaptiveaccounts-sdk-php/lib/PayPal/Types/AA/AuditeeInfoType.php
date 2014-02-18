<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * 
 */
class AuditeeInfoType  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AccountIdentifierType	 
	 */ 
	public $accountIdentifier;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\DocumentType	 
	 */ 
	public $document;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\TupleType	 
	 */ 
	public $data;

	/**
	 * Constructor with arguments
	 */
	public function __construct($accountIdentifier = NULL) {
		$this->accountIdentifier = $accountIdentifier;
	}


}
