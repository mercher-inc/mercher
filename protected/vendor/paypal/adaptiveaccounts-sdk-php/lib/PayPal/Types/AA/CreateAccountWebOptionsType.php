<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Ask end-user to also initiate confirmation of their mobile
 * phone. This number must be supplied by the API caller (using
 * mobilePhoneNumber) Default=false. 
 */
class CreateAccountWebOptionsType  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $returnUrl;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var boolean	 
	 */ 
	public $showAddCreditCard;

	/**
	 * Ask end-user to also initiate confirmation of their mobile
	 * phone. This number must be supplied by the API caller (using
	 * mobilePhoneNumber) Default=false. 
	 * @access public
	 
	 	 	 	 
	 * @var boolean	 
	 */ 
	public $showMobileConfirm;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $returnUrlDescription;

	/**
	 * If provided, end user will go through a single page sign-up
	 * flow on a Mini Browser. If not provided, flow defaults to
	 * the Multi-page flow that is full size. 
	 * @access public
	 
	 	 	 	 
	 * @var boolean	 
	 */ 
	public $useMiniBrowser;

	/**
	 * Indicates the frequency of the reminder emails sent to the
	 * PayPal user after CreateAccount. Used only when
	 * registrationType is Web. Valid values: DEFAULT: All reminder
	 * emails will be sent (same behaviour as when this paramter is
	 * not present) NONE: No reminder emails will be sent (More
	 * values to be added in future) 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $reminderEmailFrequency;

	/**
	 * Indicates if the Return URL is used to confirm email. On
	 * accessing the Return URL successfully, confirm the email if
	 * this parameter is true, otherwise, do not confirm the email.
	 * Used only when registrationType is Web. Valid values (mixed
	 * case): true: Append the Email Confirmation Code to the
	 * Return URL. false: Do not append the Email Confirmation Code
	 * to the Return URL. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $confirmEmail;


}
