<?php
	class Model {

		// public function doThis(){
		// 	return("Tada");
		// }

		public function getInventory($message){

			// return 'hello';

			$devices = array();

			// Create Connection
			require('db_credentials.php');
			$mysqli = new mysqli($servername, $username, $password, $dbname);

			if($mysqli->connect_error){

				$message = $mysqli->connect_error;

			} else {

				// This string is the SQL statement to be executed

				$sql = "SELECT Devices.Brand, Devices.Model, Devices.Type, (SELECT Users.FirstName FROM Users WHERE Devices.Owner = Users.Id) as UserFirstName, (SELECT Users.LastName FROM Users WHERE Devices.Owner = Users.Id) as UserLastName, (SELECT Users.Pawprint FROM Users WHERE Devices.Owner = Users.Id) as UserPawprint, (SELECT Users.OfficeNumber FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeNumber, (SELECT Users.OfficeLetter FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeLetter, Devices.SerialNumber, Devices.DepartmentOwner, Devices.MoCodePurchasedBy, Devices.ID  FROM Devices";

				// Preforms the SQL query and checks to see if there was an error.
				if ($result = $mysqli->query($sql)) {
					if ($result->num_rows > 0) {
						// If no error, then turns the data into an associative array
						while($row = $result->fetch_assoc()) {
							array_push($devices, $row);
						}
					}
					$result->close();
				} else {
					// If there was an error from the SQL statement
					$message = $mysqli->error;
				}

				$mysqli->close();
			}

			return $devices;
		}

		public function beginUpdateDevice(){
			$message = "";
			$device;

			$id = $_POST['ID'];

			if (!$id) {
				$message = "No device was specified to update.";
			} else {
				// Create connection
				require('db_credentials.php');
				$mysqli = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($mysqli->connect_error) {
					$message = $mysqli->connect_error;
				} else {
					$id = $mysqli->real_escape_string($id);

					$sql = "SELECT Devices.Brand, Devices.Model, Devices.Type, (SELECT Users.FirstName FROM Users WHERE Devices.Owner = Users.Id) as UserFirstName, (SELECT Users.LastName FROM Users WHERE Devices.Owner = Users.Id) as UserLastName, (SELECT Users.Pawprint FROM Users WHERE Devices.Owner = Users.Id) as UserPawprint, (SELECT Users.OfficeNumber FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeNumber, (SELECT Users.OfficeLetter FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeLetter, Devices.SerialNumber, Devices.DepartmentOwner, Devices.MoCodePurchasedBy, Devices.ID  FROM Devices WHERE Devices.ID = $id";

					if ( $result = $mysqli->query($sql) ) {
						$device = $result->fetch_assoc();
						$mysqli->close();
					} else {
						//$message = $mysqli->error;
						$mysqli->close();
					}
				}
			}
			return $device;
		}
	}


		public function addDevice(){
		$message = "";

		$serialNumber = $_POST['SerialNumber'];
		$brand = $_POST['Brand'];
		$model = $_POST['Model'];
		$owner = $_POST['Owner'];
		$departmentOwner = $_POST['DepartmentOwner'];
		$moCode = $_POST['MoCodePurchasedBy'];
		$type = $_POST['Type'];

		require('db_credentials.php');
		$mysqli = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($mysqli->connect_error) {
			$message = $mysqli->connect_error;
		} else {
			$serialNumber = $mysqli->real_escape_string($serialNumber);
			$brand = $mysqli->real_escape_string($brand);
			$model = $mysqli->real_escape_string($model);
			$owner = $mysqli->real_escape_string($owner);
			$departmentOwner = $mysqli->real_escape_string($departmentOwner);
			$moCode = $mysqli->real_escape_string($moCode);
			$type = $mysqli->real_escape_string($type);

			$sql = "SELECT ID FROM Users WHERE Pawprint = '$owner'";

			if ($result = $mysqli->query($sql)) {
				$thing = $result->fetch_assoc();
				$holder = $thing['ID'];

				$sql = "INSERT INTO Devices (SerialNumber, Brand, Model, Owner, DepartmentOwner, MoCodePurchasedBy, Type) VALUES ('$serialNumber', '$brand', '$model', '$holder', '$departmentOwner', '$moCode', '$type')";
				if ($result = $mysqli->query($sql)) {
					$message = "Device was added";
					$mysqli->close();
				} else {
					$message = $mysqli->error;
					$mysqli->close();
				}

			} else {
				$sql = "INSERT INTO Devices (SerialNumber, Brand, Model, Owner, DepartmentOwner, MoCodePurchasedBy, Type) VALUES ('$serialNumber', '$brand', '$model', '', '$departmentOwner', '$moCode', '$type')";
				if ($result = $mysqli->query($sql)) {
					$message = "Device was added";
					$mysqli->close();
				} else {
					$message = $mysqli->error;
					$mysqli->close();
				}
			
			}		
		return $message;
		}
	}


	public function deleteDevice(){
		$id = $_POST['ID'];

		$message = "";

		if(!$id){
			$message = "No device was found to delete";
		} else {
			require('db_credentials.php');
			$mysqli = new mysqli($servername, $username, $password, $dbname);
			if ($mysqli->connect_error) {
				$message = $mysqli->connect_error;
			} else {
				$id = $mysqli->real_escape_string($id);
				$sql = "DELETE FROM Devices WHERE ID = $id";
				if ( $result = $mysqli->query($sql) ) {
					$message = "Device was deleted.";
				} else {
					$message = $mysqli->error;
				}
				$mysqli->close();
			}	
		}

		return $message;

	}

	}
?>