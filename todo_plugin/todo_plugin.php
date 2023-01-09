<?php
/*
 * Plugin Name: todo_plugin
 * Description: Plugin to create todoapp
 * Version: 1.0
 * */
if(!(defined("ABSPATH"))){die();}

require_once "Models/Database.php";
require_once "Controller/taskHandler.php";
use Models\Database;

class TodoPlugin extends Database{
    function todo_plugin_activate(){
        $this->todo_plugin_create_table();
    }

    function todo_plugin_deactivate(){
        $this->todo_plugin_clear_db();
    }
}

if (class_exists("TodoPlugin")){
    $todo_plugin = new TodoPlugin();
}

register_activation_hook(__FILE__,array($todo_plugin,"todo_plugin_activate"));
register_deactivation_hook(__FILE__,array($todo_plugin,"todo_plugin_deactivate"));

add_action("admin_menu","trial");
function trial(){
    add_menu_page("Todo","Todo","manage_options","manage_todo","Todo");
}


function Todo(){
    global $wpdb,$table_prefix;
    $table_name = $table_prefix."task";
    $path = "Templates/TaskView.php";
    template($path);
}

function template($body){
    include_once "Templates/header.php";
    include_once $body;
    include_once "Templates/footer.php";
}
