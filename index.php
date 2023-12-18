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

// ads
$sql_query_ads = "SELECT * FROM ads";
$result_ads = $db_link->query($sql_query_ads);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>首頁</title>

  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="./js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/278435b38a.js" crossorigin="anonymous"></script>
  <!-- style -->
  <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/main.css">
  <!-- icon -->
  <link rel="icon" href="./favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />

  <style>
    .customFoot {
      background-image: url(../photo/H1_background.png);
      background-position: top center;
      background-size: cover;
      background-repeat: no-repeat;
      color: white;
    }

    .customFoot h1 {
      font-weight: 700;
    }

    .proTop {
      margin: 0;
      color: #777777;
      font-size: 2vw;
    }

    .proTitle {
      font-size: 3vw;
      font-weight: 700;
    }

    .proSlogan {
      color: #000000;
      font-weight: 400;
      font-size: 2vw;
    }

    .btnMore {
      border-radius: 64px;
    }

    .containerTitle {
      color: black;
    }

    a {
      text-decoration: none;
      color: black;
    }

    a:hover {
      text-decoration: underline;
    }

    .recent-card a:hover {
      text-decoration: none;
    }
  </style>
</head>


<body>

  <?php include('./t_navbar.php') ?>

  <div>
    <!-- Carousel video -->
    <div class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <video autoplay muted loop class="w-100">
            <source src="https://terra-1-g.djicdn.com/851d20f7b9f64838a34cd02351370894/261%20shot%20on/shot%20on.mp4" type="video/mp4; codecs=&quot;avc1.4D401E, mp4a.40.2&quot;" src="https://terra-1-g.djicdn.com/851d20f7b9f64838a34cd02351370894/261%20shot%20on/shot%20on.mp4" type="video/mp4">
          </video>
          <div class="carousel-caption d-none d-md-block top-0 start-50 translate-middle-x">
            <p class="proTop">打開新視界</p>
            <p class="text-body fs-1 proTitle">智能空拍機 S10</p>
            <p class="proSlogan">空間智能，飛越邊界</p>
            <a href="./product.php"><button type="button" class="btn btn-outline-dark btnMore">查看更多 > </button></a>
          </div>
        </div>
      </div>
    </div>
    <!-- Carousel video end -->

    <!-- goTop按鈕 -->
    <div class="btnGoTop fixed-bottom d-flex justify-content-end p-3">
      <i onclick="goTop()" class="fa-sharp fa-solid fa-circle-chevron-up" style="color: gray; font-size: 54px; cursor: pointer;"></i>
    </div>

    <br><br>

    <!-- news -->
    <div class="container">
      <h3 class="containerTitle">最新消息 <span><a style="font-size: 0.85rem;" href="./news_all.php">more >></a></span></h3>
      <hr>
      <!-- <div class="list-group"> -->
      <?php while ($i_result_news = $result_news->fetch_assoc()) { ?>
        <div class="list-group-item list-group-item-action">
          <div class="row">
            <div class="col-9">
              <a href="./news.php?nid=<?php echo $i_result_news['n_id'] ?>">
                <p>
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
              </a>
            </div>
            <div class="col-3 text-end">
              <p style="font-size: 0.8rem;"><?php echo $i_result_news['n_start_date'] ?></p>
            </div>
          </div>
        </div>
      <?php }; ?>
    </div>
    <br>
    <!-- news end -->
    <br><br>
    <!-- Carousel 1 start -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php for ($i = 0; $i < $result_ads->num_rows; $i++) : ?>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i ?>" class="<?php echo $i == 1 ? 'active' : ''; ?>" aria-current="<?php echo $i == 1 ? 'true' : ''; ?>" aria-label="Slide <?php echo $i ?>"></button>
        <?php endfor; ?>
      </div>
      <div class="carousel-inner">
        <?php $isActive = 1;
        while ($i_result_ads = $result_ads->fetch_assoc()) { ?>
          <div class="carousel-item <?php echo $isActive == 1 ? 'active' : '';
                                    $isActive++; ?>" data-bs-interval="5000">
            <img src="./photo/index/<?php echo $i_result_ads['a_img'] ?>" class="d-block w-100 ">
            <div class="carousel-caption d-none d-sm-block position-absolute top-0 start-50 translate-middle-x" style="<?php echo $i_result_ads['a_text_style'] ?>">
              <p class="proTop"><?php echo $i_result_ads['a_sub_title'] ?></p>
              <p class="text-body proTitle"><?php echo $i_result_ads['a_title'] ?></p>
              <p class="proSlogan"><?php echo $i_result_ads['a_content'] ?></p>
              <a href="./product.php?p_id=<?php echo $i_result_ads['p_id'] ?>"><button type="button" class="btn btn-outline-dark btnMore">查看更多 > </button></a>
            </div>
          </div>
        <?php } ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <!-- Carousel 1 end -->
    <br><br><br><br>

    <!-- 人氣商品 -->
    <div class="container">
      <h4>人氣商品</h4>
      <div class="row">
        <div class="col-md-6 col-sm-12 my-3">
          <div class="row m-1 py-3 shadow bg-body rounded-3 h-100">
            <div class="col">
              <img class="w-100" src="./photo/pro_home/03.png">
            </div>
            <div class="col">
              <p class="lead">廚房好幫手</p>
              <h4>智能氣炸鍋</h4>
              <p class="lead">少油又低脂，烹飪更健康</p>
              <p class="lead">$2000</p>
              <a href="./product.php?p_id=3"><button class="btn btn-primary rounded-5">去看看</button></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-sm-12 my-3">
          <div class="row m-1 py-3 shadow bg-body rounded-3 h-100">
            <div class="col">
              <img class="w-100" src="./photo/pro_home/04.png">
            </div>
            <div class="col">
              <p class="lead">旅行良伴</p>
              <h4>行動電源</h4>
              <p class="lead">雙口輸入體驗更方便</p>
              <p class="lead">$666</p>
              <a href="./product.php?p_id=4"><button class="btn btn-primary rounded-5">去看看</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- 人氣商品end -->

    <!-- 最近瀏覽 -->
    <br><br><br>
    <div class="container my-3">
      <h4>最近瀏覽</h4>
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 my-2">
            <div class="card pic h-100">
              <div class="card-body">
                <h5 class="card-title text-truncate">智慧攝影機</h5>
                <p class="card-text text-truncate">雲台版 2K Pro</p>
                <div class="row align-items-center">
                  <p class="card-text">$1300</p>
                </div>
                <br>
                <!-- 將參數添加到產品連結的URL -->
                <div class="btnDIV position-relative">
                  <a href="./product.php?p_id=2">
                    <img class="card-img-top" src="./photo/pro_home/02.png">
                    <div class="position-absolute top-50 start-50 translate-middle btndiv">
                      <button class="btn btn-outline-dark rounded-pill btnMore">查看更多 > </button>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-2">
            <div class="card pic h-100">
              <div class="card-body">
                <h5 class="card-title text-truncate">Xiaomi 手環 7</h5>
                <p class="card-text text-truncate">無懼挑戰</p>
                <div class="row align-items-center">
                  <p class="card-text">$1500</p>
                </div>
                <br>
                <!-- 將參數添加到產品連結的URL -->
                <div class="btnDIV position-relative">
                  <a href="./product.php?p_id=10">
                    <img class="card-img-top" src="./photo/pro_home/10.png">
                    <div class="position-absolute top-50 start-50 translate-middle btndiv">
                      <button class="btn btn-outline-dark rounded-pill btnMore">查看更多 > </button>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-2">
            <div class="card pic h-100">
              <div class="card-body">
                <h5 class="card-title text-truncate">米家無線吸塵器G10</h5>
                <p class="card-text text-truncate">性能加倍，繁瑣減半</p>
                <div class="row align-items-center">
                  <p class="card-text">$6500</p>
                </div>
                <br>
                <!-- 將參數添加到產品連結的URL -->
                <div class="btnDIV position-relative">
                  <a href="./product.php?p_id=12">
                    <img class="card-img-top" src="./photo/pro_home/12.png">
                    <div class="position-absolute top-50 start-50 translate-middle btndiv">
                      <button class="btn btn-outline-dark rounded-pill btnMore">查看更多 > </button>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-2">
            <div class="card pic h-100">
              <div class="card-body">
                <h5 class="card-title text-truncate">智慧氣炸鍋</h5>
                <p class="card-text text-truncate">少油又低脂，烹飪更健康</p>
                <div class="row align-items-center">
                  <p class="card-text">$2000</p>
                </div>
                <br>
                <!-- 將參數添加到產品連結的URL -->
                <div class="btnDIV position-relative">
                  <a href="./product.php?p_id=3">
                    <img class="card-img-top" src="./photo/pro_home/03.png">
                    <div class="position-absolute top-50 start-50 translate-middle btndiv">
                      <button class="btn btn-outline-dark rounded-pill btnMore">查看更多 > </button>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- 最近瀏覽end -->
    <br><br><br><br><br>
  </div>
  <!-- footer -->
  <?php include('./t_footer.php') ?>

</body>

</html>