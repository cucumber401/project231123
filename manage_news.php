<?php
include("./conn/connMysql.php");

$sql_query = "SELECT * FROM news";
$result = $db_link->query($sql_query);

// page
// $data_nums = $result_news -> num_rows; //統計總比數
// $per = 3; //每頁顯示項目數量
// $pages = ceil($data_nums / $per); //取得不小於值的下一個整數
// if (!isset($_GET["page"])) { //假如$_GET["page"]未設置
//   $page = 1; //則在此設定起始頁數
// } else {
//   $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
// }
// $start = ($page - 1) * $per; //每一頁開始的資料序號
// $result_news = $db_link->query("$sql_query LIMIT $start,$per");

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>最新消息</title>

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
    .containerTitle {
      color: black;
    }

    .active>.page-link,
    .page-link.active {
      background-color: var(--bs-dark);
      border-color: var(--bs-dark);
    }

    a {
      text-decoration: none;
    }
  </style>
</head>


<body>

  <!-- navbar start -->
  <?php include('./t_navbar.php') ?>
  <!-- navbar end -->

  <br><br>
  <div class="container">
    <!-- 使用table-sm將儲存格padding縮減一半的方式讓表格更加精簡 -->
    <table class="table table-hover table-sm caption-top">
      <caption>最新消息 (共<?php echo $result->num_rows ?>筆)</caption>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">類別</th>
          <th scope="col">標題</th>
          <th scope="col">上架日期</th>
          <th scope="col">下架日期</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php $i = 1;
        while ($i_result = $result->fetch_assoc()) { ?>

          <tr>
            <th class="py-2" scope="row"><?php echo $i++ ?></th>
            <td class="py-2"><?php echo $i_result['n_type'] ?></td>
            <td class="py-2"><?php echo $i_result['n_title'] ?></td>
            <td class="py-2"><?php echo $i_result['n_start_date'] ?></td>
            <td class="py-2"><?php echo $i_result['n_end_date'] ?></td>
            <td class="py-2">
              <a href="./manage_news_edit.php?n_id=<?php echo $i_result['n_id'] ?>"><button class="btn btn-secondary rounded-4 py-0 px-1"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
              <a href="./manage_news_del.php?n_id=<?php echo $i_result['n_id'] ?>"><button class="btn btn-light rounded-4 py-0 px-1">X</button></a>
            </td>
          </tr>

        <?php }; ?>
      </tbody>
    </table>
    <a href="./manage_news_add.php">
      <button class="btn btn-dark rounded-4 py-0 px-2">
        <i class="fa fa-plus" aria-hidden="true"></i>
      </button>
    </a>
  </div>

  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>
</body>

</html>