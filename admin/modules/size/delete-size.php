<?php

function deletesize($conn, $sizeID)
{
    // Chuẩn bị câu truy vấn DELETE
    $sqlDeletesize = "DELETE FROM sizes WHERE id = '$sizeID'";
    // Thực thi câu truy vấn
    $queryDeletesize = mysqli_query($conn, $sqlDeletesize);
    if ($queryDeletesize) {
        // Xóa thành công, chuyển hướng về trang danh mục
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=size"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang size -->
<?php
    } else {
        echo "Lỗi khi xóa danh mục: " . mysqli_error($conn);
    }
}

?>