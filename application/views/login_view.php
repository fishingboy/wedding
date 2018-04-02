<?php
    if (isset($_POST['submit'])) {
        if ($_POST['user'] == $admin_user && $_POST['password'] == $admin_password) {
            $_SESSION['auth'] = 1;
            header("Location: /admin");
        } else {
            header("Content-Type:text/html; charset=utf-8");
            echo "<script>
                    alert('登入失敗');
                    window.location.href = '/admin';
                  </script>";
        }
        return false;
    }
?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/third-party/bootstrap/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="/third-party/bootstrap/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<style>
    .form-box {
        padding: 50px;
        width: 600px;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 50px;
    }
</style>
</head>
<body>
<div class="form-box">
    <form action="" method="post">
        <div class="form-group">
            帳號： <input name="user" type="text" class="form-control"> <br>
            密碼： <input name="password" type="text" class="form-control"> <br>
            <button name="submit" class="btn">登入</button>
        </div>
    </form>
</div>
</body>
</html>