<?php
include("./conn/connMysql.php");
// 判斷action是否存在且有值
if (isset($_POST["action"]) && $_POST["action"] == "add") {

  $sql_query = "INSERT INTO orders (o_id, m_id, o_detail, o_total, o_date) 
    VALUES (?, ?, ?, ?, ?)";
  // 用prepare方法將預備語法化為stmt物件
  $stmt = $db_link->prepare($sql_query);
  // 用bind_param方法綁定變數為預備語法中的參數
  $stmt->bind_param(
    "sssss",
    $_POST["o_id"],
    $_POST["m_id"],
    $_POST["o_detail"],
    $_POST["o_total"],
    $_POST["o_date"]
  );

  // 中間有時候會加一些while跑資料顯示
  $stmt->execute();
  $stmt->close();
  $db_link->close();

  // 轉址 :導回主畫面
  header("Location:./manage_orders.php");
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>新增訂單紀錄</title>

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
        <h4>新增訂單紀錄</h4>
      </div>
<!-- (o_id, m_id, o_detail, o_total, o_date)  -->
      <hr><br>
      <form action="./manage_orders_add.php" method="post">
        <div class="mb-3 row">
          <label for="o_id" class="offset-md-2 col-md-2 col-form-label">訂單編號</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="o_id" id="o_id">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_id" class="offset-md-2 col-md-2 col-form-label">會員編號</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_id" id="m_id">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="o_detail" class="offset-md-2 col-md-2 col-form-label">訂單細節</label>
          <div class="col-md-6">
            <textarea class="form-control" name="o_detail" id="o_detail" cols="50" rows="7"></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="o_total" class="offset-md-2 col-md-2 col-form-label">訂單總價</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="o_total" id="o_total">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="o_date" class="offset-md-2 col-md-2 col-form-label">付款時間</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="o_date" id="o_date">
          </div>
        </div>

        <input type="hidden" name="action" value="add">

        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <button class="btn btn-dark mx-2" type="submit">確定新增</button>
            <button class="btn btn-secondary mx-2" type="reset">清　　除</button>
            <a href="./manage_orders.php" class="btn btn-secondary mx-4">返　　回</a>
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