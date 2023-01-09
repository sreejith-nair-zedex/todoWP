<?php
//defined('ABSPATH') || exit();
//
//if (!class_exists('Tp2FormHandler')){
//    class Tp2FormHandler{
//        public function add_task(){
//
//        }
//    }
//}
//
function input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['add_post'])) {
    if (empty($_POST['post_title'])){
        $error_msg = "Task Name Cannot Be Empty!";
    }else{
        $post_title = $_POST['post_title'];
        $meta_key = 'status_meta_key';
        $insert_status_post_meta = $_POST['status'];
        $insert_arg = array(
            'post_type' => 'task',
            'post_title' => $_POST['post_title'],
            'post_status'   => 'publish',
            'post_author'   => 1,
        );
        $insert = wp_insert_post($insert_arg);
        $insertMeta = update_post_meta($insert, $meta_key, $insert_status_post_meta);
//        if ($insert) {
//            $success_msg = "Task Added Successfully!";
//        }
    }
}

if (isset($_POST['update_post'])) {
    if (empty($_POST['update_title'])){
        $error_msg = "uTask Name Cannot Be Empty!";
    }
    else if (empty($_POST['update_status_post_meta']) && $_POST['update_status_post_meta']!=0){
        echo $_POST['update_status_post_meta'];
        $error_msg = "uTask Status Cannot Be Empty!";
    }
    else {
        $post_id = $_POST['post_id'];
        $update_title = $_POST['update_title'];
        $update_status_post_meta = $_POST['update_status_post_meta'];
        $meta_key = 'status_meta_key';
        $update_arg = array(
            'post_type' => 'task',
            'ID' => $post_id,
            'post_title' => $update_title
        );
        $updatePost = wp_update_post($update_arg);
        $updateMeta = update_post_meta($post_id, $meta_key, $update_status_post_meta);
//        $success_msg = "Task Updated Successfully";
    }
}

if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $meta_key = 'status_meta_key';
    $deletePost = wp_delete_post($post_id);
    $deleteMeta = delete_post_meta($post_id, $meta_key);
//    $success_msg = "Task Deleted Successfully";
}
