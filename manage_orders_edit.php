<?php
include("./conn/connMysql.php");
// 判斷action是否存在且有值
if (isset($_POST["action"]) && $_POST["action"] == "edit") {

  // o_id, m_id, o_detail, o_total, o_trade_date, o_pay_date
  $sql_query = "UPDATE orders 
  SET o_id=?, m_id=?, o_detail=?, o_total=?, o_trade_date=?, o_pay_date=?
  WHERE o_id=?";
  // 用prepare方法將預備語法化為stmt物件
  $stmt = $db_link->prepare($sql_query);

  // 用bind_param方法綁定變數為預備語法中的參數
  $stmt->bind_param(
    "sssssss",
    $_POST["o_id"],
    $_POST["m_id"],
    $_POST["o_detail"],
    $_POST["o_total"],
    $_POST["o_trade_date"],
    $_POST["o_pay_date"],
    $_POST["o_id"]
  );

  // 中間有時候會加一些while跑資料顯示
  $stmt->execute();
  $stmt->close();
  $db_link->close();

  // 轉址 :導回主畫面
  echo '<script>
      alert("更新成功 !");
      document.location.href="./manage_orders.php";
      </script>';
  // header("Location:./manage_orders.php");
}

// o_id, m_id, o_detail, o_total, o_trade_date, o_pay_date

$sql_select = "SELECT o_id, m_id, o_detail, o_total, o_trade_date, o_pay_date
FROM orders WHERE o_id=?";
$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("s", $_GET["o_id"]);
$stmt->execute();
$stmt->bind_result($o_id, $m_id, $o_detail, $o_total, $o_trade_date, $o_pay_date);
$stmt->fetch();

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>修改訂單紀錄</title>

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
        <h4>修改訂單紀錄</h4>
      </div>
      <hr><br>
      <form action="./manage_orders_edit.php" method="post" enctype="multipart/form-data">
        <div class="mb-3 row">
          <label for="o_id" class="offset-md-2 col-md-2 col-form-label">訂單編號</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="o_id" id="o_id" value="<?php echo $o_id ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_id" class="offset-md-2 col-md-2 col-form-label">會員編號</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_id" id="m_id" value="<?php echo $m_id ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="o_detail" class="offset-md-2 col-md-2 col-form-label">訂單細節</label>
          <div class="col-md-6">
            <textarea class="form-control" name="o_detail" id="o_detail" cols="50" rows="3"><?php echo $o_detail ?></textarea>
          </div>
        </div>
        
        <div class="mb-3 row">
          <label for="o_total" class="offset-md-2 col-md-2 col-form-label">訂單總價</label>
          <div class="col-md-6">
            <textarea class="form-control" name="o_total" id="o_total" cols="50" rows="3"><?php echo $o_total ?></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="o_trade_date" class="offset-md-2 col-md-2 col-form-label">訂單交易時間</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="o_trade_date" id="o_trade_date" value="<?php echo $o_trade_date ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="o_pay_date" class="offset-md-2 col-md-2 col-form-label">訂單付款時間</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="o_pay_date" id="o_pay_date" value="<?php echo $o_pay_date ?>">
          </div>
        </div>
        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="o_id" value="<?php echo $o_id ?>">
            <button class="btn btn-dark mx-4" type="submit">確定更新</button>
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
<?php
$stmt->close();
$db_link->close();
?>