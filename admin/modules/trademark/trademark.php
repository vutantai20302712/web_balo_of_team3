<!-- PHẦN THÊM CỦA Thương hiệu -->
<?php
//Thiết lập kết nối đến cơ sở dữ liệu
$conn = initConnection();
include_once 'delete-trademark.php';
//Câu truy vấn đến cơ sở dữ liệu
$sqlAlltrademark = "SELECT * FROM trademark";
//Thực hiện truy vấn 
$queryAlltrademark = mysqli_query($conn, $sqlAlltrademark);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $trademarkID = $_GET['id'];
    // Gọi hàm xóa Thương hiệu

    deletetrademark($conn, $trademarkID);
}

/* PHÂN TRANG */
$limit = 5;
//Tìm tổng số trang
$sqlTotalRecords = "SELECT id FROM trademark";
$queryTotalRecords = mysqli_query($conn, $sqlTotalRecords);
$TotalRecords = mysqli_num_rows($queryTotalRecords); //Tổng bản ghi
$TotalPages = ceil($TotalRecords / $limit); //Tổng số trang có
//Bắt đầu tìm
if (isset($_GET['current_page'])) {
    $current_page = $_GET['current_page'];
} else {
    $current_page = 1; //Không có current_page gắn mặc định về trang 1
}

if ($current_page < 1) {
    $current_page = 1;
}

if ($current_page > $TotalPages && $TotalPages > 1) {
    $current_page = $TotalPages;
}

$start = ($current_page - 1) * $limit;

$sqlALLtrademark = "SELECT * FROM trademark LIMIT $start, $limit";
$queryALLtrademark = mysqli_query($conn, $sqlALLtrademark);


/*TỰ ĐỘNG CẬP NHẬT ID KHI XÓA ĐI THEO THỨ TỰ TỪ BÉ ĐẾN LỚN*/

$sqlGettrademark = "SELECT id FROM trademark ORDER BY id ASC";

// Thực thi câu truy vấn
$queryGettrademark = mysqli_query($conn, $sqlGettrademark);

// Mảng chứa các ID Thương hiệu
$trademarkIds = [];

// Lặp qua các bản ghi và lưu các ID vào mảng
while ($row = mysqli_fetch_assoc($queryGettrademark)) {
    $trademarkIds[] = $row['id'];
}

// Cập nhật lại giá trị ID
$newId = 1;
foreach ($trademarkIds as $trademarkId) {
    // Câu truy vấn cập nhật ID mới cho bản ghi
    $sqlUpdateId = "UPDATE trademark SET id = $newId WHERE id = $trademarkId";

    // Thực thi câu truy vấn
    $queryUpdateId = mysqli_query($conn, $sqlUpdateId);

    $newId++;
}

// Đặt lại giá trị AUTO_INCREMENT cho bảng Thương hiệu
$sqlResetAutoIncrement = "ALTER TABLE trademark AUTO_INCREMENT = $newId";
$queryResetAutoIncrement = mysqli_query($conn, $sqlResetAutoIncrement);

/*END UPDATE ID*/
$conn = closeConnection();

// Bao gồm tệp tin chứa hàm deletetrademark() trước khi sử dụng nó

?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-folder-open" style="margin-right: 10px;"></i>
                    Trang quản lí Thương hiệu
                </a>
            </li>
        </ul>
        <h1 class="page-header">Quản lý Thương hiệu </h1>
        <div class="list-member">
            <a href="index.php?page=add-trademark" class="icon-and-addmember">
                <div class="add-member">
                    <ul class="quanli-icon-title">
                        <li>
                            <i class="fa-solid fa-plus"></i>
                            Thêm Thương hiệu
                        </li>
                    </ul>

                </div>
            </a>
            <div class="table-member-1">
                <table>
                    <thead>
                        <tr>
                            <th style>
                                <div class="use-member">ID</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Tên Thương hiệu</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Hành động</div>
                                <div class="member-cell"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($TotalRecords > 0) {
                            $index = 1; // Biến đếm để hiển thị số thứ tự của Thương hiệu trên trang

                            while ($trademark = mysqli_fetch_assoc($queryALLtrademark)) {
                        ?>
                                <tr>
                                    <td><?php echo $trademark['id']; ?></td>
                                    <td><?php echo $trademark['ten']; ?></td>
                                    <td class="form-group">
                                        <a href="index.php?page=edit-trademark&id=<?php echo $trademark['id']; ?>" class="pencil-primary">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="index.php?page=trademark&action=delete&id=<?php echo $trademark['id']; ?>" class="gliphycon-remove" onclick="return confirmDelete();">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                                $index++;
                            }
                        }
                        ?>


                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                <nav>
                    <ul class="pagination">
                        <?php
                        if ($current_page > 1) {
                            $prev = $current_page - 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=trademark&current_page=' . $prev . '">«</a></li>';
                        }

                        ?>
                        <?php
                        for ($i = 1; $i <= $TotalPages; $i++) {
                        ?>
                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                <a href="index.php?page=trademark&current_page= <?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($current_page < $TotalPages && $TotalPages > 1) {
                            $next = $current_page + 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=trademark&current_page=' . $next . '">»</a></li>';
                        }

                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        return confirm("Bạn có chắc muốn xóa")
    }
</script>