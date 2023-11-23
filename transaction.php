<?php
if (isset($_POST['cartdetail'])) {
  $cartTotal = $_POST['carttotal'];
  $cartList = $_POST['cartdetail'];
}

// 將字串以 <li> 為分隔符號分割為陣列
$cartItemsArray = explode('<li>', $cartList);

// 建立陣列來存儲資訊
$productInfoArray = array();

// 迴圈處理每個購物車項目
foreach ($cartItemsArray as $item) {
  // 刪除字串中的 HTML 標籤和空白
  $item = strip_tags($item);
  $item = trim($item);

  // 使用正則表達式提取品名、單價、數量和小計
  preg_match('/(.*), 單價: (.*), 數量: (.*), 小計: (.*)/', $item, $matches);

  // 存儲資訊到陣列
  $productInfoArray[] = array(
    '品名' => isset($matches[1]) ? $matches[1] : '',
    '單價' => isset($matches[2]) ? $matches[2] : '',
    '數量' => isset($matches[3]) ? $matches[3] : '',
    '小計' => isset($matches[4]) ? $matches[4] : ''
  );
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

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

  <br><br><br>

  <div class="container justify-content-center text-center" style="min-height: 576px;">
    <div class="card-deck">
      <h3 style="color: black;">交易明細</h3>
      <hr>
      <div class="">
        <p>
          <!-- 明細 -->
          <?php // 輸出每個購物車項目的資訊
          for ($i = 1; $i < count($productInfoArray); $i++) {
            if ($i != 1) {
              echo '<br>';
            }
            echo '品名: ' . $productInfoArray[$i]['品名'] . '<br>';
            echo '單價: ' . $productInfoArray[$i]['單價'] . '<br>';
            echo '數量: ' . $productInfoArray[$i]['數量'] . '<br>';
            echo '小計: ' . $productInfoArray[$i]['小計'] . '<br>';
          }

          ?>
        </p>
      </div>
      <hr>
      <div class="text-end">
        <p id="total">共計: <?php echo $cartTotal ?>元</p>
      </div>
    </div>

    <div class="pt-4">
      <form action="./createOrder.php" method="post">
        <?php for ($i = 0; $i < count($productInfoArray); $i++) : ?>
          <input type="hidden" name="productInfoArray[<?php echo $i; ?>][品名]" value="<?php echo $productInfoArray[$i]['品名']; ?>">
          <input type="hidden" name="productInfoArray[<?php echo $i; ?>][單價]" value="<?php echo $productInfoArray[$i]['單價']; ?>">
          <input type="hidden" name="productInfoArray[<?php echo $i; ?>][數量]" value="<?php echo $productInfoArray[$i]['數量']; ?>">
          <input type="hidden" name="productInfoArray[<?php echo $i; ?>][小計]" value="<?php echo $productInfoArray[$i]['小計']; ?>">
        <?php endfor; ?>
        <input type="hidden" name="carttotal" value="<?php echo $cartTotal ?>">

        <!-- <div class="mb-3 row"> -->
          <div class="mb-5 text-center">
            選擇付款方式:　　
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="o_payment" id="o_payment_1" value="綠界 EC Pay" checked>
              <label class="form-check-label" for="o_payment_1"><img style="height: 20px;" src="./icon/ecpay_logo.svg"></label>
              
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="o_payment" id="o_payment_2" value="LINE Pay">
              <label class="form-check-label" for="o_payment_2"><img style="height: 20px;" src="./icon/LINEPay_logo.png"></label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="o_payment" id="o_payment_3" value="JKO Pay" disabled>
              <label class="form-check-label" for="o_payment_3"><img style="height: 20px;" src="./icon/JKOPAY_logo.png"></label>
            </div>
          </div>
        <!-- </div> -->

        <button type="submit" class="btn btn-dark text-white">確認送出</button>
        <a class="btn btn-secondary text-white" href="./shoppingCart.php">回上一頁</a>
      </form>

    </div>
  </div>

  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>


</body>

</html>