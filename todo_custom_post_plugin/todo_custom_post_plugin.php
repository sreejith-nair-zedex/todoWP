<?php
/*
 * Plugin Name: todo_custom_post_plugin
 * Description: Todoapp plugin to create post and display all todoapp tasks
 * Version: 1.1
 *
 * */

if (!defined("ABSPATH")){die;}
add_action('init','check');
function check(){
    //Saving Meta Box values in wp_postmeta
    if ( current_user_can( 'edit_posts' ) ) {
        function save_custom_meta_box($post_id){
            if (array_key_exists("status",$_POST)){
                update_post_meta(
                    $post_id,
                    'status_meta_key',
                    $_POST['status']
                );
            }
        }
        add_action("save_post","save_custom_meta_box");
    }
}

//Adding Custom Post Types
function todo_task_post(){
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
//        'editor',
//        'thumbnail'
    ),
    'has_archive' => true,
    'query_vars' => true,
    'rewrite'   => array( 'slug' => 'my-todo-tasks' ),
    'menu_position' => 5,
        // 'taxonomies' => array('cuisines', 'post_tag') // this is IMPORTANT
    )
    );
}

add_action("init","todo_task_post");


//Adding Meta Box
function add_custom_meta_box(){
    add_meta_box("status_meta_box","Status","custom_meta_box_html","task","side");
}
add_action('add_meta_boxes',"add_custom_meta_box");

//Displaying the html
//Using get_post_data to get the stored value in wp_postmeta
function custom_meta_box_html($post){
    $value = get_post_meta($post->ID,'status_meta_key',true);
    ?>
    <label for="status">Select status of the task</label>
    <select class="form-select form-select-lg mb-3 postbox" id="status" aria-label=".form-select-lg example" name="status">
        <option value="0"<?php selected($value,"0");?>>Pending</option>
        <option value="1"<?php selected($value,"1");?>>Completed</option>
    </select>
<?php
}

//Loading Styles and Scripts
function load_stylesheets()
{
    wp_enqueue_style('BootstrapCSS','//cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
    wp_enqueue_style('Font Awesome','//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('DataTableCSS','//cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css');
}

function load_scripts()
{
    wp_enqueue_script('DataTableJs','//cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js',array('jQuery'));
    wp_enqueue_script('BootstrapJS','//cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('jQuery','//code.jquery.com/jquery-3.6.3.min.js');
    wp_enqueue_script('custom_script',plugins_url( '/Templates/alerts.js' , __FILE__ ) );
}

add_action( 'wp_enqueue_scripts',  'load_stylesheets');
add_action( 'wp_enqueue_scripts', 'load_scripts');

//Displaying the Page
function display_tasks(){
    load_template(dirname(__FILE__)."/Templates/View.php",true);
}
add_shortcode('task','display_tasks');

