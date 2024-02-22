<?php

function deletecustomer($conn, $customerID)
{
    // Chuẩn bị câu truy vấn DELETE
    $sqlDeletecustomer = "DELETE FROM customer WHERE id = '$customerID'";
    // Thực thi câu truy vấn
    $queryDeletecustomer = mysqli_query($conn, $sqlDeletecustomer);
    if ($queryDeletecustomer) {
        // Xóa thành công, chuyển hướng về trang danh mục
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=customer"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang product -->
<?php
    } else {
        echo "Lỗi khi xóa khách hàng: " . mysqli_error($conn);
    }
}

?>