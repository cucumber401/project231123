<?php
include("./conn/connMysql.php");
session_start();
$loginMember = $_SESSION['loginMember'];
$sql_query = "SELECT * FROM members WHERE m_email='$loginMember'";
$result = $db_link->query($sql_query);


if (isset($_POST["action"]) && $_POST["action"] == "logout") {
  unset($_SESSION["loginMember"]);
  unset($_SESSION["memberLevel"]);
  header("Location:./mem_login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登入成功</title>

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
    <?php $i_result = $result->fetch_assoc(); ?>
    <div class="pt-2 pb-0">

      <div class="text-center">
        <h4>Hi, <?php echo $i_result['m_name'] ?><br>您已成功登入</h4>
      </div>

      <form action="./success.php" method="post">
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

      <hr><br>


    </div>
  </div>

  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>

</body>

</html>
<?php
$db_link->close();
?>