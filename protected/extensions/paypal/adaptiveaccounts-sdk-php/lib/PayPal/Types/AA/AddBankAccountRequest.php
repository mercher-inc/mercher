<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Identifying the PayPal account to which this request is
 * targetted to. Caller of this API has to either provided an
 * emailAddress or an accountId. 
 */
class AddBankAccountRequest  
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
	 * Country code for the bank 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $bankCountryCode;

	/**
	 * The defualt value is UNKNOWN. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $bankName;

	/**
	 * Bank routing or transit number 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $routingNumber;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $bankAccountType;

	/**
	 * Basic Bank Account Number (BBAN) 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $bankAccountNumber;

	/**
	 * International Bank Account Number (IBAN) 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $iban;

	/**
	 * CLABE represents the bank information for countries like
	 * Mexico 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $clabe;

	/**
	 * Bank/State/Branch number 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $bsbNumber;

	/**
	 * Branch location 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $branchLocation;

	/**
	 * Branch sort code. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $sortCode;

	/**
	 * Bank transit number 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $bankTransitNumber;

	/**
	 * Institution number 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $institutionNumber;

	/**
	 * Branch code 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $branchCode;

	/**
	 * For Brazil Agency Number 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $agencyNumber;

	/**
	 * Bank code 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $bankCode;

	/**
	 * RIB key 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $ribKey;

	/**
	 * control digits 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $controlDigit;

	/**
	 * Tax id type of CNPJ or CPF, only supported for Brazil. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $taxIdType;

	/**
	 * Tax id number for Brazil. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $taxIdNumber;

	/**
	 * Date of birth of the account holder 
	 * @access public
	 
	 	 	 	 
	 * @var date	 
	 */ 
	public $accountHolderDateOfBirth;

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
	public function __construct($requestEnvelope = NULL, $bankCountryCode = NULL, $confirmationType = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->bankCountryCode = $bankCountryCode;
		$this->confirmationType = $confirmationType;
	}


}
