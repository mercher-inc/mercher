<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Month in integer format, between 1 and 12 
 */
class CardDateType  
  extends PPMessage   {

	/**
	 * Month in integer format, between 1 and 12 
	 * @access public
	 
	 	 	 	 
	 * @var integer	 
	 */ 
	public $month;

	/**
	 * Year in four digit format- YYYY 
	 * @access public
	 
	 	 	 	 
	 * @var integer	 
	 */ 
	public $year;

	/**
	 * Constructor with arguments
	 */
	public function __construct($month = NULL, $year = NULL) {
		$this->month = $month;
		$this->year = $year;
	}


}
