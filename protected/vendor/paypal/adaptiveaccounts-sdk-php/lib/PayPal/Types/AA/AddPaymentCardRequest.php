<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Identifying the PayPal account to which this request is
 * targetted to. Caller of this API has to either provided an
 * emailAddress or an accountId. 
 */
class AddPaymentCardRequest  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\RequestEnvelope	 
	 */ 
	public $requestEnvelope;

	/**
	 * Identifying the PayPal account to which this request is
	 * targetted to. Caller of this API has to either provided an
	 * emailAddress or an accountId. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $emailAddress;

	/**
	 * Identifying the PayPal account to which this request is
	 * targetted to. Caller of this API has to either provided an
	 * emailAddress or an accountId. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountId;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $createAccountKey;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\NameType	 
	 */ 
	public $nameOnCard;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $billingAddress;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var date	 
	 */ 
	public $cardOwnerDateOfBirth;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $cardNumber;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $cardType;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\CardDateType	 
	 */ 
	public $expirationDate;

	/**
	 * CVV2: Proivde only for requests where confirmationType is
	 * None (Direct request) 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $cardVerificationNumber;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\CardDateType	 
	 */ 
	public $startDate;

	/**
	 * Up to 2 digit for Switch/Maestro cards. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $issueNumber;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $confirmationType;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\WebOptionsType	 
	 */ 
	public $webOptions;

	/**
	 * Constructor with arguments
	 */
	public function __construct($requestEnvelope = NULL, $nameOnCard = NULL, $billingAddress = NULL, $cardNumber = NULL, $cardType = NULL, $confirmationType = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->nameOnCard = $nameOnCard;
		$this->billingAddress = $billingAddress;
		$this->cardNumber = $cardNumber;
		$this->cardType = $cardType;
		$this->confirmationType = $confirmationType;
	}


}
