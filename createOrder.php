<?php
// 獲取URL中的參數值
if (isset($_POST['productInfoArray'])) {
  $cartTotal = $_POST['carttotal'];
  $productInfoArray = $_POST['productInfoArray'];
}
// $productInfoArray 結構說明
// Array ( 
//   [0] => Array ( [品名] => [單價] => [數量] => [小計] => ) 
//   [1] => Array ( [品名] => 智能掃拖機器人 [單價] => 500 [數量] => 1 [小計] => 500 ) 
//   [2] => Array ( [品名] => 智能空拍機 [單價] => 800 [數量] => 2 [小計] => 1600 ) 
//   )

$my_TradeDesc = "測試交易描述";

//載入SDK(路徑可依系統規劃自行調整)
include('./ECPay.Payment.Integration.php');
try {

  $obj = new ECPay_AllInOne();

  /* 測試 */
  //(測試)服務參數
  $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置(測試環境)
  $obj->HashKey     = '5294y06JbISpM5x9';  //測試用Hashkey，請自行帶入ECPay提供的HashKey                                    
  $obj->HashIV      = 'v77hoKGq4kWxNNIS';  //測試用HashIV，請自行帶入ECPay提供的HashIV                    
  $obj->MerchantID  = '2000132';            //測試用MerchantID，請自行帶入ECPay提供的MerchantID
  $obj->EncryptType = '1';                  //CheckMacValue加密類型，請固定填入1，使用SHA256加密

  //(測試)基本參數(請依系統規劃自行調整)
  $MerchantTradeNo = "Test" . time() . "n" . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT); // [訂單編號]+[一組n碼]不重覆編號 = 生成[廠商交易編號]
  $obj->Send['ReturnURL']         = "https://yuna.lovestoblog.com/pay_receive.php"; // 付款完成通知回傳的網址(後端，頁面B)
  $obj->Send['OrderResultURL']    = "https://yuna.lovestoblog.com/pay_success.php"; // 付款完成後客戶會被導回此頁面(前端，頁面C)
  $obj->Send['ClientBackURL']     = "https://yuna.lovestoblog.com/"; // 提供Client端返回特店的按鈕連結(頁面D)
  $obj->Send['MerchantTradeNo']   = $MerchantTradeNo; //訂單編號
  $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); //交易時間
  $obj->Send['TotalAmount']       = $cartTotal; //交易總金額
  $obj->Send['TradeDesc']         = $my_TradeDesc; //交易描述
  $obj->Send['ChoosePayment']     = ECPay_PaymentMethod::Credit; //付款方式:Credit
  $obj->Send['IgnorePayment']     = ECPay_PaymentMethod::GooglePay; //不使用付款方式:GooglePay


  for ($i = 1; $i < count($productInfoArray); $i++) {
    //訂單的商品資料
    array_push($obj->Send['Items'], array(
      'Name' => $productInfoArray[$i]['品名'], 'Price' => (int)preg_replace('/[^[:digit:]]/', '', $productInfoArray[$i]['單價']),
      'Currency' => "元", 'Quantity' => (int)$productInfoArray[$i]['數量'], 'URL' => "dedwed"
    ));
  }


  //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
  //以下參數不可以跟信用卡定期定額參數一起設定
  $obj->SendExtend['CreditInstallment'] = '';    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
  $obj->SendExtend['Redeem'] = false;           //是否使用紅利折抵，預設false
  $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;


  //產生訂單(auto submit至ECPay)，此步驟會將前述設定的所有參數都一併傳給綠界，並將客戶導到綠界的刷卡頁面
  $obj->CheckOut();
} catch (Exception $e) {
  echo $e->getMessage();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>確認交易內容</title>

  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/278435b38a.js" crossorigin="anonymous"></script>
  <!-- style -->
  <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/main.css">

</head>


<body>

</body>

</html>