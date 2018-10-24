<?php
// require('inventory.css');
// include 'inventory.css';
	class View {
		public $stylesheet = 'inventory.css';
		private $title = 'Home';

		// public function __construct() {
		// 	//$stylesheet = 'inventory.css';
		// }

		// public function __destruct() {
		
		// }

// rewrite this?

		public function presentInventory($devices, $message) {
			$stylesheet = 'inventory.css';
			$html = "<div class='header'><img src='logo.png' alt='logo'/><h1>Technology Services Inventory System</h1></div>\n";

			// This appends any sort of notification messages onto the screen
			if($message){
				$html .= "<p class='message'>$message</p>\n";
			}

			$html .= "<style>
						input[type=text] {
	    				width: 130px;
	    				box-sizing: border-box;
	    				border: 2px solid #ccc;
	    				border-radius: 4px;
	    				font-size: 16px;
	    				background-color: white;
	    				background-repeat: no-repeat;
	    				-webkit-transition: width 0.4s ease-in-out;
	    				transition: width 0.4s ease-in-out;
						}
						input[type=text]:focus {
	    				width: 75%;
						}
						</style>
	                    <form action='index.php' method='post'><input type='hidden' name='action' value='searchDevices'/><input type='text' name='searchString' value=''placeholder='Search here..' ><input type='submit' value='Search Devices'></form>";

			$html .= "<form action='index.php' method='post'><input type='hidden' name='action' value='presentAddDevice'/><input type='submit' value='Add Device'></form>";

			$html .= "<form action='index.php' method='post'><input type='hidden' name='action' value='presentAddUser'/><input type='submit' value='Add User'></form>";

			// $html .= "<a class='userButton' href=index.php?target=addUser'>+ Add User</a></p>";
		
			if (count($devices) < 1) {
				$html .= "<p>No devices to display!</p>\n";
				return $html;
			}
		
			$html .= "<table>\n";
			$html .= "<tr><th>Brand</th><th>Type</th><th>Model</th><th>User</th><th>Pawprint</th><th>Location</th><th>Serial Number</th><th>ID</th><th>Department Owner</th><th>MoCode</th><th>Update Device</th><th>Delete Device</th></tr>\n";
		
			foreach ($devices as $device) {
				$brand = $device['Brand'];
				$model = $device['Model'];
				$type = $device['Type'];
				$name = $device['UserFirstName'] . " " . $device['UserLastName'];
				$pawprint = $device['UserPawprint'];
				$location = $device['UserOfficeNumber'] . $device['UserOfficeLetter'];
				$serialNumber = $device['SerialNumber'];
				$id = $device['ID'];
				$department = $device['DepartmentOwner'];
				$mocode = $device['MoCodePurchasedBy'];
				
				$html .= "<tr><td>$brand</td><td>$type</td><td>$model</td><td>$name</td><td>$pawprint</td><td>$location</td><td>$serialNumber</td><td>$id</td><td>$department</td><td>$mocode</td><td><form action='index.php' method='post'><input type='hidden' name='action' value='beginUpdateDevice'/><input type = 'hidden' name='ID' value='$id' /><input type='submit' value='Update'></form></td><td><form action='index.php' method='post'><input type='hidden' name='action' value='deleteDevice'/><input type = 'hidden' name='ID' value='$id' /><input type='submit' value='Delete'></form></td></tr>\n";
			}
			
			$html .= "</table>\n";

			print($html);
	
			//print generatePageHTML("Devices", $html, $stylesheet);
			//print($stylesheet);
		}



		public function presentUpdateDevice($device){

			$brand = $device['Brand'];
			$model = $device['Model'];
			$type = $device['Type'];
			$name = $device['UserFirstName'] . " " . $device['UserLastName'];
			$pawprint = $device['UserPawprint'];
			$location = $device['UserOfficeNumber'] . $device['UserOfficeLetter'];
			$serialNumber = $device['SerialNumber'];
			$id = $device['ID'];
			$department = $device['DepartmentOwner'];
			$mocode = $device['MoCodePurchasedBy'];
			$html = <<<EOT
			
			<!DOCTYPE html>
			<html>
			<head>
			<title>Gordon's Inventory</title>
			<link rel="stylesheet" type="text/css" href="inventory.css">
			</head>
			<body>
			<h1>Edit Device</h1>
			

			<form action='index.php' method='post'><input type='hidden' name='action' value='updateDevice' />

			<form action='index.php' method='post'><input type = 'hidden' name='ID' value='$id' />

			  <p>User<br />
			  <input type="text" name="User" value="$pawprint" placeholder="$pawprint" maxlength="255" size="30"></p>

			  <p>Serial Number<br />
			  <input type="text" name="SerialNumber" value="$serialNumber" placeholder="$serialNumber" maxlength="255" size="30"></p>

			  <p>Brand<br />
			  <input type="text" name="Brand" value="$brand" placeholder="$Brand" maxlength="255" size="30"></p>

			  <p>Type<br />
			  <input type="text" name="Type" value="$type" placeholder="$type" maxlength="255" size="30"></p>

			  <p>Model<br />
			  <input type="text" name="Model" value="$model" placeholder="$model" maxlength="255" size="30"></p>

			  <p>Department<br />
			  <input type="text" name="DepartmentOwner" value="$department" placeholder="$department" maxlength="255" size="30"></p>

			  <p>MoCode<br />
			  <input type="text" name="MoCodePurchasedBy" value="$mocode" placeholder="$mocode" maxlength="255" size="35"></p>

			  <input type="submit" value="Submit">
			</form>
			</body>
			</html>

EOT;
		print $html;

		}

		public function generatePageHTML($title, $body) {
			//return("hello");
			$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>$title</title>
<link rel="stylesheet" type="text/css" href="inventory.css">
</head>
<body>
$body
</body>
</html>
EOT;

			return $html;
		}



		public function presentAddDevice(){
		$html = <<<EOT
			<!DOCTYPE html>
			<html>
			<head>
			<title>Gordon's Inventory</title>
			<link rel="stylesheet" type="text/css" href="inventory.css">
			</head>
			<body>
			<h1>Add a Device</h1>
			<form action="index.php" method="post">

			<form action="index.php" method="post"><input type="hidden" name="action" value="addDevice" />

			  <p>User<br />
			  <input type="text" name="Owner" value="" placeholder="User's Pawprint" maxlength="255" size="30"></p>

			  <p>Serial Number<br />
			  <input type="text" name="SerialNumber" value="" placeholder="" maxlength="255" size="30"></p>

			  <p>Brand<br />
			  <input type="text" name="Brand" value="" placeholder="" maxlength="255" size="30"></p>

			  <p>Type<br />
			  <input type="text" name="Type" value="" placeholder="Desktop, Monitor, Printer, etc." maxlength="255" size="30"></p>

			  <p>Model<br />
			  <input type="text" name="Model" value="" placeholder="" maxlength="255" size="30"></p>

			  <p>Department<br />
			  <input type="text" name="DepartmentOwner" value="" placeholder="Department owner of this device" maxlength="255" size="30"></p>

			  <p>MoCode<br />
			  <input type="text" name="MoCodePurchasedBy" value="XXXX" placeholder="MoCode used to purchase this device" maxlength="255" size="35"></p>

			  <input type="submit" value="Submit">
			</form>
			</body>
			</html>

EOT;

		print $html;

	}


// 	private function redirect($url, $statusCode = 303) {
// 	   header('Location: ' . $url, true, $statusCode);
// 	   die();
// 	}

	}
?>