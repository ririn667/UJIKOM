<?php
include 'config.php';

// Ambil data tugas berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Tugas tidak ditemukan!";
        exit();
    }
}

// Proses update tugas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    $sql = "UPDATE tasks SET name='$name', priority='$priority', deadline='$deadline' WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #ffe6f2;
    color: #333;
    text-align: center;
    margin: 0;
    padding: 0;
}

h2 {
    color: #d63384;
    margin-top: 20px;
}

form {
    background: #fff;
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    text-align: left;
    font-weight: bold;
    margin-top: 10px;
    color: #d63384;
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #d63384;
    border-radius: 5px;
    font-size: 16px;
    background: #fff5fa;
    color: #333;
}

button {
    background-color: #d63384;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
    width: 100%;
}

button:hover {
    background-color: #c2185b;
}

a {
    display: inline-block;
    margin-top: 10px;
    color: #d63384;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <h2>Edit Tugas</h2>

    <form method="POST">
        <label>Nama Tugas:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($task['name']); ?>" required>

        <label>Prioritas:</label>
        <select name="priority">
            <option value="Rendah" <?php echo ($task['priority'] == 'Rendah') ? 'selected' : ''; ?>>Rendah</option>
            <option value="Sedang" <?php echo ($task['priority'] == 'Sedang') ? 'selected' : ''; ?>>Sedang</option>
            <option value="Tinggi" <?php echo ($task['priority'] == 'Tinggi') ? 'selected' : ''; ?>>Tinggi</option>
        </select>

        <label>Deadline:</label>
        <input type="date" name="deadline" value="<?php echo $task['deadline']; ?>" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="index.php">Back to To-Do List</a>
</body>
</html>