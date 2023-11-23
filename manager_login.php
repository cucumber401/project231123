<?php
include("./conn/connMysql.php");
session_start();

// 判斷是否已登入
if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
  if ($_SESSION["memberLevel"] == "member") {
    echo '<script>
      alert("您目前以會員身分登入，請先前往會員專區登出 !");
      document.location.href="./mem_login.php";
      </script>';
  }
  else {
    header("Location:./manager.php");
  }
}

// 執行管理員登入
if (isset($_POST["mng_account"]) && isset($_POST["mng_password"])) {
  $sql_select = "SELECT mng_account, mng_password FROM managers WHERE mng_account=?";

  $stmt = $db_link->prepare($sql_select);
  $stmt->bind_param("s", $_POST["mng_account"]);
  $stmt->execute();
  $stmt->bind_result($mng_account, $mng_password);
  $stmt->fetch();
  $stmt->close();

  // 比對密碼(有無HASH皆可版本)
  if ($_POST["mng_password"] == $mng_password || password_verify($_POST["mng_password"],$mng_password) ) {
    // 設定登入者的名稱與等級
    $_SESSION["loginMember"] = $mng_account;
    $_SESSION["memberLevel"] = "manager";
    header("Location:./manager.php");
  } else {
    header("Location:./manager_login.php?errMsg=1");
  }
}

$sql_select = "SELECT mng_account, mng_password FROM managers WHERE mng_account=? AND mng_password=?";

$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("ss", $_POST["mng_account"], $_POST["mng_password"]);
$stmt->execute();
$stmt->bind_result($mng_account, $mng_password);
$stmt->fetch();

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>管理員登入</title>

  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/278435b38a.js" crossorigin="anonymous"></script>
  <!-- style -->
  <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/main.css">

  <style>

  </style>
</head>


<body>

  <?php include('./t_navbar.php') ?>

  <br><br>

  <div class="container rounded-4">
    <div class="pt-2 pb-0">
      <!-- 錯誤處理 -->
      <?php if (isset($_GET["errMsg"]) && ($_GET["errMsg"] == "1")) { ?>
        <p class="text-danger text-center">帳號或密碼錯誤!</p>
      <?php } ?>

      <div class="text-center">
        <h4>管理員登入</h4>
      </div>
      <hr><br>
      
      <form action="./manager_login.php" method="post">
        <div class="mb-3 row">
          <label for="mng_account" class="offset-md-2 col-md-2 col-form-label">帳　號</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="mng_account" id="mng_account" placeholder="在此輸入管理員帳號" required>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mng_password" class="offset-md-2 col-md-2 col-form-label">密　碼</label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="mng_password" id="mng_password" placeholder="在此輸入管理員密碼" required>
          </div>
        </div>
        <br>
        <!-- 隱藏參數 -->
        <input type="hidden" name="action" value="login">

        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <button class="btn btn-primary mx-3" type="submit">登入</button>
            <a href="./index.php" class="btn btn-secondary mx-3">回首頁</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>

</body>

</html>
<?php
$stmt->close();
$db_link->close();
?>