<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$sql = "SELECT * FROM tasks ORDER BY priority DESC, deadline ASC";
$result = $conn->query($sql);
$today = date("Y-m-d");

function getSubtasks($task_id, $conn) {
    $subtasks = [];
    $sql = "SELECT * FROM subtasks WHERE task_id = $task_id";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        $subtasks[] = $row;
    }
    return $subtasks;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffe6f0;
            text-align: center;
        }
        .btn {
            background: #ff66a3;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }
        .btn:hover {
            background: #ff3385;
        }
        .task-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            padding: 20px;
        }
        .task-card {
            background: #ffb3d9;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
            width: 250px;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .task-title {
            font-size: 18px;
            font-weight: bold;
            color: #6d214f;
        }
        .task-info {
            font-size: 14px;
            color: #6d214f;
        }
        .task-actions {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 10px;
        }
        .edit-btn, .delete-btn {
            text-decoration: none;
            font-size: 18px;
            color: #d63384;
            font-weight: bold;
        }
        .edit-btn:hover, .delete-btn:hover {
            color: #ff3385;
        }
    </style>
</head>
<body>
    <h2>To-Do List</h2>
    <p>Selamat datang, <?php echo $_SESSION['user']; ?>!</p>
    <a href="logout.php" class="btn logout-btn">Logout</a>
    <a href="add_task.php" class="btn">Tambah Tugas</a>
    
    <div class="task-list">
        <?php while ($row = $result->fetch_assoc()) { 
            $isLate = ($row['status'] !== 'Selesai' && $row['deadline'] < $today);
            $subtasks = getSubtasks($row['id'], $conn);
            $allSubtasksDone = count($subtasks) > 0 && !in_array("Belum Selesai", array_column($subtasks, 'status'));
            $taskCompleted = ($row['status'] == 'Selesai' || $allSubtasksDone);
        ?>
            <div class="task-card">
                <input type="checkbox" class="task-checkbox" data-task-id="<?php echo $row['id']; ?>" <?php echo $taskCompleted ? 'checked' : ''; ?>>
                <div class="task-title"> <?php echo htmlspecialchars($row['name']); ?> </div>
                <div class="task-info">
                    <strong>Status:</strong> <span class="task-status"> <?php echo $row['status']; ?> </span>
                </div>
                <div class="task-info">
                    <strong>Prioritas:</strong> <?php echo $row['priority']; ?>
                </div>
                <div class="task-info">
                    <strong>Deadline:</strong> <?php echo $row['deadline']; ?>
                </div>
                <?php if ($isLate) { ?>
                    <div class="task-info"><span class="late">Terlambat!</span></div>
                <?php } ?>
                
                <div class="subtask-list">
                    <strong>Subtugas:</strong>
                    <?php foreach ($subtasks as $subtask) { ?>
                        <div class="subtask-item">
                            <input type="checkbox" class="subtask-checkbox" data-subtask-id="<?php echo $subtask['id']; ?>" data-task-id="<?php echo $row['id']; ?>" <?php echo ($subtask['status'] == 'Selesai') ? 'checked' : ''; ?>>
                            <span><?php echo htmlspecialchars($subtask['name']); ?></span>
                        </div>
                    <?php } ?>
                </div>
                
                <div class="task-actions">
                    <?php if (!$taskCompleted) { ?>
                        <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="edit-btn">✎</a>
                    <?php } ?>
                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="delete-btn">✖</a>
                    <?php if (!$taskCompleted) { ?>
                        <a href="add_subtask.php" class="btn">+ Tambah Subtugas</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <script>
        document.querySelectorAll('.subtask-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                let taskId = this.dataset.taskId;
                let subtasks = document.querySelectorAll(`.subtask-checkbox[data-task-id="${taskId}"]`);
                let allChecked = [...subtasks].every(subtask => subtask.checked);
                let taskCheckbox = document.querySelector(`.task-checkbox[data-task-id="${taskId}"]`);
                taskCheckbox.checked = allChecked;
                
                if (allChecked) {
                    document.querySelector(`.task-card input[data-task-id="${taskId}"]`).closest('.task-card').querySelector('.edit-btn').style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
