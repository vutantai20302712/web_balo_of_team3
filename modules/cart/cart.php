<!-- PHẦN THÂN GIỎ HÀNG -->
<?php

?>
<div class="app__container">
    <div class="grid wide">
        <div class="row sm-gutter app__content" style="padding-top:0; margin-bottom:20px;">
            <div class="col l-12 m-12 c-12">
            <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    
            ?>
                <!-- GIỎ HÀNG -->
                <nav class="cart">
                    <div class="cart-heading">
                        <h1>GIỎ HÀNG:
                            <?php
                                if(isset($_SESSION['dang-ky-thanh-vien'])) {
                                    echo '<span style="color:red">'.$_SESSION['dang-ky-thanh-vien'].'</span>';
                                }
                            ?>
                        </h1>
                    </div>

                    <?php
                    if (isset($_SESSION['cart'])) {
                    }
                    ?>
                    <table style="width:100%; color:black; font-size:15px ;font-weight:bold ; text-align:center; border-collapse:collapse; background-color:white;" border="1">
                        <tr>
                            <th style="padding:18px;">ID đơn hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thành tiền</th>
                            <th>Quản lý</th>
                        </tr>
                        <?php
                        if (isset($_SESSION['cart'])) {
                            $i = 0;
                            $tong_tien = 0;

                            foreach ($_SESSION['cart'] as $cart_items) {
                                $thanhtien = $cart_items['so_luong'] * $cart_items['gia'];
                                $tong_tien += $thanhtien;
                                $i++;
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td style="padding-left:10px;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis; max-width: 300px;">
                                        <?php echo $cart_items['ten_san_pham']; ?>
                                    </td>
                                    <td style="width:90px ; height:120px;margin:10px;">
                                        <img src="assets/img/<?php echo $cart_items['hinh_anh']; ?>" alt="" class="product-img-sp1">
                                    </td>
                                    <td >
                                        <a href="modules/cart/add-to-cart.php?plus=<?php echo $cart_items['id']; ?>" style="text-decoration:none; color:red;"><i class="fa-solid fa-plus"></i></a>
                                        <?php echo $cart_items['so_luong']; ?>
                                        <a href="modules/cart/add-to-cart.php?less=<?php echo $cart_items['id']; ?>" style="text-decoration:none; color:red;"><i class="fa-solid fa-minus"></i></a>
                                    </td>
                                    <td><?php echo number_format($cart_items['gia'], 0, ',', '.'); ?>₫</td>
                                    <td><?php echo number_format($thanhtien, 0, ',', '.'); ?>₫</td>
                                    <th><a href="modules/cart/add-to-cart.php?delete=<?php echo $cart_items['id']; ?> " onclick="return confirmDelete();"><i class="fa-solid fa-trash" style="color:black;"></i></a></th>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="7" style="padding:25px;">
                                    <p style="float:left; color:red ; font-size:15px">Tổng tiền: <?php echo number_format($tong_tien, 0, ',', '.'); ?>₫</p>
                                    <p style="float:right;"><a href="modules/cart/add-to-cart.php?delete_all=1" onclick="return confirmDelete();"><i class="fa-solid fa-trash-can" style="color:red"></i></a></p>
                                    <div style="clear:both;"></div>
                                    <?php  
                                        if(isset($_SESSION['dang-ky-thanh-vien'])) {
                                            ?>
                                            <p><a href="modules/cart/thanh-toan.php" style="text-decoration:none; padding:15px; border: 1px solid #999; border-radius:5px;color:#fff ;background-color:#999;">Đặt hàng</a></p>
                                            <?php
                                        } else {
                                        ?>
                                          <p><a href="index.php?page=dang-ky-thanh-vien"  style="text-decoration:none; padding:15px; border: 1px solid #999; border-radius:5px;color:#fff ;background-color:#999;">Đăng ký đặt hàng</a></p>
                                          <?php        
                                        }
                                  ?>
                                </td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td colspan="7">
                                    <p><img src="assets/img/IMG_cart/empty-cart.png" alt="" width="400" height="400"></p>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>

                </nav>
            </div>

        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm("Bạn có chắc muốn xóa");
    }
</script>