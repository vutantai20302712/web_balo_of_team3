<?php
session_start();

// Kết nối đến CSDL
include_once "../config/db.php";
$conn = initConnection();

// Xử lí đăng nhập
if (empty($_POST['mail'])) {
  $_SESSION['error_email'] = '<div class="error">Email không được để trống !!!</div>';
  header("Location: login.php");
  exit();
} else {
  $mail = $_POST['mail'];
  $_SESSION['old_email'] = $mail;
}

if (empty($_POST['pass'])) {
  $_SESSION['error_pass'] = '<div class="error">Mật khẩu không được để trống !!!</div>';
  header("Location: login.php");
  exit();
} else {
  $pass = $_POST['pass'];
  $_SESSION['old_pass'] = $pass;
}

if (isset($mail) && isset($pass)) {
  // Chuẩn bị câu truy vấn sử dụng tham số truyền vào
  $sqlLogin = "SELECT * FROM users WHERE email = ? AND mat_khau = ?";
  $stmt = mysqli_prepare($conn, $sqlLogin);
  mysqli_stmt_bind_param($stmt, "ss", $mail, $pass);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (!$result) {
    die('Database query error: ' . mysqli_error($conn));
  }

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['cap_do'] == 1) { // Kiểm tra cap_do của người dùng
      $_SESSION['login'] = $row;
      header("Location: index.php");
      exit();
    } else {
      $_SESSION['error_login'] = '<div class="danger">Bạn không có quyền truy cập!</div>';
      header("Location: login.php");
      exit();
    }
  } else {
    $_SESSION['error_login'] = '<div class="danger">Tài khoản không tồn tại hoặc mật khẩu sai!</div>';
    header("Location: login.php");
    exit();
  }
}

closeConnection();
