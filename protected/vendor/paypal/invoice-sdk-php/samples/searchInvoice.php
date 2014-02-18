<?php
use PayPal\Service\InvoiceService;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\PT\DateRangeType;
use PayPal\Types\PT\SearchInvoicesRequest;
use PayPal\Types\PT\SearchParametersType;
use PayPal\Auth\PPSignatureCredential;
use PayPal\Auth\PPTokenAuthorization;

require_once('PPBootStrap.php');
session_start();

/*
 *  # SearchInvoices API
 Use the SearchInvoice API operation to search an invoice.
 This sample code uses Invoice PHP SDK to make API call
 */
?>
<html>
<head>
	<title>PayPal Invoicing - SearchInvoices Sample API Page</title>
	<link rel="stylesheet" type="text/css" href="sdk.css"/>
	<script type="text/javascript" src="sdk.js"></script>
</head>
<body>
		<img src="https://devtools-paypal.com/image/bdg_payments_by_pp_2line.png">
<h2>SearchInvoices API Test Page</h2>
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	/*
	 *  ##SearchInvoicesRequest
		 Use the SearchInvoiceRequest message to search an invoice.

		 The code for the language in which errors are returned, which must be
		 en_US.
	 */
	$requestEnvelope = new RequestEnvelope("en_US");
	$merchantEmail= $_POST['merchantEmail'];
	$page = $_POST['pageNumber'];
	$pageSize = $_POST['pageSize'];

	$parameters = new SearchParametersType();
	$parameters->businessName = $_POST['businessName'];
	
	/*
	 *  Currency used for lower and upper amounts. It is required when you
		 specify lowerAmount or upperAmount.
	 */
	$parameters->currencyCode = $_POST['currencyCode'];
	$parameters->email = $_POST['email'];
	$parameters->recipientName = $_POST['recipientName'];
	$parameters->invoiceNumber = $_POST['invoiceNumber'];
	foreach($_POST['status'] as $status) {
		if($status != '')
			$parameters->status[] = $status;
	}
	$parameters->lowerAmount = $_POST['lowerAmount'];
	
	/*
	 *  Invoice amount search. It specifies the smallest amount to be
		 returned. If you pass a value for this field, you must also pass a
		 currencyCode value.
	 */
	$parameters->upperAmount = $_POST['upperAmount'];
	$parameters->memo = $_POST['memo'];
	$parameters->origin = $_POST['origin'];
	if($_POST['invoiceDateStart'] != '' || $_POST['invoiceDateEnd'] != '') {
		$dateRange = new DateRangeType();
		$dateRange->startDate = $_POST['invoiceDateStart'];
		$dateRange->endDate = $_POST['invoiceDateEnd'];
		$parameters->invoiceDate = $dateRange;
	}
	if($_POST['dueDateStart'] != '' || $_POST['dueDateEnd'] != '') {
		$dateRange = new DateRangeType();
		$dateRange->startDate = $_POST['dueDateStart'];
		$dateRange->endDate = $_POST['dueDateEnd'];
		$parameters->dueDate = $dateRange;
	}
	if($_POST['paymentDateStart'] != '' || $_POST['paymentDateEnd'] != '') {
		$dateRange = new DateRangeType();
		$dateRange->startDate = $_POST['paymentDateStart'];
		$dateRange->endDate = $_POST['paymentDateEnd'];
		$parameters->paymentDate = $dateRange;
	}
	if($_POST['creationDateStart'] != '' || $_POST['creationDateEnd'] != '') {
		$dateRange = new DateRangeType();
		$dateRange->startDate = $_POST['creationDateStart'];
		$dateRange->endDate = $_POST['creationDateEnd'];
		$parameters->creationDate = $dateRange;
	}

	/*
	 *  SearchInvoicesRequest which takes mandatory params:
		
		 * `Request Envelope` - Information common to each API operation, such
		 as the language in which an error message is returned.
		 * `Merchant Email` - Email address of invoice creator.
		 * `SearchParameters` - Parameters constraining the search.
		 * `Page` - Page number of result set, starting with 1.
		 * `Page Size` - Number of results per page, between 1 and 100.
	 */
	$searchInvoicesRequest = new SearchInvoicesRequest($requestEnvelope, $merchantEmail, $parameters, $page, $pageSize);

	/*
	 *  ## Creating service wrapper object
		 Creating service wrapper object to make API call and loading
		 Configuration::getAcctAndConfig() returns array that contains credential and config parameters
    */
	$invoiceService = new InvoiceService(Configuration::getAcctAndConfig());
	// required in third party permissioning
	if(($_POST['accessToken']!= null) && ($_POST['tokenSecret'] != null)) {
		$cred = new PPSignatureCredential("jb-us-seller_api1.paypal.com", "WX4WTU3S8MY44S7F", "AFcWxV21C7fd0v3bYYYRCpSSRl31A7yDhhsPUU2XhtMoZXsWHFxu-RWy");
	    $cred->setThirdPartyAuthorization(new PPTokenAuthorization($_POST['accessToken'], $_POST['tokenSecret']));
	}
	try {

		/*
		 *  ## Making API call
			 Invoke the appropriate method corresponding to API in service
			 wrapper object
		 */
		if(($_POST['accessToken']!= null) && ($_POST['tokenSecret'] != null)) {
			$searchInvoicesResponse = $invoiceService->SearchInvoices($searchInvoicesRequest, $cred);
		}
		else{
			$searchInvoicesResponse = $invoiceService->SearchInvoices($searchInvoicesRequest);
		}
	} catch (Exception $ex) {
		require_once 'error.php';
		exit;
	}	
	echo "<table>";
	echo "<tr><td>Ack :</td><td><div id='Ack'>". $searchInvoicesResponse->responseEnvelope->ack ."</div> </td></tr>";
	echo "</table>";	
	require 'ShowAllResponse.php';
	echo "<pre>";
	var_dump($searchInvoicesResponse);
	echo "</pre>";
} else {
?>
<form method="POST">
<div id="apidetails">The SearchInvoice API operation is used to search for invoices that match input criteria.</div>
<div class="params">
<div class="param_name">Merchant Email</div>
<div class="param_value"><input type="text" name="merchantEmail" value="jb-us-seller@paypal.com"
	size="50" maxlength="260" /></div>
<!-- Search criteria -->
<div class="param_name">Email</div>
<div class="param_value">
	<input type="text" name="email" value="sender@yahoo.com" />
</div>
<div class="param_name">Recipient name</div>
<div class="param_value">
	<input type="text" name="recipientName" value="" />
</div>
<div class="param_name">Business name</div>
<div class="param_value">
	<input type="text" name="businessName" value="" />
</div>
<div class="param_name">Invoice number</div>
<div class="param_value">
	<input type="text" name="invoiceNumber" value="" />
</div>
<div class="param_name">Status (Provide upto 10 different status types)</div>
<div class="param_value">
	<select name="status[]">
		<option value="">--Select a value--</option>
		<option value="Draft">Draft</option>
		<option value="Sent">Sent</option>
		<option value="Paid">Paid</option>
		<option value="MarkedAsPaid">MarkedAsPaid</option>
		<option value="Canceled">Canceled</option>
	</select>
	 (Or)
	<select name="status[]">
		<option value="">--Select a value--</option>
		<option value="Draft">Draft</option>
		<option value="Sent">Sent</option>
		<option value="Paid">Paid</option>
		<option value="MarkedAsPaid">MarkedAsPaid</option>
		<option value="Canceled">Canceled</option>
	</select>
	 (Or)
	<select name="status[]">
		<option value="">--Select a value--</option>
		<option value="Draft">Draft</option>
		<option value="Sent">Sent</option>
		<option value="Paid">Paid</option>
		<option value="MarkedAsPaid">MarkedAsPaid</option>
		<option value="Canceled">Canceled</option>
	</select>
</div>
<div class="param_name">Lowest invoice amount to match</div>
<div class="param_value">
	<input type="text" name="lowerAmount" value="1.0" />
</div>
<div class="param_name">Highest invoice amount to match</div>
<div class="param_value">
	<input type="text" name="upperAmount" value="100.0" />
</div>
<div class="param_name">Currency code</div>
<div class="param_value">
	<input type="text" name="currencyCode" value="USD" />
</div>
<div class="param_name">Memo</div>
<div class="param_value">
	<input type="text" name="memo" value="" />
</div>
<div class="param_name">Invoice origin</div>
<div class="param_value">
	<select name="origin">
		<option value="">--Select a value--</option>
		<option value="Web">Web</option>
		<option value="API">API</option>
	</select>
</div>
<div class="param_name">Invoice date ( Range: From &amp; To)</div>
<div class="param_value">
	<input type="text" name="invoiceDateStart" value="2011-12-20T02:56:08" />
	<input type="text" name="invoiceDateEnd" value="2011-12-25T02:56:08" />
</div>
<div class="param_name">Invoice due date ( Range: From &amp; To)</div>
<div class="param_value">
	<input type="text" name="dueDateStart" value="" />
	<input type="text" name="dueDateEnd" value="" />
</div>
<div class="param_name">Payment date ( Range: From &amp; To)</div>
<div class="param_value">
	<input type="text" name="paymentDateStart" value="" />
	<input type="text" name="paymentDateEnd" value="" />
</div>
<div class="param_name">Invoice creation date ( Range: From &amp; To)</div>
<div class="param_value">
	<input type="text" name="creationDateStart" value="" />
	<input type="text" name="creationDateEnd" value="" />
</div>
<br>
<div class="param_name">Page Number</div>
<div class="param_value"><input type="text" name="pageNumber"
	value="1" size="50" maxlength="260" /></div>
<div class="param_name">pageSize</div>
<div class="param_value"><input type="text" name="pageSize"
	value="2" size="50" maxlength="260" /></div>

</div>
<?php
include('permissions.php');
?>
<input type="submit" name="SearchInvoiceBtn" value="Search Invoices" />
</form>
<?php
}
?>
<br/><br/><a href="index.php" >Home</a>
</body>
</html>