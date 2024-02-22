<?php
  session_start();
  include_once '../../config/db.php';
  $conn = initConnection();
  $product = array();
  //THÊM BỚT SỐ LƯỢNG SẢN PHẨM
  /* THÊM */
  if (isset($_GET['plus'])) {
    $id = $_GET['plus'];
   

    foreach ($_SESSION['cart'] as $cart_items) {
        if ($cart_items['id'] == $id) {
            // Lấy số lượng từ CSDL
            //Câu truy vấn
            $sql = "SELECT so_luong FROM products WHERE id = $id LIMIT 1";
            //Thực hiện truy vấn
            $query = mysqli_query($conn, $sql);
            // Thực hiện lấy dữ liệu từ kết quả truy vấn
            $row = mysqli_fetch_assoc($query);
            //Thông báo lỗi
            $error = '';

            if ($row && isset($row['so_luong'])) {
                // Gán 
                $so_luong_hien_co = $row['so_luong'];
                if ($cart_items['so_luong'] < $so_luong_hien_co) {
                    $tang_so_luong = $cart_items['so_luong'] + 1;
                    $product[] = array(
                        'ten_san_pham' => $cart_items['ten_san_pham'],
                        'id' => $cart_items['id'],
                        'so_luong' => $tang_so_luong,
                        'gia' => $cart_items['gia'],
                        'hinh_anh' => $cart_items['hinh_anh']
                    );
                } else {
                    // In ra thông báo lỗi khi vượt quá số lượng hiện có
                    $error = 'Số lượng sản phẩm đã đạt tối đa !!!';
                    $_SESSION['error'] = $error;
                    $product[] = $cart_items;
                }
            } else {
                // Xử lý khi không lấy được số lượng hiện có từ CSDL
                echo "Không thể lấy số lượng sản phẩm từ cơ sở dữ liệu.";
                $product[] = $cart_items;
            }
        } else {
            $product[] = $cart_items;
        }
    }

    $_SESSION['cart'] = $product;
    header("location: ../../index.php?page=cart");
}

   /* BỚT */
   if(isset($_GET['less'])) {
    $id = $_GET['less'];
     foreach($_SESSION['cart'] as $cart_items) {
        if($cart_items['id'] != $id) {
            $product[] = array('ten_san_pham' => $cart_items['ten_san_pham'] , 'id' => $cart_items['id'] , 'so_luong' => $so_luong+1,
            'gia' => $cart_items['gia'] , 'hinh_anh' => $cart_items['hinh_anh']) ;

            $_SESSION['cart'] = $product;
        }else {
            if($cart_items['so_luong'] > 1 ) {
                $giam_so_luong = $cart_items['so_luong'] - 1 ;
                $product[] = array('ten_san_pham' => $cart_items['ten_san_pham'] , 'id' => $cart_items['id'] , 'so_luong' => $giam_so_luong,
                'gia' => $cart_items['gia'] , 'hinh_anh' => $cart_items['hinh_anh']) ;
            }else {
                $product[] = array('ten_san_pham' => $cart_items['ten_san_pham'] , 'id' => $cart_items['id'] , 'so_luong' => $cart_items['so_luong'],
                'gia' => $cart_items['gia'] , 'hinh_anh' => $cart_items['hinh_anh']) ;
            }
            $_SESSION['cart'] = $product;
        }
     }
       header("location: ../../index.php?page=cart");
   }

  //XÓA 1 ĐƠN HÀNG 
  if(isset($_SESSION['cart']) && isset($_GET['delete'])) {
    $id = $_GET['delete'];
    foreach($_SESSION['cart'] as $cart_items) {
        if($cart_items['id'] != $id) {
            $product[] = array('ten_san_pham' => $cart_items['ten_san_pham'] , 'id' => $cart_items['id'] , 'so_luong' => $so_luong+1,
            'gia' => $cart_items['gia'] , 'hinh_anh' => $cart_items['hinh_anh']) ;
        }
        $_SESSION['cart'] = $product;
        header("location: ../../index.php?page=cart");
    }
  }

  //XÓA TOÀN BỘ GIỎ HÀNG
  if(isset($_GET['delete_all']) && $_GET['delete_all'] == 1 ) {
       unset($_SESSION['cart']);
       header("location: ../../index.php?page=cart");
  }

  if(isset($_POST['add-to-cart'])) {
    $id = $_GET['id'];
    $so_luong = 1;
    $sql = "SELECT * FROM products WHERE id = $id LIMIT 1";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query); 

    if($row) {
        $new_product = array(array('ten_san_pham' => $row['ten_san_pham'] , 'id' => $id , 'so_luong' => $so_luong ,
        'gia' => $row['gia'] , 'hinh_anh' => $row['hinh_anh'])) ;
        //KIỂM TRA SESSION GIO HANG TỒN TẠI
        if(isset($_SESSION['cart'])) {
            $found = false;
            foreach($_SESSION['cart'] as $cart_items) {
                // NẾU DỮ LIỆU BỊ TRÙNG
                if($cart_items['id'] == $id) {
                    $product[] = array('ten_san_pham' => $cart_items['ten_san_pham'] , 'id' => $cart_items['id'] , 'so_luong' => $so_luong+1,
                    'gia' => $cart_items['gia'] , 'hinh_anh' => $cart_items['hinh_anh']) ;

                    $found = true ;
                }else {
                    //NẾU DỮ LIỆU KHÔNG TRÙNG
                    $product[] = array('ten_san_pham' => $cart_items['ten_san_pham'] , 'id' => $cart_items['id'] , 'so_luong' => $cart_items['so_luong'] ,
                    'gia' => $cart_items['gia'] , 'hinh_anh' => $cart_items['hinh_anh']) ;
                }
            }
            if($found == false) {
                //LIÊN KẾT DỮ LIỆU new_product với product
                $_SESSION['cart'] = array_merge($product, $new_product);
            }else {
                $_SESSION['cart'] = $product;
            }
        } else {
            $_SESSION['cart'] = $new_product;
        }
    }
     header("location: ../../index.php?page=cart");
  }
?>