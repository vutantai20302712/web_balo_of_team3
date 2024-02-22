<?php 
  
// KẾT NỐI ĐẾN CƠ SỞ DỮ LIỆU | MySQL
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'project_1_tantai');
define('DB_HOST', 'localhost');

// Method: initConnection()
// Desc: Hàm thiết lập kết nối đến CSDL
// Result: Kết nối đến CSDL

function initConnection() {
    global $conn;
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    // mysqli_connect trả về TRUE nếu được kết nối được thiết lập và ngược lại.
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    } else {
        mysqli_set_charset($conn, 'UTF8');
    }
    return $conn;
}

// Method: closeConnection()
// Desc: Hàm ngắt kết nối đến CSDL
// Result: Ngắt kết nối đến CSDL

function closeConnection() {
    global $conn;
    if ($conn) {
        mysqli_close($conn);
    }
}
