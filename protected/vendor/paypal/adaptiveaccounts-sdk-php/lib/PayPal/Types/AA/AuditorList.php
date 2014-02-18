<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * 
 */
class AuditorList  
  extends PPMessage   {

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\Auditor	 
	 */ 
	public $auditor;

	/**
	 * Constructor with arguments
	 */
	public function __construct($auditor = NULL) {
		$this->auditor = $auditor;
	}


}
