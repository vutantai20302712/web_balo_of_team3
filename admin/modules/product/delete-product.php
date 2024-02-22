<?php

function deleteproduct($conn, $productID)
{
    // Chuẩn bị câu truy vấn DELETE
    $sqlDeleteproduct = "DELETE FROM products WHERE id = '$productID'";
    // Thực thi câu truy vấn
    $queryDeleteproduct = mysqli_query($conn, $sqlDeleteproduct);
    if ($queryDeleteproduct) {
        // Xóa thành công, chuyển hướng về trang danh mục
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=product"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang product -->
<?php
    } else {
        echo "Lỗi khi xóa sản phẩm: " . mysqli_error($conn);
    }
}

?>