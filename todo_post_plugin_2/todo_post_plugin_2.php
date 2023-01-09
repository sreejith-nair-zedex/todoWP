<?php
/*
 Plugin Name: todo_post_2
 Description: TodoPosts to create custom post.
 Version: 1.2.0
 Author: Sreejith Nair
*/

defined('ABSPATH') || exit();

//define()

if (!defined('TODOPOST2_PLUGIN_DIR')){
    define('TODOPOST2_PLUGIN_DIR',untrailingslashit(plugin_dir_path(__FILE__)));
    define('TODOPOST2_INCLUDES_DIR',untrailingslashit(plugin_dir_path(__FILE__)) . '/includes/');
    define('TODOPOST2_TEMPLATES_DIR',untrailingslashit(plugin_dir_path(__FILE__)) . '/templates/');
}

if (!class_exists('TodoPost2')){
    include_once TODOPOST2_INCLUDES_DIR. 'class-tp2.php';
}

function todopost2_init(){
    return TodoPost2::getInstance();
}

todopost2_init();