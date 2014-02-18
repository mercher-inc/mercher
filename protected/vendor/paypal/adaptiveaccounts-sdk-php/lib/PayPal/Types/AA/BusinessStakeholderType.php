<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * Info about Stakeholders such as partner, beneficial, owner,
 * director etc. 
 */
class BusinessStakeholderType  
  extends PPMessage   {

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string 	 
	 */ 
	public $role;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\NameType	 
	 */ 
	public $name;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $fullLegalName;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AddressType	 
	 */ 
	public $address;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var date	 
	 */ 
	public $dateOfBirth;

	/**
	 * Occupation of the business stakeholder. Values such as:
	 * Accountant, Actuary, Advocate, Architect, Business Owner,
	 * Doctor, Dentist, Engineer, Financial Analyst, Lawyer,
	 * Librarian, Nurse, Pilot, Pharmacist, Physician, Physicial
	 * Therapist, Professor, Psychologist, Scientist, Teacher,
	 * Webmaster, Writer, Student, Other 
	 * @access public
	 
	 	 	 	 
	 * @var string	 
	 */ 
	public $occupation;

	/**
	 * Constructor with arguments
	 */
	public function __construct($role = NULL) {
		$this->role = $role;
	}


}
