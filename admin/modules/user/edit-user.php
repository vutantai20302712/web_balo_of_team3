<!-- PHẦN SỬA THÀNH VIÊN  -->
<?php
// Kết nối với CSDL
$conn = initConnection();

if (isset($_GET['id'])) { // nếu tồn tại 'id' của user trên đường dẫn thì chuẩn bị thực hiện sửa.
    $id = $_GET['id'];

    /* HIỂN THỊ RA THÔNG TIN CỦA NGƯỜI DÙNG ĐANG SỬA */
    // Chuẩn bị câu truy vấn
    $sqlOldUser = "SELECT * FROM users WHERE id = $id";
    // Thực thi câu truy vấn
    $queryOldUser = mysqli_query($conn, $sqlOldUser);
    // Lấy dữ liệu
    if (mysqli_num_rows($queryOldUser) > 0) {
        // Nếu tìm được bản ghi phù hợp
        $resultOldUser = mysqli_fetch_assoc($queryOldUser);
    } else {
        // Nếu không tìm được bản ghi nào có giá trị là $_GET['id']
        header("location:index.php?page=user");
        exit();
    }

    // Kiểm tra sự tồn tại của thông tin người dùng mới
    if (isset($_POST['sbm'])) {
        $user_name = $_POST['ho_ten']; // lấy tên và email từ form gửi lên.
        $user_email = $_POST['email'];
        $user_level = $_POST['cap_do'];
        $inActive = $_POST['inActive'];

        // Chuẩn bị câu truy vấn đến CSDL
        $sqlExistsUser = "SELECT * FROM users WHERE ho_ten = '$user_name' AND id != $id";
        $sqlExistsEmail = "SELECT * FROM users WHERE email = '$user_email' AND id != $id";
        // Thực thi truy vấn đến CSDL
        $queryExistsUser = mysqli_query($conn, $sqlExistsUser);
        $queryExistsEmail = mysqli_query($conn, $sqlExistsEmail);
        if (mysqli_num_rows($queryExistsUser) > 0) {
            $_SESSION['errorExistsUser'] = '<div class="danger">Tên bạn vừa nhập đã bị trùng !</div>';
        }
        if (mysqli_num_rows($queryExistsEmail) > 0) {
            $_SESSION['errorExistsEmail'] = '<div class="danger">Email bạn vừa nhập đã bị trùng !</div>';
        }

        if (!isset($_SESSION['errorExistsUser']) && !isset($_SESSION['errorExistsEmail'])) {
            // Thực hiện (UPDATE)
            $sqlUpdateUser = "UPDATE users SET ho_ten = '$user_name', email = '$user_email' , inActive = '$inActive' , cap_do ='$user_level' WHERE id = $id";
            $queryUpdateUser = mysqli_query($conn, $sqlUpdateUser);
            if ($queryUpdateUser) {
                unset($_SESSION['errorExistsUser']);
                unset($_SESSION['errorExistsEmail']);
                header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
            ?>
                <meta http-equiv="refresh" content="0;index.php?page=user"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
            <?php
            }
        }
    }
} else {
    // Nếu không tồn tại id của category trên đường dẫn thì chuyển hướng về trang danh sách category.
    header("location:index.php?page=user");
    exit();
}
?>

<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    <?php echo 'Sửa thông tin của ' . $resultOldUser['ho_ten'] . ''; ?>
                </a>
            </li>
        </ul>
        <h1 class="page-header"> <?php echo 'Thành viên: ' . $resultOldUser['ho_ten'] . ''; ?> </h1>
        <?php if (isset($_SESSION['errorExistsUser'])) {
            echo $_SESSION['errorExistsUser'];
            unset($_SESSION['errorExistsUser']);
        } ?> <!-- Hiển thị thông báo lỗi tên -->
        <form action="" role="form" method="post">
            <div class="form-group">

                <label>Họ và Tên</label>
                <input name="ho_ten" value="<?php echo $resultOldUser['ho_ten']; ?>" required class="form-control" placeholder="Nhập tên muốn sửa...">
            </div>
            <?php if (isset($_SESSION['errorExistsEmail'])) {
                echo $_SESSION['errorExistsEmail'];
                unset($_SESSION['errorExistsEmail']);
            } ?> <!-- Hiển thị thông báo lỗi email -->
            <div class="form-group">

                <label>Email</label>
                <input name="email" type="email" required value="<?php echo $resultOldUser['email']; ?>" class="form-control" style="background-color: rgb(172, 172, 172); color:#030303" placeholder="Nhập email muốn sửa...">
            </div>
            <div class="form-group">
                <label>Quyền</label>
                <select name="cap_do" class="form-control">
                    <option value="1" <?php if ($resultOldUser['cap_do'] == 1) echo 'selected'; ?>>Admin</option>
                    <option value="2" <?php if ($resultOldUser['cap_do'] == 2 || !isset($resultOldUser['cap_do'])) echo 'selected'; ?>>Member</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kích hoạt</label>
                <select name="inActive" class="form-control">
                    <option value="0" <?php if ($resultOldUser['inActive'] == 0) echo 'selected'; ?>>Kích hoạt</option>
                    <option value="1" <?php if ($resultOldUser['inActive'] == 1) echo 'selected'; ?>>Ngưng kích hoạt</option>
                </select>
            </div>
            <button name="sbm" type="submit" class="btn-update">Cập Nhật</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>
</div>