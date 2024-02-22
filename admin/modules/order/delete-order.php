<?php

function deleteorder($conn, $orderID)
{
    // Bắt đầu transaction
    mysqli_begin_transaction($conn);

    try {
        // Xóa chi tiết sản phẩm trước
        $deleteOrderDetail = "DELETE FROM order_details WHERE don_hang_id = '$orderID'";
        $deleteResult = mysqli_query($conn, $deleteOrderDetail);

        // Tiếp theo, xóa đơn hàng chính
        $sqlDeleteorder = "DELETE FROM orders WHERE id = '$orderID'";
        $queryDeleteorder = mysqli_query($conn, $sqlDeleteorder);

        // Nếu cả hai truy vấn đều thành công, thì commit transaction
        if ($deleteResult && $queryDeleteorder) {
            mysqli_commit($conn);
            // Xóa thành công, chuyển hướng về trang danh mục
            header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
            <meta http-equiv="refresh" content="0;index.php?page=order"> ;
<?php
        } else {
            // Nếu có lỗi ở bất kỳ truy vấn nào, rollback transaction
            mysqli_rollback($conn);
            echo "Lỗi khi xóa đơn hàng: " . mysqli_error($conn);
        }
    } catch (Exception $e) {
        // Nếu có lỗi xảy ra, cũng rollback transaction
        mysqli_rollback($conn);
        echo "Lỗi khi xóa đơn hàng: " . $e->getMessage();
    }
}

?>