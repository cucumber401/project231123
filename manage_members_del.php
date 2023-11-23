<?php
include("./conn/connMysql.php");
// 判斷action是否存在且有值
if (isset($_GET["action"]) && ($_GET["action"] == "del")) {

  $sql_query = "DELETE FROM members WHERE m_id=?";
  // 用prepare方法將預備語法化為stmt物件
  $stmt = $db_link->prepare($sql_query);
  // 用bind_param方法綁定變數為預備語法中的參數
  $stmt->bind_param("i", $_GET["a_id"]);
  // 中間通常會加一些while跑資料顯示
  $stmt->execute();
  $stmt->close();
  $db_link->close();

  // 轉址 :導回主畫面
  header("Location:./manage_members.php");
}

$sql_select = "SELECT m_id, m_name, m_sex, m_birthday, m_email, m_phone, m_addr 
FROM members WHERE m_id=?";
$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("i", $_GET["a_id"]);
$stmt->execute();
$stmt->bind_result($m_id, $m_name, $m_sex, $m_birthday, $m_email, $m_phone, $m_addr);
$stmt->fetch();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>刪除會員資料</title>

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

  <?php include('./t_navbar.php') ?>

  <br><br>
  <div class="container rounded-4">
    <div class="pt-2 pb-0">

      <div class="text-center">

        <h4>刪除會員資料</h4>
      </div>

      <hr><br>

      <form action="./manage_members_del.php" method="get">
        <div class="mb-3 row">
          <label for="m_name" class="offset-md-2 col-md-2 col-form-label">姓　　名</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_name" id="m_name" value="<?php echo $m_name; ?>" disabled readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_sex" class="offset-md-2 col-md-2 col-form-label">性　　別</label>
          <div class="col-md-6">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="m_sex" id="m_sex_1" value="M" <?php echo $m_sex == 'M' ? 'checked' : '' ?> disabled readonly>
              <label class="form-check-label" for="m_sex_1">男</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="m_sex" id="m_sex_2" value="F" <?php echo $m_sex == 'F' ? 'checked' : '' ?> disabled readonly>
              <label class="form-check-label" for="m_sex_2">女</label>
            </div>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_birthday" class="offset-md-2 col-md-2 col-form-label">生　　日</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="m_birthday" id="m_birthday" value="<?php echo $m_birthday; ?>" disabled readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_email" class="offset-md-2 col-md-2 col-form-label">電子郵件</label>
          <div class="col-md-6">
            <input type="email" class="form-control" name="m_email" id="m_email" value="<?php echo $m_email; ?>" maxlength="50" disabled readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_phone" class="offset-md-2 col-md-2 col-form-label">電　　話</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_phone" id="m_phone" value="<?php echo $m_phone; ?>" maxlength="20" disabled readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="m_addr" class="offset-md-2 col-md-2 col-form-label">住　　址</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="m_addr" id="m_addr" value="<?php echo $m_addr; ?>" maxlength="200" disabled readonly>
          </div>
        </div>
        <br>
        <div class="mb-3 row">
          <div class="offset-md-3 col-md-6 text-center">
            <input type="hidden" name="action" value="del">
            <input type="hidden" name="a_id" value="<?php echo $m_id ?>">
            <button class="btn btn-dark mx-4" type="submit">確定刪除</button>
            <a href="./manage_members.php" class="btn btn-secondary mx-4">返　　回</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->

</body>

</html>
<?php
$stmt->close();
$db_link->close();
?>