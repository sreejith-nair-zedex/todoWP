<?php

namespace Models;

class Database
{
//    public static $table_name;
//    function __construct(){
//        global $wpdb;
//        $this->table_name =
//    }

    protected function todo_plugin_create_table(){
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . "task";
        $sql = $wpdb->prepare("CREATE TABLE IF NOT EXISTS `$table_name` 
                                    (`id` INT NOT NULL AUTO_INCREMENT , 
                                    `taskName` VARCHAR(100) NOT NULL , 
                                    `status` BOOLEAN NOT NULL ,
                                    PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        $wpdb->query($sql);
    }

    protected function todo_plugin_clear_db(){
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . "task";
        $sql = $wpdb->prepare("TRUNCATE `$table_name`");
        $wpdb->query($sql);
    }

    public function add_task($taskName,int $status){
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . "task";
        $wpdb->query($wpdb->prepare(
            "INSERT INTO `$table_name`(taskName,status) 
                   VALUES (%s,%d)",
                   $taskName,
                   $status
        ));
    }

    public function view_all_task(){
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . "task";
        $sql = "SELECT * FROM `$table_name`";
        return $wpdb->get_results($sql);
    }

    public function update_task(int $id, $taskName,int $status){
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . "task";
        $wpdb->query($wpdb->prepare(
            "UPDATE `$table_name` SET taskName = %s, status= %d WHERE id = %d",
            $taskName,
            $status,
            $id
        ));
    }

    public function delete_task(int $id){
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . "task";
        $wpdb->query($wpdb->prepare(
            "DELETE FROM `$table_name`WHERE id = %d",
            $id
        ));
    }
}