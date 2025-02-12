<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];
    $subtasks = isset($_POST['subtasks']) ? $_POST['subtasks'] : [];

    // Validasi Priority
    $valid_priorities = ["Low", "Medium", "High"];
    if (!in_array($priority, $valid_priorities)) {
        die("Error: Prioritas tidak valid.");
    }

    // Gunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO tasks (name, priority, deadline, status) VALUES (?, ?, ?, 'Belum Selesai')");
    $stmt->bind_param("sss", $name, $priority, $deadline);

    if ($stmt->execute()) {
        $task_id = $conn->insert_id;

        // Tambahkan subtugas
        foreach ($subtasks as $subtask_name) {
            if (!empty($subtask_name)) {
                $stmt_subtask = $conn->prepare("INSERT INTO subtasks (task_id, name, status) VALUES (?, ?, 'Belum Selesai')");
                $stmt_subtask->bind_param("is", $task_id, $subtask_name);
                $stmt_subtask->execute();
            }
        }

        echo "<script>alert('Tugas berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tugas</title>
    <link rel="stylesheet" href="style.css">
    <style>
            body {
    font-family: Arial, sans-serif;
    background-color: #ffe6f0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    position: relative;
}

h2 {
    color: #d63384;
    text-align: center;
    font-size: 28px;
    font-weight: bold;
}

.btn, .submit-btn, .add-btn {
    background: #ff66a3;
    color: white;
    border: none;
    padding: 8px 20px;
    margin: 5px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    cursor: pointer;
    min-width: 180px;
    text-align: center;
}

.btn:hover, .submit-btn:hover, .back-btn:hover, .add-btn:hover {
    background: #ff3385;
}

.container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
    width: 400px;
    text-align: center;
    position: relative;
}

.form-box {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
}

.input-field {
    padding: 8px;
    border: 1px solid #ff66a3;
    border-radius: 5px;
    width: 100%;
}

#subtask-container {
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 100%;
}

.button-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    width: 100%;
}

    </style>
    <script>
        function addSubtaskField() {
            let container = document.getElementById("subtask-container");
            let input = document.createElement("input");
            input.type = "text";
            input.name = "subtasks[]";
            input.placeholder = "Nama Subtugas";
            input.className = "input-field"; // Tambahkan class agar sesuai dengan CSS
            container.appendChild(input);
            container.appendChild(document.createElement("br"));
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Tambah Tugas</h2>
        <form method="post" class="form-box">
            <label>Nama Tugas:</label>
            <input type="text" name="name" class="input-field" required>

            <label>Prioritas:</label>
            <select name="priority" class="input-field">
                <option value="Low">Low</option>
                <option value="Medium" selected>Medium</option>
                <option value="High">High</option>
            </select>

            <label>Deadline:</label>
            <input type="date" name="deadline" class="input-field" required>

            <label>Subtugas:</label>
            <div id="subtask-container">
                <input type="text" name="subtasks[]" class="input-field" placeholder="Nama Subtugas">
            </div>
            <button type="button" onclick="addSubtaskField()" class="add-btn">+ Tambah Subtugas</button>

            <button type="submit" class="submit-btn">Simpan</button>
            <a href="index.php" class="back-btn">Kembali</a>
        </form>
    </div>
</body>
</html>