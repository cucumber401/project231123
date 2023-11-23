<?php
include("./conn/connMysql.php");
session_start();

// 判斷是否已登入
if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
  if ($_SESSION["memberLevel"] == "member") {
    header("Location: ./success.php");
  } else {
    echo '<script>
      alert("您目前以管理員身分登入，請先前往管理員專區登出 !");
      document.location.href="./manager.php";
      </script>';
  }
}

// 執行會員登入
if (isset($_POST["m_email"]) && isset($_POST["m_psw"])) {
  $sql_select = "SELECT m_id, m_name, m_sex, m_birthday, m_email, m_phone, m_addr, m_psw FROM members WHERE m_email=?";

  $stmt = $db_link->prepare($sql_select);
  $stmt->bind_param("s", $_POST["m_email"]);
  $stmt->execute();
  $stmt->bind_result($m_id, $m_name, $m_sex, $m_birthday, $m_email, $m_phone, $m_addr, $m_psw);
  $stmt->fetch();
  $stmt->close();

  // 比對密碼(有無HASH皆可版本)
  if ($_POST["m_psw"] == $m_psw || password_verify($_POST["m_psw"], $m_psw)) {
    // 設定登入者的名稱與等級
    $_SESSION["loginMember"] = $m_email;
    $_SESSION["memberLevel"] = "member";
    header("Location:./success.php");
  } else {
    header("Location:./mem_login.php?errMsg=1");
  }
}

$sql_select = "SELECT m_id, m_name, m_sex, m_birthday, m_email, m_phone, m_addr, m_psw FROM members WHERE m_email=? AND m_psw=?";

$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("is", $_POST["m_email"], $_POST["m_psw"]);
$stmt->execute();
$stmt->bind_result($m_id, $m_name, $m_sex, $m_birthday, $m_email, $m_phone, $m_addr, $m_psw);
$stmt->fetch();

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>會員登入</title>

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
        <h4>會員登入</h4>
      </div>
      <hr><br>

      <form action="./mem_login.php" method="post">
        <div class="mb-3 row">
          <label for="m_email" class="offset-md-2 col-md-2 col-form-label">帳　號</label>
          <div class="col-md-6">
            <input type="email" class="form-control" name="m_email" id="m_email" placeholder="在此輸入電子郵件" required>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_psw" class="offset-md-2 col-md-2 col-form-label">密　碼</label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="m_psw" id="m_psw" placeholder="在此輸入密碼" required>
          </div>
        </div>
        <br>
        <!-- 隱藏參數 -->
        <input type="hidden" name="action" value="login">

        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <button class="btn btn-primary mx-3" type="submit">登入</button>
            <a href="./index.php" class="btn btn-secondary mx-3">回首頁</a>
            <a href="./mem_signup.php" class="btn btn-primary mx-3">註冊</a>
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