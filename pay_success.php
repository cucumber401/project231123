<?php
include('./ECPay.Payment.Integration.php');
$obj = new ECPay_AllInOne();

// 寫進DB
include("./conn/connMysql.php");

$sql_query = "INSERT INTO orders (o_id, m_id, o_detail, o_total, o_trade_date, o_pay_date) 
    VALUES (?, ?, ?, ?, ?, ?)";
// 用prepare方法將預備語法化為stmt物件
$stmt = $db_link->prepare($sql_query);

$post_data = print_r($_POST, true);
// 用bind_param方法綁定變數為預備語法中的參數
$stmt->bind_param(
  "ssssss",
  $_POST['MerchantTradeNo'],
  $_POST['RtnCode'],
  $post_data,
  $_POST['TradeAmt'],
  $_POST['TradeDate'],
  $_POST['TradeDate']
);

$arParameters = $_POST;
$ECPay_MerchantID = "2000132";
$ECPay_HashKey = "5294y06JbISpM5x9";
$ECPay_HashIV = "v77hoKGq4kWxNNIS";
 
//進行驗證碼檢查，將POST陣列, HashKey, HashIV, 以及當初設定的加密方式($obj->EncryptType = "1";)作為參數，
//傳給 ECPay_CheckMacValue::generate 來產生驗證碼
$CheckMacValue = ECPay_CheckMacValue::generate($arParameters, $ECPay_HashKey, $ECPay_HashIV, 1);
//$_POST['RtnCode'] == 1表示刷卡成功
//比對傳來的POST中的驗證碼與這邊剛計算出來的驗證碼是否相同，相同才進行後續處理，若不同，則表示這份POST可能是偽造的，或是錯誤的交易紀錄
if ($_POST['RtnCode'] == '1' && $CheckMacValue == $_POST['CheckMacValue']) {

  /*
  自己的處理邏輯、連資料庫等等動作
  */

  //最後一定要回傳這一行，告知綠界說：「我的商店網站確實有收到綠界的通知了！」才算完成。
  echo '1|OK';
  // header("Location:./manage_orders.php");
}


// 中間有時候會加一些while跑資料顯示
$stmt->execute();
$stmt->close();
$db_link->close();

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>交易成功</title>
  <!-- page C -->
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

    <div class="text-center">
      <h4>您已成功完成交易</h4>
    </div>

    <?php
    $post_data2 = print_r($_POST, true);
    echo $post_data2;
    ?>
    
    <br><br>
    <hr>
    <br><br>
    <div class="mb-3 row">
      <div class="offset-md-3 col-md-6 text-center">
        <a href="./index.php" class="btn btn-secondary mx-3">回首頁</a>
      </div>
    </div>
  </div>

  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>

</body>

</html>