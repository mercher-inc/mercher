<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * 
 */
class TupleType  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $name;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $value;

	/**
	 * Constructor with arguments
	 */
	public function __construct($name = NULL, $value = NULL) {
		$this->name = $name;
		$this->value = $value;
	}


}
