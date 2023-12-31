<?php
include("./conn/connMysql.php");
// 判斷action是否存在且有值
if (isset($_POST["action"]) && $_POST["action"] == "edit") {

  // $a_img = ($_FILES["a_img"]["name"] ? $_FILES["a_img"]["name"] : $_POST["a_img_old"]);
  if ($_FILES["a_img"]["name"]) {
    $a_img = $_FILES["a_img"]["name"];
    if ($_FILES["a_img"]["error"] == 0) {
      move_uploaded_file($_FILES["a_img"]["tmp_name"], "./photo/index/" . $a_img);
    } else {
      echo '<script>alert("上傳失敗 !");</script>';
      die("ERROR : Type" . $_FILES["a_img"]["error"]);
    }
  } else {
    $a_img = $_POST["a_img_old"];
  }

  $sql_query = "UPDATE ads 
  SET a_sub_title=?, a_title=?, a_content=?, a_img=?, a_text_style=?
  WHERE a_id=?";
  // 用prepare方法將預備語法化為stmt物件
  $stmt = $db_link->prepare($sql_query);

  // 用bind_param方法綁定變數為預備語法中的參數
  $stmt->bind_param(
    "sssssi",
    $_POST["a_sub_title"],
    $_POST["a_title"],
    $_POST["a_content"],
    $a_img,
    $_POST["a_text_style"],
    $_POST["a_id"]
  );

  // 中間有時候會加一些while跑資料顯示
  $stmt->execute();
  $stmt->close();
  $db_link->close();

  // 轉址 :導回主畫面
  echo '<script>
      alert("更新成功 !");
      document.location.href="./manage_ads.php";
      </script>';
  // header("Location:./manage_ads.php");
}

$sql_select = "SELECT a_id, a_sub_title, a_title, a_content, a_img, a_text_style 
FROM ads WHERE a_id=?";
$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("i", $_GET["a_id"]);
$stmt->execute();
$stmt->bind_result($a_id, $a_sub_title, $a_title, $a_content, $a_img_old, $a_text_style);
$stmt->fetch();

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>修改banner</title>

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
        <h4>修改banner</h4>
      </div>
      <hr><br>
      <form action="./manage_ads_edit.php" method="post" enctype="multipart/form-data">
        <div class="mb-3 row">
          <label for="a_sub_title" class="offset-md-2 col-md-2 col-form-label">小標</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="a_sub_title" id="a_sub_title" value="<?php echo $a_sub_title ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="a_title" class="offset-md-2 col-md-2 col-form-label">標題</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="a_title" id="a_title" value="<?php echo $a_title ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="a_content" class="offset-md-2 col-md-2 col-form-label">內文</label>
          <div class="col-md-6">
            <textarea class="form-control" name="a_content" id="a_content" cols="50" rows="3"><?php echo $a_content ?></textarea>
          </div>
        </div>
        <!-- file -->
        <div class="mb-3 row">
          <label for="a_img" class="offset-md-2 col-md-2 col-form-label">圖片</label>
          <div class="col-md-6">
            <input type="file" class="form-control" name="a_img" id="a_img" accept="image/*">
            <?php if ($a_img_old) { ?>
              <img style="height: 20px;" src="./photo/index/<?php echo $a_img_old ?>">
            <?php echo $a_img_old;
            } else { ?>
            <?php echo "尚無圖檔";
            } ?>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="a_text_style" class="offset-md-2 col-md-2 col-form-label">文字樣式</label>
          <div class="col-md-6">
            <textarea class="form-control" name="a_text_style" id="a_text_style" cols="50" rows="3"><?php echo $a_text_style ?></textarea>
          </div>
        </div>
        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="a_id" value="<?php echo $a_id ?>">
            <input type="hidden" name="a_img_old" value="<?php echo $a_img_old ?>">
            <button class="btn btn-dark mx-4" type="submit">確定更新</button>
            <a href="./manage_ads.php" class="btn btn-secondary mx-4">返　　回</a>
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