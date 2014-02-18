<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Info about PayPal user such as emailAddress, accountId,
 * firstName, lastName etc. 
 */
class UserInfoType  
  extends PPMessage   {

	/**
	 * Returns emailAddress belonging to PayPal account. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $emailAddress;

	/**
	 * Valid values are: Personal, Premier, and Business (not
	 * case-sensitive). 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountType;

	/**
	 * Identifies a PayPal account. Only premier and business
	 * accounts have an accountId 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountId;

	/**
	 * Identifies a PayPal user, like firstName, lastName. 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\NameType	 
	 */ 
	public $name;

	/**
	 * Business Name of the PayPal account holder. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $businessName;


}
