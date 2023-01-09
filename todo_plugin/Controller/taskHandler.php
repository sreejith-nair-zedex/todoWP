<?php
use Models\Database as db;
$db = new db();

    /* Add New Task To DB */
if(isset($_POST["addTask"])){
    $taskName = $_POST["taskName"];
    $status = (int)$_POST["status"];
    $db->add_task($taskName,$status);
}

if(isset($_POST["updateTask"])){
//    echo "->>>>>";
//    print_r($_POST);
    $taskId = $_POST["id"];
    $taskName = $_POST["updateTaskName"];
    $status = (int)$_POST["updateStatus"];
    $db->update_task($taskId,$taskName,$status);
}

if (isset($_POST["deleteTask"])){
    $taskId = $_POST["id"];
    $db->delete_task($taskId);
}