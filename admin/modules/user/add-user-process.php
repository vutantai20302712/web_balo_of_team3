<?php
$user_name = $_POST['ho_ten'];
$user_mail = $_POST['email'];
$user_pass = $_POST['mat_khau'];
$user_confirm_pass = $_POST['user_passagain']; // Đã thêm biến để xác nhận mật khẩu
$user_level = $_POST['cap_do'];

//Kiểm tra xem mật khẩu xác nhận có khớp với mật khẩu đã nhập không
if ($user_pass !== $user_confirm_pass) {
    $_SESSION['error_confirm_pass'] = '<div class="danger">Mật khẩu xác nhận không khớp!</div>';
    header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
    <meta http-equiv="refresh" content="0;index.php?page=add-user"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang user-->
<?php
}

// Tiếp tục với phần còn lại của mã nếu mật khẩu xác nhận là chính xác

// Thiet lap ket noi
$conn = initConnection();

// Kiểm tra email có tồn tại hay không
$sqlExists = "SELECT * FROM users WHERE email = '$user_mail'";
$sqlName = "SELECT * FROM users WHERE ho_ten = '$user_name'";
$sqlQuery = mysqli_query($conn, $sqlExists);

if (mysqli_num_rows($sqlQuery) > 0) {
    $_SESSION['error_email'] = '<div class="danger">Email bạn vừa nhập đã tồn tại!</div>';
    header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
    <meta http-equiv="refresh" content="0;index.php?page=add-user"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang user-->
    <?php
}

$queryName = mysqli_query($conn, $sqlName);
if (mysqli_num_rows($queryName) > 0) {
    $_SESSION['error_name'] = '<div class="danger">Tên bạn vừa nhập đã tồn tại!</div>';
    header("location: index.php?page=add-user");
    exit();
} else {
    $sqlInsert = "INSERT INTO users(ho_ten, email, mat_khau, cap_do) VALUES ('$user_name', '$user_mail', '$user_pass', '$user_level')";
    $queryInsert = mysqli_query($conn, $sqlInsert);
    if ($queryInsert) {
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
    ?>
        <meta http-equiv="refresh" content="0;index.php?page=user"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang user-->
<?php
    } else {
        $_SESSION['error_insert'] = '<div class="danger">Lỗi khi thêm dữ liệu!</div>';
        header("location: index.php?page=add-user");
        exit();
    }
}
?>