<?php

function deletetrademark($conn, $trademarkID)
{
    // Chuẩn bị câu truy vấn DELETE
    $sqlDeletetrademark = "DELETE FROM trademark WHERE id = '$trademarkID'";
    // Thực thi câu truy vấn
    $queryDeletetrademark = mysqli_query($conn, $sqlDeletetrademark);
    if ($queryDeletetrademark) {
        // Xóa thành công, chuyển hướng về trang danh mục
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=trademark"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang trademark -->
<?php
    } else {
        echo "Lỗi khi xóa danh mục: " . mysqli_error($conn);
    }
}

?>