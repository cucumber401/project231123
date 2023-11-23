<?php
include("./conn/connMysql.php");
// 判斷action是否存在且有值
if (isset($_POST["action"]) && $_POST["action"] == "add") {

  if ($_FILES["a_img"]["error"] == 0) {
    // 可加一些亂數防止檔名重複
    if (move_uploaded_file($_FILES["a_img"]["tmp_name"], "./photo/pro_home/" . $_FILES["a_img"]["name"])) {

      $sql_query = "INSERT INTO products (p_id, p_name, p_desc, p_price, p_category, p_pic) 
    VALUES (?, ?, ?, ?, ?, ?)";
      // 用prepare方法將預備語法化為stmt物件
      $stmt = $db_link->prepare($sql_query);
      // 用bind_param方法綁定變數為預備語法中的參數
      $stmt->bind_param(
        "isssss",
        $_POST["p_id"],
        $_POST["p_name"],
        $_POST["p_desc"],
        $_POST["p_price"],
        $_POST["p_category"],
        $_FILES["a_img"]["name"]
      );
    }
    echo '<script>
      alert("上傳成功 !");
      document.location.href="./manage_products.php";
      </script>';
  } else {
    echo '<script>alert("上傳失敗 !");</script>';
    die("ERROR : Type" . $_FILES["a_img"]["error"]);
  }



  // 中間有時候會加一些while跑資料顯示
  $stmt->execute();
  $stmt->close();
  $db_link->close();

  // 轉址 :導回主畫面
  // header("Location:./manage_products.php");
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>新增商品</title>

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
        <h4>新增商品</h4>
      </div>

      <hr><br>
      <!-- 網頁表單中如果包含檔案的上傳，就要把enctype設定為"multipart/form-data"(不做任何編碼) -->
      <form action="./manage_products_add.php" method="post" enctype="multipart/form-data">
        <div class="mb-3 row">
          <label for="p_id" class="offset-md-2 col-md-2 col-form-label">編號</label>
          <div class="col-md-6">
            <input type="number" class="form-control" name="p_id" id="p_id">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="p_name" class="offset-md-2 col-md-2 col-form-label">品名</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="p_name" id="p_name">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="p_desc" class="offset-md-2 col-md-2 col-form-label">描述</label>
          <div class="col-md-6">
            <textarea  class="form-control" name="p_desc" id="p_desc" cols="50" rows="4"></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="p_price" class="offset-md-2 col-md-2 col-form-label">價格</label>
          <div class="col-md-6">
            <input type="number" class="form-control" name="p_price" id="p_price">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="p_category" class="offset-md-2 col-md-2 col-form-label">類別</label>
          <div class="col-md-6">
            <select class="form-select" name="p_category" id="p_category">
              <option selected>請選擇商品類別</option>
              <option value="home">智慧家電</option>
              <option value="phone">手機</option>
              <option value="watch">手錶</option>
              <option value="other">其他</option>
            </select>
          </div>
        </div>
        <!-- file -->
        <div class="mb-3 row">
          <label for="a_img" class="offset-md-2 col-md-2 col-form-label">圖片</label>
          <div class="col-md-6">
            <input type="file" class="form-control" name="a_img" id="a_img" accept="image/*" required>
          </div>
        </div>
        <!--  -->
        
        <input type="hidden" name="action" value="add">

        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <button class="btn btn-dark mx-2" type="submit">確定新增</button>
            <button class="btn btn-secondary mx-2" type="reset">清　　除</button>
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