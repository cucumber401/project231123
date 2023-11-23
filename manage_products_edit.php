<?php
include("./conn/connMysql.php");
// 判斷action是否存在且有值
if (isset($_POST["action"]) && $_POST["action"] == "edit") {

  if ($_FILES["p_pic"]["name"]) {
    $p_pic = $_FILES["p_pic"]["name"];
    if ($_FILES["p_pic"]["error"] == 0) {
      move_uploaded_file($_FILES["p_pic"]["tmp_name"], "./photo/pro_home/" . $p_pic);
    } else {
      echo '<script>alert("上傳失敗 !");</script>';
      die("ERROR : Type" . $_FILES["p_pic"]["error"]);
    }
  } else {
    $p_pic = $_POST["p_pic_old"];
  }

  // (p_id, p_name, p_desc, p_price, p_category, p_pic)
  $sql_query = "UPDATE products 
  SET p_name=?, p_desc=?, p_price=?, p_category=?, p_pic=?
  WHERE p_id=?";
  // 用prepare方法將預備語法化為stmt物件
  $stmt = $db_link->prepare($sql_query);

  // 用bind_param方法綁定變數為預備語法中的參數
  $stmt->bind_param(
    "sssssi",
    $_POST["p_name"],
    $_POST["p_desc"],
    $_POST["p_price"],
    $_POST["p_category"],
    $p_pic,
    $_POST["p_id"],
  );

  // 中間有時候會加一些while跑資料顯示
  $stmt->execute();
  $stmt->close();
  $db_link->close();

  // 轉址 :導回主畫面
  echo '<script>
      alert("更新成功 !");
      document.location.href="./manage_products.php";
      </script>';
}

$sql_select = "SELECT p_id, p_name, p_desc, p_price, p_category, p_pic 
FROM products WHERE p_id=?";
$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("i", $_GET["a_id"]);
$stmt->execute();
$stmt->bind_result($p_id, $p_name, $p_desc, $p_price, $p_category, $p_pic_old);
$stmt->fetch();

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>修改商品</title>

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
        <h4>修改商品</h4>
      </div>
      <hr><br>
      <form action="./manage_products_edit.php" method="post" enctype="multipart/form-data">
        <div class="mb-3 row">
          <label for="p_name" class="offset-md-2 col-md-2 col-form-label">品名</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="p_name" id="p_name" value="<?php echo $p_name ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="p_desc" class="offset-md-2 col-md-2 col-form-label">描述</label>
          <div class="col-md-6">
            <textarea class="form-control" name="p_desc" id="p_desc"><?php echo $p_desc ?></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="p_price" class="offset-md-2 col-md-2 col-form-label">價格</label>
          <div class="col-md-6">
            <input type="number" class="form-control" name="p_price" id="p_price" value="<?php echo $p_price ?>">
          </div>
        </div>
        <!-- file -->
        <div class="mb-3 row">
          <label for="p_pic" class="offset-md-2 col-md-2 col-form-label">圖片</label>
          <div class="col-md-6">
            <input type="file" class="form-control" name="p_pic" id="p_pic" accept="image/*">
            <?php if ($p_pic_old) { ?>
              <img style="height: 30px;" src="./photo/pro_home/<?php echo $p_pic_old ?>">
            <?php echo $p_pic_old;
            } else { ?>
            <?php echo "尚無圖檔";
            } ?>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="p_category" class="offset-md-2 col-md-2 col-form-label">類別</label>
          <div class="col-md-6">
            <select class="form-select" name="p_category" id="p_category">
              <option selected>請選擇商品類別</option>
              <option value="home" <?php echo $p_category=='home'?'selected':'' ?>>智慧家電</option>
              <option value="phone" <?php echo $p_category=='phone'?'selected':'' ?>>手機</option>
              <option value="watch" <?php echo $p_category=='watch'?'selected':'' ?>>手錶</option>
              <option value="other" <?php echo $p_category=='other'?'selected':'' ?>>其他</option>
            </select>
          </div>
        </div>
        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="p_id" value="<?php echo $p_id ?>">
            <input type="hidden" name="p_pic_old" value="<?php echo $p_pic_old ?>">
            <button class="btn btn-dark mx-4" type="submit">確定更新</button>
            <a href="./manage_products.php" class="btn btn-secondary mx-4">返　　回</a>
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