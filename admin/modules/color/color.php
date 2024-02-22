<!-- PHẦN THÊM CỦA DANH MỤC -->
<?php
//Thiết lập kết nối đến cơ sở dữ liệu
$conn = initConnection();
include_once 'delete-color.php';
//Câu truy vấn đến cơ sở dữ liệu
$sqlAllcolors = "SELECT * FROM colors";
//Thực hiện truy vấn 
$queryAllcolors = mysqli_query($conn, $sqlAllcolors);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $colorID = $_GET['id'];
    // Gọi hàm xóa danh mục

    deletecolor($conn, $colorID);
}

/* PHÂN TRANG */
$limit = 5;
//Tìm tổng số trang
$sqlTotalRecords = "SELECT id FROM colors";
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

$sqlALLcolors = "SELECT * FROM colors LIMIT $start, $limit";
$queryALLcolors = mysqli_query($conn, $sqlALLcolors);


/*TỰ ĐỘNG CẬP NHẬT ID KHI XÓA ĐI THEO THỨ TỰ TỪ BÉ ĐẾN LỚN*/

$sqlGetcolors = "SELECT id FROM colors ORDER BY id ASC";

// Thực thi câu truy vấn
$queryGetcolors = mysqli_query($conn, $sqlGetcolors);

// Mảng chứa các ID danh mục
$colorIds = [];

// Lặp qua các bản ghi và lưu các ID vào mảng
while ($row = mysqli_fetch_assoc($queryGetcolors)) {
    $colorIds[] = $row['id'];
}

// Cập nhật lại giá trị ID
$newId = 1;
foreach ($colorIds as $colorId) {
    // Câu truy vấn cập nhật ID mới cho bản ghi
    $sqlUpdateId = "UPDATE colors SET id = $newId WHERE id = $colorId";

    // Thực thi câu truy vấn
    $queryUpdateId = mysqli_query($conn, $sqlUpdateId);

    $newId++;
}

// Đặt lại giá trị AUTO_INCREMENT cho bảng danh mục
$sqlResetAutoIncrement = "ALTER TABLE colors AUTO_INCREMENT = $newId";
$queryResetAutoIncrement = mysqli_query($conn, $sqlResetAutoIncrement);

/*END UPDATE ID*/
$conn = closeConnection();

// Bao gồm tệp tin chứa hàm deletecolor() trước khi sử dụng nó

?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-folder-open" style="margin-right: 10px;"></i>
                    Trang quản lí danh mục
                </a>
            </li>
        </ul>
        <h1 class="page-header">Quản lý danh mục </h1>
        <div class="list-member">
            <a href="index.php?page=add-color" class="icon-and-addmember">
                <div class="add-member">
                    <ul class="quanli-icon-title">
                        <li>
                            <i class="fa-solid fa-plus"></i>
                            Thêm danh mục
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
                                <div class="use-member">Tên danh mục</div>
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
                            $index = 1; // Biến đếm để hiển thị số thứ tự của danh mục trên trang

                            while ($color = mysqli_fetch_assoc($queryALLcolors)) {
                        ?>
                                <tr>
                                    <td><?php echo $color['id']; ?></td>
                                    <td><?php echo $color['ten']; ?></td>
                                    <td class="form-group">
                                        <a href="index.php?page=edit-color&id=<?php echo $color['id']; ?>" class="pencil-primary">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="index.php?page=color&action=delete&id=<?php echo $color['id']; ?>" class="gliphycon-remove" onclick="return confirmDelete();">
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
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=color&current_page=' . $prev . '">«</a></li>';
                        }

                        ?>
                        <?php
                        for ($i = 1; $i <= $TotalPages; $i++) {
                        ?>
                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                <a href="index.php?page=color&current_page= <?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($current_page < $TotalPages && $TotalPages > 1) {
                            $next = $current_page + 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=color&current_page=' . $next . '">»</a></li>';
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