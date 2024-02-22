<?php
$conn = initConnection();
if (isset($_POST['dang-ky-thanh-vien'])) {
    $name_customer = $_POST['ten_dang_nhap'];
    $email = $_POST['email'];
    $phone = $_POST['so_dien_thoai'];
    $pass = $_POST['mat_khau'];
    $address = $_POST['dia_chi'];
    $full_name = $_POST['ho_ten'];

    // Kiểm tra dữ liệu đã được nhập hay chưa
    if (empty($name_customer) || empty($email) || empty($phone) || empty($pass) || empty($address) || empty($full_name)) {
        echo '<p style="font-size: 20px ; color:red; font-weight:bold; padding:7px; border: 1px solid red; width:355px;"> Vui lòng điền đầy đủ thông tin.</p>';
    } else {
        // Kiểm tra email đã tồn tại hay chưa
        $sqlCheckEmail = mysqli_query($conn, "SELECT COUNT(*) AS count FROM customer WHERE email = '$email'");
        $rowEmail = mysqli_fetch_assoc($sqlCheckEmail);
        $emailCount = $rowEmail['count'];

        // Kiểm tra số điện thoại đã tồn tại hay chưa
        $sqlCheckPhone = mysqli_query($conn, "SELECT COUNT(*) AS count FROM customer WHERE so_dien_thoai = '$phone'");
        $rowPhone = mysqli_fetch_assoc($sqlCheckPhone);
        $phoneCount = $rowPhone['count'];

        if ($emailCount > 0) {
            echo '<p style="font-size: 20px ; color:red; font-weight:bold; padding:7px; border: 1px solid red; width:355px;"> Email đã tồn tại. Vui lòng chọn email khác.</p>';
        } elseif ($phoneCount > 0) {
            echo '<p style="font-size: 20px ; color:red; font-weight:bold; padding:7px; border: 1px solid red; width:480px;"> Số điện thoại đã tồn tại. Vui lòng chọn số điện thoại khác.</p>';
        } else {
            // Thực hiện truy vấn INSERT
            $sqlDangKi = mysqli_query($conn, "INSERT INTO customer(ten_dang_nhap, email, so_dien_thoai, mat_khau, dia_chi, ho_ten) VALUES ('$name_customer', '$email', '$phone', '$pass', '$address', '$full_name')");

            if (!$sqlDangKi) {
                $error = mysqli_error($conn);
                echo '<p style="font-size: 20px ; color:red; font-weight:bold; padding:7px; border: 1px solid red; width:355px;"> Đăng ký thất bại. Lỗi: ' . $error . '</p>';
            } else {
                // Truy vấn lại ID khách hàng
                $sqlGetCustomerId = mysqli_query($conn, "SELECT id FROM customer WHERE email = '$email'");
                $rowCustomer = mysqli_fetch_assoc($sqlGetCustomerId);
                $customer_id = $rowCustomer['id'];

                echo '<p style="font-size: 20px ; color:red; font-weight:bold; padding:7px; border: 1px solid red; width:355px;"> Bạn đã đăng kí thành công !!!</p>';
                $_SESSION['dang-ky-thanh-vien'] = $full_name;
                $_SESSION['id'] = $customer_id;
                header("location:index.php?page=cart");
            }
        }
    }
}

?>

<div class="col l-10 m-12 c-12">
    <div class="payment-cart-list" style="padding-top:0;">
        <div class="container-payment">
            <form action="" method="post" id="form-send-cart">
                <div class="container-payment-left">
                    <div class="container-payment-top-left" style="padding-top:0;">
                        <div class="cart-payment-wrap">
                            <div class="title-c-ct">Đăng ký thành viên</div>

                            <div class="box-add-new-address-cart" id="js-box-add-new-address-cart" style="display:block;">
                                <div class="box-create-address-tk-ct">
                                    <div class="item-tk">
                                        <label>Tên đăng nhập</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="ten_dang_nhap" id="buyer-name" class="inputText" placeholder="Tên đăng nhập...">
                                        </div>
                                    </div>
                                    <div class="item-tk">
                                        <label>Email</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="email" id="buyer-email" class="inputText" placeholder="Nhập email...">
                                        </div>
                                    </div>
                                    <div class="item-tk">
                                        <label>Số điện thoại</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="so_dien_thoai" id="buyer-phone" class="inputText" placeholder="Nhập số điện thoại...">
                                        </div>
                                    </div>
                                    <div class="item-tk">
                                        <label>Mật khẩu</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="mat_khau" id="buyer-pass" class="inputText" placeholder="Mật khẩu...">
                                        </div>
                                    </div>
                                    <div class="item-tk">
                                        <label>Địa chỉ</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="dia_chi" id="buyer-address" class="inputText" placeholder="Địa chỉ...">
                                        </div>
                                    </div>
                                    <div class="item-tk" style="margin-bottom: 20px;">
                                        <label>Họ tên</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="ho_ten" id="buyer-fullname" class="inputText" placeholder="Nhập tên đầy đủ...">
                                        </div>
                                    </div>
                                    <div class="item-tk" >

                                        <div class="item-tk-ct" style="float:right;" >
                                            <input type="submit" name="dang-ky-thanh-vien" id="buyer-email" class="inputText" placeholder="Nhập email" value="Đăng ký" style="color:red; font-weight:bold ;">
                                           <a href="index.php?page=dang-nhap" class="dang-nhap">Đăng nhập nếu có tài khoản</a> 
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>
