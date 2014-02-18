<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * This not considered when
 * financialProductCategory=PRE_PAID_CARD 
 */
class AddPartnerFinancialProductRequest  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\Common\RequestEnvelope	 
	 */ 
	public $requestEnvelope;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AccountIdentifierType	 
	 */ 
	public $accountIdentifier;

	/**
	 * This not considered when
	 * financialProductCategory=PRE_PAID_CARD 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\NameType	 
	 */ 
	public $nameOnCard;

	/**
	 * This not considered when
	 * financialProductCategory=PRE_PAID_CARD 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $billingAddress;

	/**
	 * This not considered when
	 * financialProductCategory=PRE_PAID_CARD 
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
	 * Identify the kind of PayPal financial product. Possible
	 * value is : PRE_PAID_CARD 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $financialProductCategory;

	/**
	 * expirationDate is mandatory when financialProductCategoy =
	 * PRE_PAID_CARD 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\CardDateType	 
	 */ 
	public $expirationDate;

	/**
	 * This not considered when
	 * financialProductCategory=PRE_PAID_CARD 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $cardVerificationNumber;

	/**
	 * This not considered when
	 * financialProductCategory=PRE_PAID_CARD 
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
	 * Constructor with arguments
	 */
	public function __construct($requestEnvelope = NULL, $accountIdentifier = NULL, $cardNumber = NULL, $financialProductCategory = NULL, $expirationDate = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->accountIdentifier = $accountIdentifier;
		$this->cardNumber = $cardNumber;
		$this->financialProductCategory = $financialProductCategory;
		$this->expirationDate = $expirationDate;
	}


}
