<?php
$conn = initConnection();

//Thông báo khi có lỗi
$error_message = '';

if (isset($_POST['sbm'])) {
    $cus_name_login = $_POST['ten_dang_nhap'];
    $cus_email = $_POST['email'];
    $cus_pass = $_POST['mat_khau'];
    $cus_full_name = $_POST['ho_ten'];

    // Kiểm tra xem tên đăng nhập hoặc địa chỉ email đã tồn tại trong cơ sở dữ liệu hay chưa
    $checkQuery = "SELECT * FROM customer WHERE ten_dang_nhap = '$cus_name_login' OR email = '$cus_email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Tên đăng nhập hoặc địa chỉ email đã tồn tại
        $error_message = '<div class="danger">Tên đăng nhập hoặc địa chỉ email đã tồn tại!</div>';
    } else {
        // Tiến hành thêm khách hàng vào cơ sở dữ liệu
        $query = "INSERT INTO customer (ten_dang_nhap, email, mat_khau, ho_ten) 
                  VALUES ('$cus_name_login', '$cus_email', '$cus_pass', '$cus_full_name')";

        // Thực thi truy vấn
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Thêm khách hàng thành công
            header_remove(); // Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
            ?>
                        <meta http-equiv="refresh" content="0;index.php?page=customer">
            <?php
        } else {
            // Xảy ra lỗi khi thêm khách hàng
            $error_message = "Đã xảy ra lỗi khi thêm khách hàng: " . mysqli_error($conn);
        }
    }
}
?>

<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    Trang thêm khách hàng
                </a>
            </li>
        </ul>
        <h1 class="page-header">Thêm khách hàng </h1>

        <form action="" role="form" method="post">
            <!-- Hiển thị thông báo lỗi -->
            <?php if (!empty($error_message)) : ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input name="ten_dang_nhap" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" required class="form-control">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input name="mat_khau" type="password" required class="form-control">
            </div>
            <div class="form-group">
                <label>Họ và tên</label>
                <input name="ho_ten" type="" required class="form-control" placeholder="">
            </div>
            <button name="sbm" type="submit" class="btn-sucess">Thêm mới</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>
</div>
