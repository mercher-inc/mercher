<?php 
namespace PayPal\Service;
use PayPal\Core\PPMessage;
use PayPal\Core\PPBaseService;
use PayPal\Core\PPUtils;
use PayPal\Types\Perm\RequestPermissionsResponse;
use PayPal\Types\Perm\GetAccessTokenResponse;
use PayPal\Types\Perm\GetPermissionsResponse;
use PayPal\Types\Perm\CancelPermissionsResponse;
use PayPal\Types\Perm\GetBasicPersonalDataResponse;
use PayPal\Types\Perm\GetAdvancedPersonalDataResponse;

/**
 * AUTO GENERATED code for Permissions
 */
class PermissionsService extends PPBaseService {

	// Service Version
	private static $SERVICE_VERSION = "";

	// Service Name
	private static $SERVICE_NAME = "Permissions";

    // SDK Name
	protected static $SDK_NAME = "permissions-php-sdk";
	
	// SDK Version
	protected static $SDK_VERSION = "3.6.106";

    /**
    * @param $config - Dynamic config map. This takes the higher precedence if config file is also present.
    *
    */
	public function __construct($config = null) {
		parent::__construct(self::$SERVICE_NAME, 'NV', array('PayPal\Handler\PPPlatformServiceHandler'), $config);
        parent::$SDK_NAME    = self::$SDK_NAME ;
        parent::$SDK_VERSION = self::$SDK_VERSION;
	}


	/**
	 * Service Call: RequestPermissions
	 * @param RequestPermissionsRequest $requestPermissionsRequest
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 * @return Types\Perm\RequestPermissionsResponse
	 * @throws APIException
	 */
	public function RequestPermissions($requestPermissionsRequest, $apiCredential = NULL) {
		$ret = new RequestPermissionsResponse();
		$resp = $this->call('Permissions', 'RequestPermissions', $requestPermissionsRequest, $apiCredential);
		$ret->init(PPUtils::nvpToMap($resp));
		return $ret;
	}
	 

	/**
	 * Service Call: GetAccessToken
	 * @param GetAccessTokenRequest $getAccessTokenRequest
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 * @return Types\Perm\GetAccessTokenResponse
	 * @throws APIException
	 */
	public function GetAccessToken($getAccessTokenRequest, $apiCredential = NULL) {
		$ret = new GetAccessTokenResponse();
		$resp = $this->call('Permissions', 'GetAccessToken', $getAccessTokenRequest, $apiCredential);
		$ret->init(PPUtils::nvpToMap($resp));
		return $ret;
	}
	 

	/**
	 * Service Call: GetPermissions
	 * @param GetPermissionsRequest $getPermissionsRequest
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 * @return Types\Perm\GetPermissionsResponse
	 * @throws APIException
	 */
	public function GetPermissions($getPermissionsRequest, $apiCredential = NULL) {
		$ret = new GetPermissionsResponse();
		$resp = $this->call('Permissions', 'GetPermissions', $getPermissionsRequest, $apiCredential);
		$ret->init(PPUtils::nvpToMap($resp));
		return $ret;
	}
	 

	/**
	 * Service Call: CancelPermissions
	 * @param CancelPermissionsRequest $cancelPermissionsRequest
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 * @return Types\Perm\CancelPermissionsResponse
	 * @throws APIException
	 */
	public function CancelPermissions($cancelPermissionsRequest, $apiCredential = NULL) {
		$ret = new CancelPermissionsResponse();
		$resp = $this->call('Permissions', 'CancelPermissions', $cancelPermissionsRequest, $apiCredential);
		$ret->init(PPUtils::nvpToMap($resp));
		return $ret;
	}
	 

	/**
	 * Service Call: GetBasicPersonalData
	 * @param GetBasicPersonalDataRequest $getBasicPersonalDataRequest
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 * @return Types\Perm\GetBasicPersonalDataResponse
	 * @throws APIException
	 */
	public function GetBasicPersonalData($getBasicPersonalDataRequest, $apiCredential = NULL) {
		$ret = new GetBasicPersonalDataResponse();
		$resp = $this->call('Permissions', 'GetBasicPersonalData', $getBasicPersonalDataRequest, $apiCredential);
		$ret->init(PPUtils::nvpToMap($resp));
		return $ret;
	}
	 

	/**
	 * Service Call: GetAdvancedPersonalData
	 * @param GetAdvancedPersonalDataRequest $getAdvancedPersonalDataRequest
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 * @return Types\Perm\GetAdvancedPersonalDataResponse
	 * @throws APIException
	 */
	public function GetAdvancedPersonalData($getAdvancedPersonalDataRequest, $apiCredential = NULL) {
		$ret = new GetAdvancedPersonalDataResponse();
		$resp = $this->call('Permissions', 'GetAdvancedPersonalData', $getAdvancedPersonalDataRequest, $apiCredential);
		$ret->init(PPUtils::nvpToMap($resp));
		return $ret;
	}
	 
}