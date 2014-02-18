<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * PayPal Business Category. i.e., baby - 1004 
 */
class BusinessInfoType  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $businessName;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $businessAddress;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $workPhone;

	/**
	 * PayPal Business Category. i.e., baby - 1004 
	 * @access public
	 
	 	 	 	 
	 * @var integer	 
	 */ 
	public $category;

	/**
	 * Paypal Business subcategory. i.e., baby-clothing - 2027 
	 * @access public
	 
	 	 	 	 
	 * @var integer	 
	 */ 
	public $subCategory;

	/**
	 * If Category and Subcategory is specified, then this is
	 * optional. PayPal uses the industry standard Merchant
	 * Category Codes. Please refer to your Association Merchant
	 * Category Code documentation for a list of codes 
	 * @access public
	 
	 	 	 	 
	 * @var integer	 
	 */ 
	public $merchantCategoryCode;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $doingBusinessAs;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $customerServicePhone;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $customerServiceEmail;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $disputeEmail;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $webSite;

	/**
	 * Company Id: tax id, acn, abn, etc. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $companyId;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var date	 
	 */ 
	public $dateOfEstablishment;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $businessType;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $businessSubtype;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $incorporationId;

	/**
	 * Average transaction value. 
	 * @access public
	 
	 	 	 	 
	 * @var double	 
	 */ 
	public $averagePrice;

	/**
	 * Average monthly transaction value. 
	 * @access public
	 
	 	 	 	 
	 * @var double	 
	 */ 
	public $averageMonthlyVolume;

	/**
	 * Percentage of the revenue that is from online sales
	 * (0%-100%). 
	 * @access public
	 
	 	 	 	 
	 * @var integer	 
	 */ 
	public $percentageRevenueFromOnline;

	/**
	 * 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $salesVenue;

	/**
	 * Description of store front or place for sales. Only required
	 * when "OTHER" is specified for salesVenue. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $salesVenueDesc;

	/**
	 * Value Added Tax (VAT) ID number 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $vatId;

	/**
	 * Country code for country on the vat id. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $vatCountryCode;

	/**
	 * Official commercial registration location. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $commercialRegistrationLocation;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $principalPlaceOfBusinessAddress;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $registeredOfficeAddress;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $establishmentCountryCode;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $establishmentState;

	/**
	 * All the stakeholders of the company. 
     * @array
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\BusinessStakeholderType	 
	 */ 
	public $businessStakeholder;

	/**
	 * Business entity acting on behalf of Third Party. 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\BusinessEntityForThirdPartyType	 
	 */ 
	public $businessEntityForThirdParty;

	/**
	 * Values: Yes or No 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $hasDirectors;

	/**
	 * Values: Yes or No 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $hasBeneficialOwners;

	/**
	 * Values: Yes or No 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $hasThirdPartyAssociates;

	/**
	 * Constructor with arguments
	 */
	public function __construct($businessName = NULL, $businessAddress = NULL, $workPhone = NULL) {
		$this->businessName = $businessName;
		$this->businessAddress = $businessAddress;
		$this->workPhone = $workPhone;
	}


}
