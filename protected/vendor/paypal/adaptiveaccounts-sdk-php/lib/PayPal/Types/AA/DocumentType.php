<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * 
 */
class DocumentType  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $type;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $filename;

	/**
	 * Constructor with arguments
	 */
	public function __construct($type = NULL, $filename = NULL) {
		$this->type = $type;
		$this->filename = $filename;
	}


}
