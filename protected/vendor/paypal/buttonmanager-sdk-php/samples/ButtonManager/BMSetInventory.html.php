<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>PayPal ButtonManager SDK - BMSetInventory</title>
<link rel="stylesheet" href="../Common/sdk.css" />
</head>
<body>
	<div id="wrapper">
		<img src="https://devtools-paypal.com/image/bdg_payments_by_pp_2line.png">
		<div id="header">
			<h3>BMSetInventory</h3>
			<div id="apidetails">
				<p>BMSetInventory API operation is used to set the inventory level
					and inventory management features for the specified button. When
					you set the inventory level for a button, PayPal can track
					inventory, calculate the gross profit associated with sales, send
					you an alert when inventory drops below a specified quantity, and
					manage sold out conditions.</p>
			</div>
		</div>
		<form method="POST" action="BMSetInventory.php">
			<div id="request_form">
				<div class="params">
					<div class="param_name">
						HostedID* (Get hosted ID via <a href="BMCreateButton.html.php">BMCreateButton</a>)
					</div>
					<div class="param_value">
						<input type="text" name="hostedID" value="" size="50"
							maxlength="260" />
					</div>
				</div>
				<div class="note">You must track either the inventory or gross
					profit - Both values values cannot be zero at the same time</div>
				<div class="params">
					<div class="param_name">TrackInventory</div>
					<div class="param_value">
						<input type="text" name="trackInv" value="1" size="50"
							maxlength="260" />
					</div>
				</div>
				<div class="params">
					<div class="param_name">TrackGrossProfit</div>
					<div class="param_value">
						<input type="text" name="trackPnl" value="1" size="50"
							maxlength="260" />
					</div>
				</div>
				<div class="params">
					<div class="param_name">Item Quantity (mandatory if TrackInventory
						is 1 otherwise optional)</div>
					<div class="param_value">
						<input type="text" name="itemQty" value="1" size="50"
							maxlength="260" />
					</div>
				</div>
				<div class="params">
					<div class="param_name">Item Cost (mandatory if TrackGrossProfit is
						1 otherwise optional)</div>
					<div class="param_value">
						<input type="text" name="itemCost" value="2.00" size="50"
							maxlength="260" />
					</div>
				</div>

				<div class="submit">
					<input type="submit" name="BMSetInventoryBtn"
						value="BMSetInventory" /> <br />
				</div>
				<a href="../index.php">Home</a><br /> <br />
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
				<li><a href="BMButtonSearch.html.php">BMButtonSearch</a></li>

				<li><a href="BMGetButtonDetails.html.php">BMGetButtonDetails</a>
				</li>
				<li><a href="BMManageButtonStatus.html.php">BMManageButtonStatus</a>
				</li>

				<li><a href="BMGetInventory.html.php">BMGetInventory</a>
				</li>
			</ul>
		</div>
	</div>
</body>
</html>
