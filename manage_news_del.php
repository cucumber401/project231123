<?php
include("./conn/connMysql.php");
// 判斷action是否存在且有值
if (isset($_GET["action"]) && $_GET["action"] == "del") {
  /* 方法2 */
  $sql_query = "DELETE FROM news WHERE n_id=?";
  // 用prepare方法將預備語法化為stmt物件
  $stmt = $db_link->prepare($sql_query);
  // 用bind_param方法綁定變數為預備語法中的參數
  $stmt->bind_param("i", $_GET["n_id"]);
  // 中間有時候會加一些while跑資料顯示
  $stmt->execute();
  $stmt->close();
  $db_link->close();

  // echo "<script>alert('刪除成功');</script>";
  // 轉址 :導回主畫面
  header("Location:./manage_news.php");
}

$sql_select = "SELECT n_id, n_start_date, n_end_date, n_title, n_content, n_type 
FROM news WHERE n_id=?";
$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("i", $_GET["n_id"]);
$stmt->execute();
$stmt->bind_result($n_id, $n_start_date, $n_end_date, $n_title, $n_content, $n_type);
$stmt->fetch();

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>刪除消息</title>

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

        <h4>刪除消息</h4>
      </div>

      <hr><br>
      <form action="./manage_news_del.php" method="get">
        <div class="mb-3 row">
          <label for="n_type" class="offset-md-2 col-md-2 col-form-label">類別</label>
          <div class="col-md-6">
            <select class="form-select" name="n_type" id="n_type" disabled readonly>
              <option value="促銷" <?php echo $n_type == '促銷' ? 'selected' : '' ?>>促銷</option>
              <option value="活動" <?php echo $n_type == '活動' ? 'selected' : '' ?>>活動</option>
              <option value="公告" <?php echo $n_type == '公告' ? 'selected' : '' ?>>公告</option>
              <option value="其他" <?php echo $n_type == '其他' ? 'selected' : '' ?>>其他</option>
            </select>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="n_title" class="offset-md-2 col-md-2 col-form-label">標題</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="n_title" id="n_title" value="<?php echo $n_title ?>" disabled readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="n_content" class="offset-md-2 col-md-2 col-form-label">內文</label>
          <div class="col-md-6">
            <textarea class="form-control" name="n_content" id="n_content" cols="50" rows="7" disabled readonly><?php echo $n_content ?></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="n_start_date" class="offset-md-2 col-md-2 col-form-label">上架日期</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="n_start_date" id="n_start_date" value="<?php echo $n_start_date ?>" disabled readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="n_end_date" class="offset-md-2 col-md-2 col-form-label">下架日期</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="n_end_date" id="n_end_date" value="<?php echo $n_end_date ?>" disabled readonly>
          </div>
        </div>

        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <input type="hidden" name="action" value="del">
            <input type="hidden" name="n_id" value="<?php echo $n_id ?>">
            <button class="btn btn-dark mx-4" type="submit">確定刪除</button>
            <a href="./manage_news.php" class="btn btn-secondary mx-4">返　　回</a>
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