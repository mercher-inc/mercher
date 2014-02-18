<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>PayPal ButtonManager SDK - BMButtonSearch</title>
<link rel="stylesheet" href="../Common/sdk.css" />
</head>
<body>
	<div id="wrapper">
		<img src="https://devtools-paypal.com/image/bdg_payments_by_pp_2line.png">
		<div id="header">
			<h3>BMButtonSearch</h3>
			<div id="apidetails">Used to search the buttons created</div>
		</div>
		<form method="POST" action="BMButtonSearch.php">
			<div id="request_form">
				<div class="params">
					<div class="param_name">Start date</div>
					<div class="param_value">
						<input type="text" name="startDate"
							value=<?php echo date(DATE_ATOM)?> size="50" maxlength="260" />
					</div>
				</div>
				<div class="params">
					<div class="param_name">End date (Optional)</div>
					<div class="param_value">
						<input type="text" name="endDate" value="" size="50" />
					</div>
				</div>
				<div class="submit">
					<input type="submit" name="BMButtonSearchBtn"
						value="BMButtonSearch" /> <br />
				</div>
				<a href="../index.php">Home</a>

			</div>
		</form>

		<div id="relatedcalls">
			See also
			<ul>
				<!--
<li><a href="BMUpdateButton">BMUpdateButton</a>
</li>
-->
				<li><a href="BMCreateButton.html.php">BMCreateButton</a>
				</li>
				<li><a href="BMGetButtonDetails.html.php">BMGetButtonDetails</a>
				</li>
				<li><a href="BMManageButtonStatus.html.php">BMManageButtonStatus</a>
				</li>
				<li><a href="BMSetInventory.html.php">BMSetInventory</a>
				</li>
				<li><a href="BMGetInventory.html.php">BMGetInventory</a>
				</li>
			</ul>
		</div>
	</div>
</body>
</html>
