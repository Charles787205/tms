<?php
require_once('Controller.php');

$taskManager = new TaskManager();
$userManager = new UserManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTask'])) {
        $taskName = $_POST['taskName'];
        $user_id = $_POST['user_fk'];
        $taskManager->addTask($taskName, $user_id);
    } elseif (isset($_POST['markDone'])) {
        $taskId = $_POST['taskId'];
        $taskManager->markTaskAsDone($taskId);
    } elseif (isset($_POST['addUser'])){
        $userManager->createUser($_POST['userName']);
    } elseif(isset($_POST['delete'])){
        $userManager->deleteUser($_POST['userId']);
    }elseif(isset($_POST['update']) && isset($_POST['userName_update'])){
        $userManager->updateUser($_POST['userId'], $_POST['userName_update']);
    }
}

$tasks = $taskManager->getTasks();
$users = $userManager->getUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <form method="post" class="mt-5">
                    <label for="userName" class="form-label">New User</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="userName" name="userName" placeholder="User" aria-label="User" aria-describedby="button-addon2">
                        <button type="submit" class="btn btn-primary" name="addUser" type="button" id="button-addon2">Add Task</button>
                    </div>
                </form>

                <h3>Users</h3>
                <ul class="list-group">
                    <?php foreach ($users as $user) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="col">
                                <small>ID: <?php echo $user['userId'] ?></small>
                                <h5 class="mb-1">User: <?php echo $user['name']; ?></h5>
                            </div>
                            <form method="post">
                                <input type="hidden" name="userId" value="<?php echo $user['userId']; ?>">
                                <div class="row" style="gap:5px;">
                                    <input type="text" class="form-control col mr-5" style="margin-right:10px;"  name="userName_update" placeholder="Update username" aria-label="User" aria-describedby="button-addon2">
                                    <button type="submit" class="btn  btn-sm btn-primary" style="max-width: 60px; " name="update">Update</button>
                                    <button type="submit" class="btn  btn-sm btn-danger col" style='max-width: 60px; ' name="delete">Delete</button>
                                </div>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col">
               <form method="post" class="mt-5">
                    <label for="taskName" class="form-label">New Task</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="taskName" name="taskName" placeholder="Task" aria-label="Task" aria-describedby="button-addon2">
                        <button type="submit" class="btn btn-primary" name="addTask" type="button" id="button-addon2">Add Task</button>
                    </div>
                    <div class="input-group mb-3">
                        <select name="user_fk" id="" class="form-control">
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user['userId'] ?>"><?php echo $user['name']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </form>

                <h3>Tasks</h3>
                <ul class="list-group">
                    <?php foreach ($tasks as $task) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="col">
                                <div class="col">
                                    <small>ID: <?php echo $task['taskId'] ?></small>
                                    <small>USER: <?php echo $task['name'] ?></small>
                                </div>
                                <h5 class="mb-1">Task: <?php echo $task['taskName']; ?></h5>
                            </div>
                            
                            <form method="post">
                                <input type="hidden" name="taskId" value="<?php echo $task['taskId']; ?>">
                                <button type="submit" class="btn <?php echo $task['is_done'] ? 'btn-success' : 'btn-danger'; ?> btn-sm" name="markDone"><?php echo $task['is_done'] ? 'Done' : 'Pending'; ?></button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div> 
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
