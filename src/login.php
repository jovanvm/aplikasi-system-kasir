<?php
session_start();
include 'koneksi.php';

// Jika sudah login
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users 
                                  WHERE username='$username' 
                                  AND password='$password'");

    if (mysqli_num_rows($query) > 0) {

        $data = mysqli_fetch_assoc($query);

        $_SESSION['id_user'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistem Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e342e, #8d6e63);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background-color: #f3ede6;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .login-title {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: #4e342e;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-brown {
            background-color: #6d4c41;
            color: white;
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-brown:hover {
            background-color: #5d4037;
        }

        .alert {
            border-radius: 8px;
        }
    </style>

</head>
<body>

<div class="login-card">

    <h4 class="login-title">Sistem Kasir</h4>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" name="login" class="btn btn-brown w-100">
            Login
        </button>

    </form>

</div>

</body>
</html>