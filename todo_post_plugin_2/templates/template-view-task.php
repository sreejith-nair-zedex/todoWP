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
