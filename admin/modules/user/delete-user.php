<?php

function deleteUser($conn, $userID)
{
    // Chuẩn bị câu truy vấn DELETE
    $sqlDeleteUser = "DELETE FROM users WHERE id = '$userID'";
    // Thực thi câu truy vấn
    $queryDeleteUser = mysqli_query($conn, $sqlDeleteUser);
    if ($queryDeleteUser) {
        // Xóa thành công, chuyển hướng về trang user
        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=user"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang user -->
<?php
    } else {
        echo "Lỗi khi xóa thành viên: " . mysqli_error($conn);
    }
}

?>