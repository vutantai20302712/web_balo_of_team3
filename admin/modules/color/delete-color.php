<?php

function deletecolor($conn, $colorID)
{
    // Chuẩn bị câu truy vấn DELETE
    $sqlDeletecolor = "DELETE FROM colors WHERE id = '$colorID'";
    // Thực thi câu truy vấn
    $queryDeletecolor = mysqli_query($conn, $sqlDeletecolor);
    if ($queryDeletecolor) {
        // Xóa thành công, chuyển hướng về trang danh mục
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=color"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang color -->
<?php
    } else {
        echo "Lỗi khi xóa màu: " . mysqli_error($conn);
    }
}

?>