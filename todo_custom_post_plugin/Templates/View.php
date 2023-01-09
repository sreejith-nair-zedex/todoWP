<?php
$success_msg = $error_msg = "";

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
        $post_title = input($_POST['post_title']);
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
        if ($insert) {
            $success_msg = "Task Added Successfully!";
        }
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
        $update_title = input($_POST['update_title']);
        $update_status_post_meta = $_POST['update_status_post_meta'];
        $meta_key = 'status_meta_key';
        $update_arg = array(
            'post_type' => 'task',
            'ID' => $post_id,
            'post_title' => $update_title
        );
        $updatePost = wp_update_post($update_arg);
        $updateMeta = update_post_meta($post_id, $meta_key, $update_status_post_meta);
        $success_msg = "Task Updated Successfully";
    }
}

if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $meta_key = 'status_meta_key';
    $deletePost = wp_delete_post($post_id);
    $deleteMeta = delete_post_meta($post_id, $meta_key);
    $success_msg = "Task Deleted Successfully";
}
?>
<div class="row mt-3">
        <div class="col-md-6">
            <?php if($error_msg): ?>
            <p class="fs-5 text-danger ms-5"><?php echo $error_msg?></p>
            <?php endif; ?>
            <?php if($success_msg): ?>
                <p class="fs-5 text-success ms-5"><?php echo $success_msg?></p>
            <?php endif; ?>
        </div>
</div>
<div class="container">
    
    <div class="row m-3">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <h1>Todo App</h1>
        </div>
        <div class="col-md-4">
            <!--                <button class="btn btn-primary btn-lg mt-3 float" data-bs-toggle="modal" data-bs-target="#AddTask">Add New Task</button>-->
        </div>
    </div>
    <div class="row m-3">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!--            <th scope="col">id</th>-->
                        <th scope="col">Task</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="" method="post">
                        <tr>
                            <td style="width: 25%;">
                                <input type="text" class="form-control" name="post_title" placeholder="Enter Task Name" >
                            </td>
                            <td style="width: 25%;">
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="status">
                                    <option value="0">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </td>
                            <td style="width: 25%;">
                                <button type="submit" class="btn btn-primary" name="add_post">Add New Task</button>
                            </td>
                        </tr>
                    </form>
                    <?php
                    // WP Query
                    $args = array(
                        'post_type' => 'task',
                        'post_status' => 'publish',
                        'posts_per_page' => 100,
                        'orderby' => 'id',
                        'order' => 'DESC',
                        'meta_query' => array(
                            array(
                                'key' => 'status_meta_key',
                            )
                        )
                    );
                    $the_query = new WP_Query($args);
                    if ($the_query->have_posts()) {

                        while ($the_query->have_posts()) : $the_query->the_post();
                            $postmeta = get_post_meta(get_the_ID(), 'status_meta_key', true);
                    ?>
                            <form action="" method="post">
                                <tr>
                                    <input type="hidden" class="form-control" name="post_id" value="<?php echo the_ID(); ?>">
                                    <td style="width: 25%;">
                                        <input type="text" class="form-control" name="update_title" value="<?php echo the_title(); ?>" required>
                                    </td>
                                    <td style="width: 25%;">
                                        <?php
                                        $value = $postmeta;
//                                        echo $postmeta;
                                        $option = ($value) ? "Completed" : "Pending";
//                                        $option2 = (!$value) ? "Completed" : "Pending";
                                        $value2 = ($value==1) ? 0 : 1;
                                        $option2 = ($value2) ? "Completed" : "Pending";
                                        ?>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="update_status_post_meta">
                                            <option value="<?php echo $value; ?>"><?php echo $option; ?></option>
                                            <option value="<?php echo $value2; ?>"><?php echo $option2; ?></option>
                                        </select>
                                    </td>
                                    <td style="width: 25%;">
                                        <button type="submit" class="btn btn-success" name="update_post"><i class="fa fa-solid fa-wrench fa-lg"></i></button>
                                        <button type="submit" class="btn btn-danger" name="delete_post"><i class="fa fa-trash fa-lg"></i></button>
                                    </td>
                                </tr>
                            </form>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    } else {
                        echo "No Post found";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
