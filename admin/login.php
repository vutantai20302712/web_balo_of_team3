<?php
session_start();
if (isset($_SESSION['login'])) {
  header('Location: index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN WEB</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/grid.css">
  <link rel="stylesheet" href="../assets/css/responsive.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.4.0-web/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">

  <style>
    .error {
      color: red;
      font-size: 14px;
      margin-top: 5px;
      font-weight: bold;
    }

    .auth-form_controls {
      margin-top: 30px;
      margin-bottom: 20px;
    }

    .danger {
      color: red;
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 15px;
      margin-left: 1px;
      border: 1px solid red;
      padding: 10px;
      display: inline-block;

    }


    form {
      margin-bottom: 20px;
    }
   
  </style>
</head>

<body>
  <!-- MODAL LAYOUT -->
  <div class="modal">
    <div class="modal_overlay"></div>
    <div class="modal_body">
      <!-- Login form -->
      <div class="auth-form">
        <div class="auth-form_container">
          <div class="auth-form_header">
            <h3 class="auth-form_heading"><strong>Đăng Nhập - Trang ADMIN</strong></h3>
          </div>

          <?php
          if (isset($_SESSION['error_login'])) {
            echo $_SESSION['error_login'];
            unset($_SESSION['error_login']);
          }
          ?>
          <form action="login-process.php" role="form" method="post">
            <fieldset>
              <div class="auth-form_group">
                <input type="email" class="auth-form-input" placeholder="Your Email" name="mail" value="<?php if (isset($_SESSION['old_email'])) echo $_SESSION['old_email']; ?>" autofocus>
                <?php
                if (isset($_SESSION['error_email'])) {
                  echo $_SESSION['error_email'];
                  unset($_SESSION['error_email']);
                }
                ?>
              </div>
              <div class="auth-form_group">
                <input type="password" class="auth-form-input" placeholder="Your Password" name="pass" value="<?php if (isset($_SESSION['old_pass'])) echo $_SESSION['old_pass']; ?>" autofocus>
                <?php
                if (isset($_SESSION['error_pass'])) {
                  echo $_SESSION['error_pass'];
                  unset($_SESSION['error_pass']);
                }
                ?>
              </div>
              <div class="auth-form_controls">
                <button type="submit" class="btn btn-primary" name="submit" style="width:100%;">Log in</button>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>