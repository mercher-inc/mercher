<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * 
 */
class AuditDetailsType  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $status;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $level;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $method;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $reason;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\TupleType	 
	 */ 
	public $data;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $policyVersion;

	/**
	 * Constructor with arguments
	 */
	public function __construct($status = NULL, $level = NULL, $method = NULL, $reason = NULL) {
		$this->status = $status;
		$this->level = $level;
		$this->method = $method;
		$this->reason = $reason;
	}


}
