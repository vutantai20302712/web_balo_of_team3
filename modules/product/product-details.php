<!-- PHẦN THÂN CHI TIẾT SẢN PHẨM -->
<?php
if (isset($_GET['id'])) {
  $conn = initConnection();
  $productID = $_GET['id'];
  $sqlQuantity = "SELECT so_luong FROM products WHERE id = $productID";
  $queryQuantity = mysqli_query($conn, $sqlQuantity);
  if (mysqli_num_rows($queryQuantity) > 0) {
    $quantity = mysqli_fetch_assoc($queryQuantity)['so_luong'];
  }
  $sqlDetailsPRD = "SELECT * FROM products WHERE id = $productID";
  $queryDetailsPRD = mysqli_query($conn, $sqlDetailsPRD);
  if (mysqli_num_rows($queryDetailsPRD) > 0) {
    $product = mysqli_fetch_assoc($queryDetailsPRD);
  }
} else {
  header("location:index.php");
}
?>

<!-- APP CONTAINER -->
<div class="app__container">
  <div class="grid wide">

    <div class="col l-12 m-12 c-12">
      <!-- CHI TIẾT SẢN PHẨM -->
      <nav class="product" style="margin-top:0; margin-bottom:40px;">
        <form action="modules/cart/add-to-cart.php?id=<?php echo $product['id']; ?>" method="post">
          <div class="product_heading">
            <h1>
              <?php echo $product['ten_san_pham']; ?>
            </h1>
          </div>
          <div class="row sm-gutter app__content">
            <div class="col l-5">
              <a class="product_left">
                <div class="product-img">
                  <img src="assets/img/<?php echo $product['hinh_anh']; ?>" alt="" class="product-img-sp1">
                </div>
              </a>
            </div>
            <div class="col l-7">
              <div class="product_right">
                <div class="product_details-info">
                  <div class="product_details-meta">
                    <div class="product_details-sku">
                      ID sản phẩm: <span class="sku"><?php echo $product['id'] ?></span>
                    </div>

                  </div>

                  <div class="product-summary-item" style="padding: 0;">
                    <div class="product-summary-item-title" style="font-size:20px; font-weight:bold; color:white">Thông tin về sản phẩm này:</div>
                    <ul class="product-summary-item-ul flex-wrap" id="">
                      <li style="margin-bottom:7px">
                        Kích Thước: <?php
                                    $sqlAllsizes = "SELECT * FROM sizes ORDER BY id";
                                    $queryAllsizes = mysqli_query($conn, $sqlAllsizes);
                                    ?>
                        <select name="sizes" class="form-control">
                          <?php
                          while ($row = mysqli_fetch_assoc($queryAllsizes)) {
                          ?>
                            <option <?php
                                    if ($product['sizes'] == $row['id']) {
                                      echo 'selected';
                                    }
                                    ?> value=<?php echo $row['id']; ?>><?php echo $row['ten']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </li>
                      <li style="margin-bottom:7px">
                        Màu sắc: <?php
                                  $sqlAllcolors = "SELECT * FROM colors ORDER BY id";
                                  $queryAllcolors = mysqli_query($conn, $sqlAllcolors);
                                  ?>
                        <select name="colors" class="form-control">
                          <?php
                          while ($row = mysqli_fetch_assoc($queryAllcolors)) {
                          ?>
                            <option <?php
                                    if ($product['colors'] == $row['id']) {
                                      echo 'selected';
                                    }
                                    ?> value=<?php echo $row['id']; ?>><?php echo $row['ten']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </li>
                      <li style="margin-bottom:7px">
                        Thương hiệu :
                        <?php
                        $brandID = $product['thuong_hieu_id'];
                        $sqlBrand = "SELECT ten FROM trademark WHERE id = $brandID";
                        $queryBrand = mysqli_query($conn, $sqlBrand);
                        $brandName = mysqli_fetch_assoc($queryBrand)['ten'];
                        echo $brandName;
                        ?>
                      </li>
                      <li style="margin-bottom:7px">
                        Số ngăn : <?php echo $product['so_ngan'] ?>
                      </li>
                      <li style="margin-bottom:7px">
                        Chất liệu : <?php echo $product['chat_lieu'] ?>
                      </li>
                    </ul>

                  </div>
                  <div class="price-2021" id="product-info-price">

                    <div class="price_new">
                      <p style="font-size: 14px;">Giá ưu đãi đặc biệt:</p>
                      <strong class="price_promotion" id="js-pd-price">
                        <?php echo number_format($product['gia'], 0, ',', '.'); ?>₫
                      </strong>

                    </div>
                    <div class="product_summary-item ribbons">
                      <div class="yellow-ribbon" style="display: inline-block; background:none ; color:#fff; font-size:15px ; font-weight:bold">
                        Số lượng hiện còn:
                      </div>
                      <div class="yellow-ribbon" style="margin-left:8px; font-size:15px ;display: inline-block; text-align:center; font-weight:bold; color:black;">
                        <?php echo $product['so_luong'] ?>
                      </div>
                    </div>
                  </div>
                  <div class="box-number-quan-detail">
                    <p><input class="add-to-cart" name="add-to-cart" type="submit" value="Thêm Giỏ Hàng" style="width:200px;border-radius:5px;color:black;font-weight:bold;font-size:16px; cursor:pointer"></p>
                    <a href="" class="like-product" title="Thích sản phẩm này " onclick="">
                      <i class="fa-sharp fa-solid fa-heart" style="color:red"></i>
                    </a>
                  </div>
                  <div class="clear"></div>

                  <div id="button-buy" class="d-flex flex-wrap justify-content-start">
                    <div class="top-button">
                      <?php
                      if (isset($_SESSION['dang-ky-thanh-vien'])) {
                        echo ' <a style href="index.php?page=cart" onclick="" class="buy-now">
                                     <span>Đặt mua ngay</span>
                                 </a>';
                      ?>
                      <?php
                      } else {
                        echo ' <a style href="index.php?page=dang-ky-thanh-vien" onclick="" class="buy-now">
                                           <span>Đặt mua ngay</span>
                                   </a>';
                      }
                      ?>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </form>
      </nav>

    </div>

  </div>
</div>
<!--  FOOTER -->