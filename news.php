<?php
// 獲取URL中的nid參數值
if (isset($_GET['nid'])) {
  $newsId = $_GET['nid'];
  // 根據$newsId執行相應的資料庫查詢或其他操作
  // 顯示相關產品資訊
}
?>
<?php
include("./conn/connMysql.php");

$sql_query = "SELECT * FROM news WHERE n_id = $newsId";
$result_news = $db_link->query($sql_query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>最新消息</title>

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
    .websitePath a {
      color: gray;
      font-size: 0.9rem;
    }
  </style>
</head>


<body>
  <?php include('./t_navbar.php') ?>

  <!-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> -->

  <!-- news -->

  <div class="container">
    <br>
    <?php while ($i_result_news = $result_news->fetch_assoc()) { ?>
      <p class="websitePath">
        <a href="./index.php">首頁</a>>
        <a href="./news_all.php">最新消息</a>>
        <a href="#"><?php echo $i_result_news['n_title'] ?></a>
      </p>
      <br>
      
      <h5><?php echo $i_result_news['n_title'] ?></h5>
      <hr>
      <p><?php echo $i_result_news['n_create'] ?></p>
      <p><?php echo $i_result_news['n_content'] ?></p>

    <?php }; ?>
    <br>
  </div>

  <!-- news end -->

  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

  <!-- footer -->
  <?php include('./t_footer.php') ?>
</body>

</html>