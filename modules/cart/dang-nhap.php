 <?php
  $conn = initConnection();
   if(isset($_POST['dang-nhap'])) {
    $email = $_POST['email'];
    $pass = $_POST['mat_khau'];
    $sqlDangNhap = "SELECT * FROM customer WHERE email = '".$email."' AND mat_khau = '".$pass."' LIMIT 1";
    $row = mysqli_query($conn, $sqlDangNhap);
    $count = mysqli_num_rows($row);

    if($count > 0) {
        $row_data = mysqli_fetch_array($row);
        $_SESSION['dang-ky-thanh-vien'] = $row_data['ho_ten'];
        $_SESSION['id'] = $row_data['id'];
        header("Location:index.php?page=cart");
    }else {
        echo '<p style="font-size: 20px ; color:red; font-weight:bold; padding:7px; border: 1px solid red; width:355px;">Email hoặc mật khẩu sai. Vui lòng nhập lại</p>';
    }
   }

?>
<div class="col l-10 m-12 c-12">
    <div class="payment-cart-list" style="padding:0;">
        <div class="container-payment">
            <form action="" method="post" id="form-send-cart">
                <div class="container-payment-left">
                    <div class="container-payment-top-left">
                        <div class="cart-payment-wrap">
                            <div class="title-c-ct">Đăng nhập</div>

                            <div class="box-add-new-address-cart" id="js-box-add-new-address-cart" style="display:block;">
                                <div class="box-create-address-tk-ct">
                                    <div class="item-tk">
                                        <label>Email:</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="email" id="buyer-name" class="inputText" placeholder="Nhập email...">
                                        </div>
                                    </div>
                                    <div class="item-tk">
                                        <label>Mật khẩu:</label>
                                        <div class="item-tk-ct">
                                            <input type="text" name="mat_khau" id="buyer-email" class="inputText" placeholder="Nhập mật khẩu...">
                                        </div>
                                    </div>
                                    <div class="item-tk-ct" style="float:right; border-radius:4px; display:block;">
                                            <input type="submit" name="dang-nhap" id="buyer-email" class="inputText" placeholder="Nhập email" value="Đăng nhập" style="color:red; font-weight:bold ; width:100px;">
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