<!-- PHẦN THÂN CỦA THÊM THÀNH VIÊN -->

<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    Trang thêm thành viên
                </a>
            </li>
        </ul>
        <h1 class="page-header">Thêm thành viên </h1>


        <form action="index.php?page=add-user-process" role="form" method="post">
            <?php if (isset($_SESSION['error_name'])) {
                echo $_SESSION['error_name'];
                unset($_SESSION['error_name']);
            }
            ?>
            <div class="form-group">
                <label>Họ và Tên</label>
                <input name="ho_ten" required class="form-control" placeholder="">
            </div>
            <?php if (isset($_SESSION['error_email'])) {
                echo $_SESSION['error_email'];
                unset($_SESSION['error_email']);
            }

            ?>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" required class="form-control">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input name="mat_khau" type="password" required class="form-control">
            </div>
            <?php if (isset($_SESSION['error_confirm_pass'])) {
                echo $_SESSION['error_confirm_pass'];
                unset($_SESSION['error_confirm_pass']);
            }
            ?>
            <div class="form-group">
                <label>Nhập lại mật khẩu</label>
                <input name="user_passagain" type="password" required class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Quyền</label>
                <select name="cap_do" class="form-control">
                    <option value="1">Admin</option>
                    <option value="2">Member</option>
                </select>
            </div>
            <button name="sbm" type="submit" class="btn-sucess">Thêm mới</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>

    </div>