<?php
include("./conn/connMysql.php");

$sql_query = "SELECT * FROM news WHERE n_start_date <= CURRENT_DATE && n_end_date >= CURRENT_DATE ORDER BY n_start_date ";
$result_news = $db_link->query($sql_query);


$data_nums = $result_news->num_rows; //統計總比數
$per = 3; //每頁顯示項目數量
$pages = ceil($data_nums / $per); //取得不小於值的下一個整數
if (!isset($_GET["page"])) { //假如$_GET["page"]未設置
  $page = 1; //則在此設定起始頁數
} else {
  $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
}
$start = ($page - 1) * $per; //每一頁開始的資料序號
$result_news = $db_link->query("$sql_query LIMIT $start,$per");
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
    .websitePath a:hover {
      text-decoration: underline;
    }

    .containerTitle {
      color: black;
    }

    a {
      text-decoration: none;
      color: black;
    }

    .page-link {
      color: black;
    }

    .active>.page-link,
    .page-link.active {
      background-color: var(--bs-dark);
      border-color: var(--bs-dark);
    }
  </style>
</head>


<body>
  <?php include('./t_navbar.php') ?>

  <!-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> -->

  <!-- news -->
  <br><br>

  <div class="container">
    <p class="websitePath">
      <a href="./index.php">首頁</a>>
      <a href="./news_all.php">最新消息</a>
    </p>

    <h3 class="containerTitle">最新消息</h3>
    <div class="list-group">
      <?php while ($i_result_news = $result_news->fetch_assoc()) { ?>
        <div class="list-group-item list-group-item-action">
          <!-- 標題 -->
          <a data-bs-toggle="collapse" href="#multiCollapseExample<?php echo $i_result_news['n_id'] ?>" aria-expanded="false">
          <div class="row">
              <div class="col">
                <p class="my-1">
                  <span class="badge <?php switch ($i_result_news['n_type']) {
                                        case "公告":
                                          echo "bg-info";
                                          break;
                                        case "活動":
                                          echo "bg-success";
                                          break;
                                        case "促銷":
                                          echo "bg-warning";
                                          break;
                                      } ?>">
                    <?php echo $i_result_news['n_type'] ?>
                  </span>
                  <?php echo $i_result_news['n_title'] ?>
                </p>
              </div>
              <div class="col-auto">
                <p class="my-1" style="font-size: 0.8rem;"><?php echo $i_result_news['n_start_date'] ?></p>
              </div>
            </div>
          </a>
          
          <!-- 內文(收起) -->
          <div class="row">
            <div class="collapse multi-collapse" id="multiCollapseExample<?php echo $i_result_news['n_id'] ?>">
              <br>
              <p class="my-1"><?php echo $i_result_news['n_content'] ?></p>
              <br>
            </div>
          </div>

        </div>
      <?php }; ?>
    </div>
  </div>
  <br>
  <!-- Pagination -->
  <div class="container">
    <div class="row">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="./news_all.php?page=<?php echo $page - 1 ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php for ($i = 1; $i <= $pages; $i++) { ?>

            <li class="page-item <?php if ($i == $page) {
                                    echo 'active';
                                  } ?>">
              <a class="page-link" href="./news_all.php?page=<?php echo $i ?>">
                <?php echo $i ?>
              </a>
            </li>
          <?php } ?>

          <li class="page-item">
            <a class="page-link" href="./news_all.php?page=<?php echo $page + 1 ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- Pagination end -->
  <!-- news end -->
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!--  -->

  <!-- footer -->
  <?php include('./t_footer.php') ?>
</body>

</html>