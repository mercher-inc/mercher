<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * 
 */
class Auditor  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $id;

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
	public $action;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $notes;

	/**
	 * Constructor with arguments
	 */
	public function __construct($id = NULL, $name = NULL, $action = NULL) {
		$this->id = $id;
		$this->name = $name;
		$this->action = $action;
	}


}
