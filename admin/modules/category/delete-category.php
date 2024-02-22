<?php

function deleteCategory($conn, $categoryID)
{
    // Chuẩn bị câu truy vấn DELETE
    $sqlDeleteCategory = "DELETE FROM categories WHERE id = '$categoryID'";
    // Thực thi câu truy vấn
    $queryDeleteCategory = mysqli_query($conn, $sqlDeleteCategory);
    if ($queryDeleteCategory) {
        // Xóa thành công, chuyển hướng về trang danh mục
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=category"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
<?php
    } else {
        echo "Lỗi khi xóa danh mục: " . mysqli_error($conn);
    }
}

?>