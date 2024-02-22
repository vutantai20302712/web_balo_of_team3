<?php
include_once "../../config/db.php";
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // Thực hiện cập nhật trạng thái đơn hàng trong cơ sở dữ liệu
    $conn = initConnection();
    $newStatus = 5; // Đã hủy
    $updateSql = "UPDATE orders SET trang_thai = '$newStatus' WHERE id = '$order_id'";
    
    if (mysqli_query($conn, $updateSql)) {
        // Đã cập nhật thành công, bạn có thể thực hiện các hành động khác ở đây
        header("Location:../../index.php?page=lich_su_mua"); // Chuyển hướng về trang danh sách đơn hàng
        exit;
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
} else {
    echo "No order ID provided.";
}
?>
