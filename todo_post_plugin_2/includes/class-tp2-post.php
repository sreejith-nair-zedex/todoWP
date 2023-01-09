<?php
defined('ABSPATH') || exit();

if (!class_exists('Tp2Post')){
    class Tp2CustomPost{
        protected static $instancee;

        public function __construct(){
            add_action('init',[$this,'register_todo_task_post']);
            add_action('add_meta_boxes',[$this,'add_custom_meta_box']);
            add_action('save_post',[$this,'save_custom_meta_box']);
        }

        public function register_todo_task_post(){
            register_post_type('task',
            array(
                'labels' => array(
                    'name'=> __('Tasks'),
                    'singular_name' => __("Task")
                ),
                'public' => true,
                'show_in_rest'=>true,
                'supports'=> array(
                    'title',

                ),
                'has_archive' => true,
                'query_vars' => true,
                'rewrite'   => array( 'slug' => 'my-todo-tasks' ),
                'menu_position' => 5,
            ));
        }

        function add_custom_meta_box(){
            add_meta_box("status_meta_box","Status",[$this,"custom_meta_box_html"],"task","side");
        }

        function custom_meta_box_html($post){
            $value = get_post_meta($post->ID,'status_meta_key',true);
            $option = ($value) ? "Completed" : "Pending";
            $value2 = ($value==1) ? 0 : 1;
            $option2 = ($value2) ? "Completed" : "Pending";
            echo '<label for="status">Select status of the task</label>';
            echo '<select class="form-select form-select-lg mb-3 postbox" id="status" aria-label=".form-select-lg example" name="status">';
            echo '<option value='.esc_attr($value).'>'.$option.'</option>';
            echo '<option value='.esc_attr($value2).'>'.$option2.'</option>';
            echo '</select>';
        }

        public function save_custom_meta_box($post_id){
            if ( !current_user_can( 'edit_posts' ) ) {
                return $post_id;
            }
            $data = sanitize_text_field($_POST['status']);
            update_post_meta($post_id,'status_meta_key',$data);
        }


        public static function getInstance(){
            if(self::$instancee ===null){
                self::$instancee = new self();
            }
            return self::$instancee;
        }
    }
}
