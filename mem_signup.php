<?php
include("./conn/connMysql.php");

// $sql_query_check = "SELECT m_email FROM members";
// $result_check = $db_link->query($sql_query_check);

// 判斷action是否存在且有值
if (isset($_POST["action"]) && $_POST["action"] == "add") {

  $m_name = $_POST["m_name"];
  $m_sex = $_POST["m_sex"];
  $m_birthday = $_POST["m_birthday"];
  $m_email = $_POST["m_email"];
  $m_phone = $_POST["m_phone"];
  $m_addr = $_POST["m_addr"];
  $m_psw = $_POST["m_psw"];
  $m_psw = password_hash($m_psw, PASSWORD_DEFAULT);

  $sql_query_check = "SELECT m_email FROM members";
  $result_check = $db_link->query($sql_query_check);

  $isDuplicate = 0;
  while ($i_result = $result_check->fetch_assoc()) {
    if ($m_email == $i_result['m_email']) {
      $isDuplicate = 1;
      break;
    }
  }

  if ($isDuplicate == 0) {
    $sql_query = "INSERT INTO members (m_name, m_sex, m_birthday, m_email, m_phone, m_addr, m_psw) 
  VALUES ('$m_name', '$m_sex', '$m_birthday', '$m_email', '$m_phone', '$m_addr', '$m_psw')";
    // 變數外記得加引號
    $result = $db_link->query($sql_query);
    $db_link->close();
    echo '<script>
      alert("註冊成功 ! 請重新登入");
      document.location.href="./mem_login.php";
      </script>';
  } else {
    echo '<script>
      alert("此帳號已被註冊 ! 請重新註冊新帳號或以舊帳號登入");
      </script>';
  }

}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>註冊會員</title>

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

      <div class="text-center">

        <h4>註冊會員</h4>
      </div>

      <hr><br>

      <form action="./mem_signup.php" method="post">
        <div class="mb-3 row">
          <label for="m_name" class="offset-md-2 col-md-2 col-form-label">姓　　名</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_name" id="m_name" required>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_sex" class="offset-md-2 col-md-2 col-form-label">性　　別</label>
          <div class="col-md-6">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="m_sex" id="m_sex_1" value="M" checked>
              <label class="form-check-label" for="m_sex_1">男</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="m_sex" id="m_sex_2" value="F">
              <label class="form-check-label" for="m_sex_2">女</label>
            </div>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_email" class="offset-md-2 col-md-2 col-form-label">電子郵件</label>
          <div class="col-md-6">
            <input type="email" class="form-control" name="m_email" id="m_email" maxlength="50" required>
            <span id="account_checkResult"></span>
          </div>
        </div>
        <!-- psw -->
        <div class="mb-3 row">
          <label for="m_psw" class="offset-md-2 col-md-2 col-form-label">密　　碼</label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="m_psw" id="m_psw" maxlength="20" required>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_psw_check" class="offset-md-2 col-md-2 col-form-label">確認密碼</label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="m_psw_check" id="m_psw_check" onkeyup="doubleCheck()" maxlength="20" required>
            <span id="psw_checkResult"></span>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_phone" class="offset-md-2 col-md-2 col-form-label">電　　話</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_phone" id="m_phone" maxlength="20">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_birthday" class="offset-md-2 col-md-2 col-form-label">生　　日</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="m_birthday" id="m_birthday">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_addr" class="offset-md-2 col-md-2 col-form-label">住　　址</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_addr" id="m_addr" maxlength="200">
          </div>
        </div>
        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <input type="hidden" name="action" value="add">
            <button id="submit" class="btn btn-primary mx-4" type="submit">註冊會員</button>
            <button class="btn btn-secondary mx-4" type="reset">清　　除</button>
            <a href="./mem_login.php" class="btn mx-4 my-2">已有帳號? <span style="text-decoration: underline;">按此登入</span></a>
          </div>
        </div>

      </form>
    </div>
  </div>

  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>

  <script>
    function doubleCheck() {
      var psw_1 = $("#m_psw").val();
      var psw_2 = $("#m_psw_check").val();
      if (psw_1 != psw_2) {
        $("#psw_checkResult").text("密碼不一致").css("color", "red");
        $("#submit").attr("disabled", true)
      } else if (psw_1 == psw_2) {
        $("#psw_checkResult").text("密碼一致").css("color", "green");
        $("#submit").attr("disabled", false)

      }
    }

    // function accountCheck(textt) {
    //   var notSure = $("#m_email").val();
    //   $("#account_checkResult").text(textt + "123").css("color", "red");
    // }
  </script>
</body>

</html>