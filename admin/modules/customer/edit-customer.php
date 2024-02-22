<!-- PHẦN THÂN SỬA KHÁCH HÀNG -->
<?php
// Kết nối đến CSDL 
$conn = initConnection();

if (isset($_GET['id'])) { // Nếu tồn tại id trên đường dẫn thì thực hiện sửa
    $id = $_GET['id'];

    /* HIỂN THỊ RA THÔNG TIN CỦA KHÁCH HÀNG ĐANG SỬA */
    // Chuẩn bị câu truy vấn
    $sqlOldCustomer = "SELECT * FROM customer WHERE id = $id";
    // Thực thi câu truy vấn
    $queryOldCustomer = mysqli_query($conn, $sqlOldCustomer);
    // Lấy dữ liệu
    if (mysqli_num_rows($queryOldCustomer) > 0) {
        $resultOldCustomer = mysqli_fetch_assoc($queryOldCustomer);
    } else {
        header("location:index.php?page=customer");
        exit();
    }
} else {
    header("location:index.php?page=customer");
    exit();
}

// Xử lý khi nhấn nút "Cập nhật"
if (isset($_POST['sbm'])) {
    $cus_name_login = $_POST['ten_dang_nhap'];
    $cus_email = $_POST['email'];
    $cus_pass = $_POST['mat_khau'];
    $cus_full_name = $_POST['ho_ten'];

    // Kiểm tra xem tên đăng nhập hoặc email đã tồn tại trong cơ sở dữ liệu chưa
    $checkQuery = "SELECT * FROM customer WHERE (ten_dang_nhap = '$cus_name_login' OR email = '$cus_email') AND id <> $id";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        // Tên đăng nhập hoặc email đã tồn tại
        echo  '<div class="danger">Tên đăng nhập hoặc địa chỉ email đã tồn tại!</div>';
    } else {
        // Tiến hành cập nhật thông tin khách hàng vào cơ sở dữ liệu
        $updateQuery = "UPDATE customer SET ten_dang_nhap = '$cus_name_login', email = '$cus_email', mat_khau = '$cus_pass', ho_ten = '$cus_full_name' WHERE id = $id";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            // Cập nhật thông tin khách hàng thành công
            echo "Cập nhật thông tin khách hàng thành công!";
            header_remove(); // Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
            <meta http-equiv="refresh" content="0;index.php?page=customer">
<?php
        } else {
            // Xảy ra lỗi khi cập nhật thông tin khách hàng
            echo "Đã xảy ra lỗi khi cập nhật thông tin khách hàng: " . mysqli_error($conn);
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
                    Sửa thông tin của khách hàng
                </a>
            </li>
        </ul>
        <h1 class="page-header">Khách hàng: <?php echo $resultOldCustomer['ho_ten']; ?> </h1>

        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input name="ten_dang_nhap" value="<?php echo $resultOldCustomer['ten_dang_nhap']; ?>" required class="form-control" placeholder="Nhập tên đăng nhập...">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" required value="<?php echo $resultOldCustomer['email']; ?>" class="form-control" style="background-color: rgb(172, 172, 172); color:#030303">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input name="mat_khau" value="<?php echo $resultOldCustomer['mat_khau']; ?>" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Họ và tên</label>
                <input name="ho_ten" required value="<?php echo $resultOldCustomer['ho_ten']; ?>" class="form-control">
            </div>
            <button name="sbm" type="submit" class="btn-update">Cập Nhật</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>
</div>