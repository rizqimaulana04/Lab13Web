<?php
session_start();

$title = 'Data Mahasiswa';
include_once '../class/koneksi.php';

if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '{$user}' AND password = md5('{$password}') ";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) != 0) {
        $_SESSION['isLogin'] = true;
        $_SESSION['user'] = mysqli_fetch_array($result);

        header('location: index.php');
    } else {
        $errorMsg = "<p style=\"color:red;\">Gagal Login, silakan ulangi lagi.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 300px;
            margin: 50px auto;
            padding: 20px;
            margin-top: 220px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .input {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit {
            text-align: center;
        }

        input[type="submit"] {
            background-color: #007bf;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (isset($errorMsg)) echo "<div class='error-message'>$errorMsg</div>"; ?>
        <h1>Login</h1>
        <form method="post">
            <div class="input">
                <label for="user">Username</label>
                <input type="text" name="user" id="user" placeholder="Username" required />
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required />
            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Login" />
            </div>
        </form>
    </div>
</body>

</html>
