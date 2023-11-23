<?php
include('./ECPay.Payment.Integration.php');

$obj = new ECPay_AllInOne();

//可以試著先印出接受到的POST中所有的資訊來查看
print_r($_POST, true);

if ($_POST['RtnCode'] == '1' && $CheckMacValue == $_POST['CheckMacValue']) {

  /*
  自己的處理邏輯、連資料庫等等動作
  */

  //最後一定要回傳這一行，告知綠界說：「我的商店網站確實有收到綠界的通知了！」才算完成。
  echo '1|OK';
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>接收交易內容</title>
  <!-- page B -->

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
<?php print_r("交易內容".$_POST); ?>
</body>

</html>