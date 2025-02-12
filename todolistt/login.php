<?php
session_start();
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            echo "<script>alert('Anda berhasil login!'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
 body {
    font-family: Arial, sans-serif;
    background-color: #ffe6f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    flex-direction: column;
}

h2 {
    color: #d63384;
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
}

form {
    background: #ffb3d9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    width: 300px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    display: block;
    margin-top: 10px;
    color: #6d214f;
    font-weight: bold;
    width: 100%;
    text-align: left;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ff66a3;
    border-radius: 5px;
    background: #fff5f8;
    box-sizing: border-box;
}

button {
    background: #ff66a3;
    color: white;
    border: none;
    padding: 10px;
    margin-top: 15px;
    width: 100%;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background: #ff3385;
}

p {
    margin-top: 10px;
    font-size: 14px;
    color: #6d214f;
}

a {
    color: #d63384;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

.alert-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #ffccd5;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.alert-popup button {
    margin-top: 10px;
    background: #ff3385;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.alert-popup button:hover {
    background: #d63384;
}
</style>

</head>
<script>
function showAlert(message) {
    let popup = document.createElement("div");
    popup.classList.add("alert-popup");
    popup.innerHTML = <p>${message}</p><button onclick="this.parentElement.remove()">OK</button>;
    document.body.appendChild(popup);
    popup.style.display = "block";
}
</script>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
    
</body>
</html>