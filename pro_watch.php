<?php
include("./conn/connMysql.php");

$sql_query = "SELECT * FROM products WHERE p_category='watch'";
$result = $db_link->query($sql_query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>手錶</title>

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

  <!-- Carousel 1 start -->
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./photo/index/xm_text.png" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="./photo/index/xm_text.png" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="./photo/index/xm_text.png" class="d-block w-100">
      </div>
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

  <br><br><br>
  <!-- <br><br><br><br><br><br> -->

  <div class="container">
    <div class="row">
      <?php while ($i_result = $result->fetch_assoc()) { ?>
        <div class="col-lg-4 col-md-6 my-2">
          <div class="card pic h-100">
            <div class="card-body">
              <h5 class="card-title text-truncate"><?php echo $i_result['p_name'] ?></h5>
              <p class="card-text text-truncate"><?php echo $i_result['p_desc'] ?></p>
              <div class="row align-items-center">
                <p class="card-text">$<?php echo $i_result['p_price'] ?></p>
              </div>
              <br>
              <!-- 將參數添加到產品連結的URL -->
              <div class="btnDIV position-relative">
                <a href="./product.php?p_id=<?php echo $i_result['p_id'] ?>">
                  <img class="card-img-top align-items-center" src="./photo/pro_home/<?php echo $i_result['p_pic'] ?>">
                  <div class="position-absolute top-50 start-50 translate-middle btndiv">
                    <button class="btn btn-outline-dark rounded-pill btnMore">查看更多 > </button>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

      <?php }; ?>
    </div>
  </div>

  <br><br>
  <!-- Pagination -->
  <div class="container">
    <div class="row">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- Pagination end -->
  <br><br>
  <!-- footer -->
  <?php include('./t_footer.php') ?>


  <script>

    function checkPro_on() {
      $(event.target).closest('.pic').find('.btnMore').css("visibility", "visible");
    }

    function checkPro_off() {
      $(event.target).closest('.pic').find('.btnMore').css("visibility", "hidden");
    }
    
  </script>
</body>

</html>