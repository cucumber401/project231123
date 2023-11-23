<?php
include("./conn/connMysql.php");

session_start();
$loginMember = $_SESSION['loginMember'];
$sql_query = "SELECT * FROM managers WHERE mng_account='$loginMember'";
$result = $db_link->query($sql_query);
$i_result = $result->fetch_assoc();


if (isset($_POST["action"]) && $_POST["action"] == "logout") {
  unset($_SESSION["loginMember"]);
  unset($_SESSION["memberLevel"]);
  header("Location:./manager_login.php");
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>管理員系統</title>

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

  <!-- navbar start -->
  <?php include('./t_navbar.php') ?>
  <!-- navbar end -->

  <div class="container">
    <br><br>
    <div class="text-center">
      <h4>Hi, <?php echo $i_result['mng_account'] ?><br>您已成功登入管理員系統</h4>
    </div>

    <div class="d-grid gap-2 col-6 mx-auto">
      <button class="btn btn-outline-dark my-2 py-3" onclick="location.href='./manage_news.php';"><strong>進入消息管理系統</strong></button>
      <button class="btn btn-outline-dark my-2 py-3" onclick="location.href='./manage_members.php';"><strong>進入會員管理系統</strong></button>
      <button class="btn btn-outline-dark my-2 py-3" onclick="location.href='./manage_ads.php';"><strong>進入廣告管理系統</strong></button>
      <button class="btn btn-outline-dark my-2 py-3" onclick="location.href='./manage_products.php';"><strong>進入商品管理系統</strong></button>
      <button class="btn btn-outline-dark my-2 py-3" onclick="location.href='./manage_orders.php';"><strong>進入訂單管理系統</strong></button>
    </div>

    <form action="./manager.php" method="post">
      <br>
      <!-- 隱藏參數 -->
      <input type="hidden" name="action" value="logout">

      <div class="mb-3 row">
        <div class="offset-md-3 col-md-6 text-center">
          <button class="btn btn-primary mx-3" type="submit">登　出</button>
          <a href="./index.php" class="btn btn-secondary mx-3">回首頁</a>
        </div>
      </div>
    </form>
  </div>
  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>
</body>

</html>