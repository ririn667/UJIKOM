<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $subtask_name = $_POST['subtask_name'];

    if (!empty($subtask_name)) {
        $sql = "INSERT INTO subtasks (task_id, name, status) VALUES ($task_id, '$subtask_name', 'Belum Selesai')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Subtugas berhasil ditambahkan!'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Ambil daftar tugas untuk ditampilkan dalam dropdown
$tasks = $conn->query("SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Subtugas</title>
    <link rel="stylesheet" href="style.css"> <!-- Gunakan file CSS eksternal -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffe6eb;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff0f5;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 320px;
        }

        h2 {
            color: #d63384;
            font-weight: bold;
        }

        .form-box {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-field {
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ffb3c1;
            border-radius: 8px;
            background-color: #fff;
            color: #d63384;
            width: calc(100% - 24px);
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 15px;
        }

        .submit-btn, .back-btn {
            background-color: #ff85a2;
            color: white;
            padding: 12px;
            border: none;
            margin: 2px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            width: 48%;
            text-align: center;
            font-weight: bold;
            transition: 0.3s;
        }

        .submit-btn:hover, .back-btn:hover {
            background-color: #ff6384;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Subtugas</h2>
        <form method="post" class="form-box">
            <label>Pilih Tugas:</label>
            <select name="task_id" required class="input-field">
                <?php while ($row = $tasks->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php } ?>
            </select>

            <label>Nama Subtugas:</label>
            <input type="text" name="subtask_name" class="input-field" required>

            <button type="submit" class="submit-btn">Tambah Subtugas</button>
            <a href="index.php" class="back-btn">Kembali</a>
        </form>
    </div>
</body>
</html>