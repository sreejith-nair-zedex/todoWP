
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Task</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <tr>
                <td style="width: 25%;">
                    <input type="text" class="form-control" disabled value="AUTO-INCREMENT">
                </td>
                <td style="width: 25%;">
                    <input type="text" class="form-control" name="taskName" placeholder="Enter Task Name" required>
                </td>
                <td style="width: 25%;">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="status">
                        <option value="0">Pending</option>
                        <option value="1">Completed</option>
                    </select>
                </td>
                <td style="width: 25%;">
                    <center><button type="submit" class="btn btn-primary btn-sm" name="addTask">Add New Task</button></center>
                </td>
            </tr>
        </form>
        <?php
            use Models\Database as db;
            $db = new db();
            $datas = $db->view_all_task();
            foreach ($datas as $data):
        ?>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <tr>
            <td style="width: 25%;">
            <input type="hidden" class="form-control" name="id" value="<?php echo $data->id; ?>">
            <input type="text" class="form-control" name="taskId" disabled value="<?php echo $data->id; ?>">
            </td>
            <td style="width: 25%;">
                <input type="text" class="form-control" name="updateTaskName" value="<?php echo $data->taskName; ?>" required>
            </td>
            <td style="width: 25%;">
                <?php
                    $value = $data->status;
                    $option = ($value) ? "Completed" : "Pending";
                    $option2 = (!$value) ? "Completed" : "Pending";
//                    echo $value;
//                    echo $option;
//                    echo $option2;
                ?>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="updateStatus">
                    <option value="<?php echo $value; ?>"><?php echo $option; ?></option>
                    <option value="<?php echo !$value; ?>"><?php echo $option2; ?></option>
                </select>
            </td>
            <td style="width: 25%;">
               <button type="submit" class="btn btn-success btn-sm" name="updateTask" >Update Task</button>
                <button type="submit" class="btn btn-danger btn-sm" name="deleteTask">Delete Task</button>
            </td>
        </tr>
        </form>
    <?php endforeach; ?>
    </tbody>
</table>
