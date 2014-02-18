<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Valid values are: Personal, Premier, and Business. Flag="2"
 * corresponds to java.util.regex.Pattern.CASE_INSENSITIVE,
 * meaning the strings are not case-sensitive 
 */
class CreateAccountRequest  
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
	 
	 	 	 	 
	 * @var PayPal\Types\Common\ClientDetailsType	 
	 */ 
	public $clientDetails;

	/**
	 * Valid values are: Personal, Premier, and Business. Flag="2"
	 * corresponds to java.util.regex.Pattern.CASE_INSENSITIVE,
	 * meaning the strings are not case-sensitive 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $accountType;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\NameType	 
	 */ 
	public $name;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var date	 
	 */ 
	public $dateOfBirth;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $address;

	/**
	 * Must provide at least one of contactPhoneNumber,
	 * homePhoneNumber, or mobilePhoneNumber 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $contactPhoneNumber;

	/**
	 * Must provide at least one of contactPhoneNumber,
	 * homePhoneNumber, or mobilePhoneNumber 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $homePhoneNumber;

	/**
	 * Must provide at least one of contactPhoneNumber,
	 * homePhoneNumber, or mobilePhoneNumber 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $mobilePhoneNumber;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $currencyCode;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $citizenshipCountryCode;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $preferredLanguageCode;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $notificationURL;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $emailAddress;

	/**
	 * Valid values are: Mobile and Web. Mobile: Returns a key to
	 * complete the registration. Web: Returns a URL to complete
	 * the registration. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $registrationType;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\CreateAccountWebOptionsType	 
	 */ 
	public $createAccountWebOptions;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var boolean	 
	 */ 
	public $suppressWelcomeEmail;

	/**
	 * Set to true if you want this account to undergo extra
	 * vetting by PayPal before becoming usable. 
	 * @access public
	 
	 	 	 	 
	 * @var boolean	 
	 */ 
	public $performExtraVettingOnThisAccount;

	/**
	 * tax id, ssn, itin, pan, cpf, acn, abn, etc. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $taxId;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $partnerField1;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $partnerField2;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $partnerField3;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $partnerField4;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $partnerField5;

	/**
	 * Required for business account creation 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\BusinessInfoType	 
	 */ 
	public $businessInfo;

	/**
	 * An ID representing a unique value, such as SSN, TIN, SIN,
	 * TaxID, etc. generally issued by a Government. Currently
	 * supports only SIN for Canada. 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\GovernmentIDPair	 
	 */ 
	public $governmentId;

	/**
	 * Account Holder's profession, values such as: Accountant,
	 * Actuary, Advocate, Architect, Business Owner, Doctor,
	 * Dentist, Engineer, Financial Analyst, Lawyer, Librarian,
	 * Nurse, Pilot, Pharmacist, Physician, Physicial Therapist,
	 * Professor, Psychologist, Scientist, Teacher, Webmaster,
	 * Writer, Student, Other 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $profession;

	/**
	 * Account Holder's occupation. For business accounts only.
	 * Values: Executive, President, Vice President, Director,
	 * Manager, Staff, Other. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $occupation;

	/**
	 * Account Holder's functional area. For business accounts
	 * only. Values: Finance, Operations, Technology, Sales,
	 * Marketing, Other 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $functionalArea;

	/**
	 * Boolean value, indicates whether user has agreed for a
	 * particular agreement or not. 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\LegalAgreementType	 
	 */ 
	public $legalAgreement;

	/**
	 * Expected Value: 0|1|2|3|4|5 according to the description
	 * below: 0 - "Send payments for goods and/or services to
	 * domestic merchants" 1 - "Send payments for goods and/or
	 * services to cross-border merchants" 2 - "Send payments for
	 * goods and/or services to domestic and cross-border
	 * merchants" 3 - "Receive payments for goods and/or services
	 * from domestic buyers" 4 - "Receive payments for goods and/or
	 * services from cross-border buyers" 5 - "Receive payments for
	 * goods and/or service from domestic/cross-border buyers" 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $purposeOfAccount;

	/**
	 * Constructor with arguments
	 */
	public function __construct($requestEnvelope = NULL, $name = NULL, $address = NULL, $preferredLanguageCode = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->name = $name;
		$this->address = $address;
		$this->preferredLanguageCode = $preferredLanguageCode;
	}


}
