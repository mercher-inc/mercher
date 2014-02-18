<?php 
namespace PayPal\Types\AA;
use PayPal\Core\PPMessage;  
/**
 * 
 */
class UpdateComplianceStatusRequest  
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
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AuditeeInfoType	 
	 */ 
	public $auditeeInfo;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AuditorList	 
	 */ 
	public $auditorList;

	/**
	 * 
	 * @access public
	 
	 	 	 	 
	 * @var PayPal\Types\AA\AuditDetailsType	 
	 */ 
	public $auditDetails;

	/**
	 * Constructor with arguments
	 */
	public function __construct($requestEnvelope = NULL, $auditeeInfo = NULL, $auditDetails = NULL) {
		$this->requestEnvelope = $requestEnvelope;
		$this->auditeeInfo = $auditeeInfo;
		$this->auditDetails = $auditDetails;
	}


}
