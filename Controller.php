<?php

	require ('Model.php');
	require ('View.php');
	//require ('inventory.css');

	class Controller {
		private $model;
		private $view;

		private $page = '';
		private $action = '';
		private $message = '';
		// private returnMessage = '';

		// private varibales

		public function __construct() {
			$this->model = new Model();
			$this->view = new View();

			$this->page = $_GET['view']; // error check to see if a result was returned
			$this->action = $_POST['action'];
		}

		public function __destruct() {
			$this->model = null;
			$this->view = null;
		}

		public function run() {
			// print($this->action);
			// print("controller");
			// print $this->model->doThis();
			// print("controller");
			switch ($this->action) {
				case 'presentAddDevice':
					$this->view->presentAddDevice();
					break;

				case 'addDevice':
					$message = $this->model->addDevice();
					$this->inventory($message);
					break;

				case 'deleteDevice':
					$message = $this->model->deleteDevice();
					$this->inventory($message);
					break;

					case 'beginUpdateDevice':
						$device = $this->model->beginUpdateDevice();
						
						//$message = $this->view->presentUpdateDevice($device);
						break;

				default: 
					$this->inventory($message);
						//view - get all items;
						break;
			}

			// switch ($this->page) {
			// 	// case default: login page
			// 	default:  // works to here
			// 		$this->inventory($message);
			// 		//view - get all items;
			// 		break;
			// }
		}

		private function inventory($message) {
			//print("balls");
			$devices = $this->model->getInventory($message);
			//foreach ($devices as $thing) print($thing);
			$this->view->presentInventory($devices, $message);
			// if($devices) ? $this->view->presentInventory($devices, $message) : print('error');
		}

	}


	// switch($this->action) {

	// 	case 'presentAddDevice':
	// 		$this->presentAddDevice();
	// 		break;
	// 	case 'addDevice':
	// 		$message = addDevice();
	// 		getInventory($message);
	// 		break;
	// 	case 'presentAddUser':
	// 		presentAddUser();
	// 		break;
	// 	case 'addUser':
	// 		$message = model.addUser();
	// 		model.getInventory($message);
	// 		break;
	// 	case 'deleteDevice':
	// 		$message = model.deleteDevice();
	// 		model.getInventory($message);
	// 		break;
	// 	case 'beginUpdateDevice':
	// 		$message = model.beginUpdateDevice();
	// 		break;
	// 	case 'updateDevice':
	// 		$message = model.updateDevice();
	// 		model.getInventory($message);
	// 		break;
	// 	case 'searchDevices':
	// 		$message = model.searchDevices();
	// 		break;
	// 	default:
	// 		model.getInventory($message);
	// }

	// $action = $_POST['action'];
	
	// switch($action) {
	// 	case 'presentAddDevice':
	// 		presentAddDevice();
	// 		break;
	// 	case 'addDevice':
	// 		$message = addDevice();
	// 		getInventory($message);
	// 		break;
	// 	case 'presentAddUser':
	// 		presentAddUser();
	// 		break;
	// 	case 'addUser':
	// 		$message = model.addUser();
	// 		model.getInventory($message);
	// 		break;
	// 	case 'deleteDevice':
	// 		$message = model.deleteDevice();
	// 		model.getInventory($message);
	// 		break;
	// 	case 'beginUpdateDevice':
	// 		$message = model.beginUpdateDevice();
	// 		break;
	// 	case 'updateDevice':
	// 		$message = model.updateDevice();
	// 		model.getInventory($message);
	// 		break;
	// 	case 'searchDevices':
	// 		$message = model.searchDevices();
	// 		break;
	// 	default:
	// 		model.getInventory($message);

?>