<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('task_class.php');
// Assignment: Implement this script
	$task = new Task();
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];

		switch ($action) {
			case 'add':
				$task->createNewTask();
				break;
			case 'update':
				$task->updateTask($_POST['taskId']);
				break;
			case 'delete':
				$task->delete($_POST['taskId']);
				break;
			default:
				echo json_encode(['success' => false]);
				break;
		}
	}
?>