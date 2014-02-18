<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Third party type: Individual or Business. 
 */
class BusinessEntityForThirdPartyType  
  extends PPMessage   {

	/**
	 * Third party type: Individual or Business. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $thirdPartyType;

	/**
	 * If third party is individual, name of the individual. 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\NameType	 
	 */ 
	public $name;

	/**
	 * If third party is individual, date of birth of the
	 * individual. 
	 * @access public
	 
	 	 	 	 
	 * @var date	 
	 */ 
	public $dateOfBirth;

	/**
	 * Address of third party collecting the data. 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $address;

	/**
	 * If third party is individual, profession of the individual
	 * representing third party. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $profession;

	/**
	 * Relationship with third party, of the individual or the
	 * business. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $relationshipWithThirdParty;

	/**
	 * Nature of Business, if third party is a business. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $natureOfBusiness;

	/**
	 * Name of Business, if third party is a business. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $nameOfBusiness;

	/**
	 * If third party is a business, collect the businessType.
	 * Values: Corporation, Private Company, Public Company,
	 * Partnership, Government Entity, Non-Profit Organization 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $businessType;

	/**
	 * If third party is a business, collect Incorporation ID. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $incorporationId;

	/**
	 * If third party is business, collect place of issue of
	 * Incorporation. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $incorporationCountry;

	/**
	 * If third party is business, collect place of issue of
	 * Incorporation. 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $incorporationState;


}
