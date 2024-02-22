<!-- PHẦN THÂN THÊM ĐƠN HÀNG MỚI -->
<?php
// Kết nối đến CSDL
$conn = initConnection();

// Xử lý khi form đơn hàng được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $tenNguoiNhan = $_POST["ten_nguoi_nhan"];
    $soDienThoai = $_POST["so_dien_thoai_nguoi_nhan"];
    $email = $_POST["email"];
    $diaChi = $_POST["dia_chi_nguoi_nhan"];
    $ngayDat = $_POST["created_at"];
    $trangThai = $_POST["trang_thai"];
    $tenKhachHang = $_POST['khach_hang_id'];
    $tenNguoiDung = $_POST['nguoi_dung_id'];

    // Thực hiện truy vấn để thêm đơn hàng mới
    $sql = "INSERT INTO orders (ten_nguoi_nhan, so_dien_thoai_nguoi_nhan, email_nguoi_nhan, dia_chi_nguoi_nhan, created_at, trang_thai , khach_hang_id , nguoi_dung_id) 
            VALUES ('$tenNguoiNhan', '$soDienThoai', '$email', '$diaChi', '$ngayDat', '$trangThai' ,'$tenKhachHang' , '$tenNguoiDung')";

    if (mysqli_query($conn, $sql)) {
        echo "Thêm đơn hàng mới thành công.";
        header_remove(); // Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=order">
<?php
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Đóng kết nối CSDL
mysqli_close($conn);
?>

<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    Trang đơn hàng mới
                </a>
            </li>
        </ul>
        <h1 class="page-header">Thêm đơn hàng </h1>

        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên người nhận</label>
                <input name="ten_nguoi_nhan" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input name="so_dien_thoai_nguoi_nhan" type="" required class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="" required class="form-control">
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input name="dia_chi_nguoi_nhan" type="" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Ngày đặt</label>
                <input name="created_at" type="" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Khách hàng</label>
                <input name="khach_hang_id" type="" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Người dùng</label>
                <input name="nguoi_dung_id" type="" required class="form-control" placeholder="">
            </div>
            <button name="sbm" type="submit" class="btn-sucess">Thêm mới</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>

    </div>
</div>