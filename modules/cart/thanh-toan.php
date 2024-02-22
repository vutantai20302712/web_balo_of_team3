<?php
session_start();
include_once '../../config/db.php';
$conn = initConnection();

// Kiểm tra xem thông tin khách hàng đã được lưu trong session hay chưa
// Lấy thông tin khách hàng từ session
$id_khach_hang = $_SESSION['id'];
$ma_don_hang = rand(0, 9999);
$trang_thai = 1;

// Lấy thông tin khách hàng từ cơ sở dữ liệu
$query = "SELECT ho_ten, so_dien_thoai, dia_chi, email FROM customer WHERE id = ".$id_khach_hang;
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['ho_ten'];
    $phone = $row['so_dien_thoai'];
    $address = $row['dia_chi'];
    $email = $row['email'];
    

  // Thêm đơn hàng vào cơ sở dữ liệu
// Thêm đơn hàng vào cơ sở dữ liệu
$insert_order = "INSERT INTO orders(ten_nguoi_nhan, so_dien_thoai_nguoi_nhan, dia_chi_nguoi_nhan, email_nguoi_nhan, khach_hang_id, ma_don_hang, trang_thai) 
                VALUES ('".$name."','".$phone."','".$address."','".$email."','".$id_khach_hang."','".$ma_don_hang."', $trang_thai)";
$order_query = mysqli_query($conn, $insert_order);

if ($order_query) {
$id_order = mysqli_insert_id($conn); // Lấy ID đơn hàng vừa thêm

// Thêm chi tiết đơn hàng
// Thêm chi tiết đơn hàng
foreach ($_SESSION['cart'] as $key => $value) {
  $id_product = $value['id'];
  $price = $value['gia'];
  $quantity = $value['so_luong'];
  $img_PRD = $value['hinh_anh'];
  $tong_tien = $value['gia'] * $value['so_luong'];

  $insert_order_details = "INSERT INTO order_details(don_hang_id, san_pham_id, gia, so_luong, hinh_anh, tong_tien) 
                          VALUES ('".$id_order."','".$id_product."','".$price."','".$quantity."','".$img_PRD."','".$tong_tien."')";
  mysqli_query($conn, $insert_order_details);
}


// Xóa giỏ hàng sau khi hoàn tất đơn hàng
unset($_SESSION['cart']);

// Chuyển hướng người dùng đến trang thành công
header("location: ../../index.php?page=success");
exit();
} else {
// Xử lý khi thêm đơn hàng không thành công
echo "Lỗi thêm đơn hàng: ".mysqli_error($conn);
}
} else {
    // Xử lý khi truy vấn không thành công
    echo "Lỗi truy vấn: ".mysqli_error($conn);
}
?>