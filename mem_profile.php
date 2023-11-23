<?php
include("./conn/connMysql.php");
session_start();

// 判斷是否已登入
if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
  if ($_SESSION["memberLevel"] == "manager") {
    echo '<script>
      alert("您目前以管理員身分登入，請先前往管理員專區登出 !");
      document.location.href="./manager.php";
      </script>';
  }
  $loginMember = $_SESSION['loginMember'];
  $sql_select = "SELECT m_id, m_name, m_sex, m_birthday, m_email, m_phone, m_addr FROM members WHERE m_email=?";

  $stmt = $db_link->prepare($sql_select);
  $stmt->bind_param("s", $loginMember);
  $stmt->execute();
  $stmt->bind_result($m_id, $m_name, $m_sex, $m_birthday, $m_email, $m_phone, $m_addr);
  $stmt->fetch();

  
} else {
  echo '<script>
  alert("您尚未登入 ! 請先登入");
  document.location.href="./mem_login.php";
  </script>';
  // header("Location:./mem_login.php");
}


?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>會員資料</title>

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

        <h4>會員資料</h4>
      </div>

      <hr><br>

      <form action="./mem_profile_edit.php" method="post">
        <div class="mb-3 row">
          <label for="m_name" class="offset-md-2 col-md-2 col-form-label">姓　　名</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_name" id="m_name" value="<?php echo $m_name; ?>" readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_sex" class="offset-md-2 col-md-2 col-form-label">性　　別</label>
          <div class="col-md-6">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="m_sex" id="m_sex_1" value="M" <?php echo $m_sex == 'M' ? 'checked' : '' ?> readonly>
              <label class="form-check-label" for="m_sex_1">男</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="m_sex" id="m_sex_2" value="F" <?php echo $m_sex == 'F' ? 'checked' : '' ?> readonly>
              <label class="form-check-label" for="m_sex_2">女</label>
            </div>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_birthday" class="offset-md-2 col-md-2 col-form-label">生　　日</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="m_birthday" id="m_birthday" value="<?php echo $m_birthday; ?>" readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_email" class="offset-md-2 col-md-2 col-form-label">電子郵件</label>
          <div class="col-md-6">
            <input type="email" class="form-control" name="m_email" id="m_email" value="<?php echo $m_email; ?>" maxlength="50" readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_phone" class="offset-md-2 col-md-2 col-form-label">電　　話</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_phone" id="m_phone" value="<?php echo $m_phone; ?>" maxlength="20" readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_addr" class="offset-md-2 col-md-2 col-form-label">住　　址</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_addr" id="m_addr" value="<?php echo $m_addr; ?>" maxlength="200" readonly>
          </div>
        </div>
        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <!-- <input type="hidden" name="action" value="edit"> -->
            <input type="hidden" name="m_id" value="<?php echo $m_id; ?>">
            <button class="btn btn-dark mx-4" type="submit">修改資料</button>
            <a href="./index.php" class="btn btn-secondary mx-4">返　　回</a>
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