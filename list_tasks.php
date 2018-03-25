<?php
/**
 * Created by PhpStorm.
 * User: johangriesel
 * Date: 15122016
 * Time: 15:14
 * @package    ${NAMESPACE}
 * @subpackage ${NAME}
 * @author     johangriesel <info@stratusolve.com>
 * Task_Data.txt is expected to be a json encoded string, e.g: [{"taskId":1,"taskName":"Test","taskDescription":"Test"},{"taskId":"2","taskName":"Test2","taskDescription":"Test2"}]
 */
$taskData = file_get_contents('task_data.txt');
$html = '<a id="newTask" href="#" class="list-group-item" data-toggle="modal" data-target="#myModal">
                    <h4 class="list-group-item-heading">No Tasks Available</h4>
                    <p class="list-group-item-text">Click here to create one</p>
                </a>';
if (strlen($taskData) < 1) {
    die($html);
}
$taskArray = json_decode($taskData);
if (sizeof($taskArray) > 0) {
    $html = '';
    foreach ($taskArray as $task) {
        $html .= '<a id="'.$task->taskId.'" href="#" class="list-group-item" data-toggle="modal" data-target="#myModal">
                    <h4 class="list-group-item-heading">'.$task->taskName.'</h4>
                    <p class="list-group-item-text">'.$task->taskDescription.'</p>
                </a>';
    }
}
die($html);
?>