<?php if (!session_id()) {
  session_start();
} ?>

<!-- style -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/main.css">
<!-- icon -->
<link rel="icon" href="./favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />

<script>
  var productCount = localStorage.getItem("productCount");
</script>

<style>
  .sticky-top {
    transition: background-color 0.3s ease;
  }

  .bg-secondary {
    background-color: rgba(0, 0, 0, .8) !important;
  }

  .navbar-brand {
    font-family: 'Merienda', cursive;
  }

  .navbar-brand:hover {
    text-decoration: none;
  }
</style>



<div class="container-fluid customNav sticky-top bg-dark " data-bs-theme="dark">
  <div class="container">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <!-- 左區 -->
        <a class="navbar-brand" href="./index.php">YUNA.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>" href="./index.php">首頁</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'news_all.php') echo 'active'; ?>" href="./news_all.php">最新消息</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'branch.php') echo 'active'; ?>" href="./branch.php">服務據點</a>
            </li> -->
            <!--  -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?php if (in_array(basename($_SERVER['PHP_SELF']), ['pro_home.php', 'pro_phone.php', 'pro_watch.php', 'pro_travel.php'])) echo 'active'; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                產品
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./pro_home.php">家電</a></li>
                <li><a class="dropdown-item" href="./pro_phone.php">手機</a></li>
                <li><a class="dropdown-item" href="./pro_watch.php">手錶</a></li>
                <li><a class="dropdown-item" href="./pro_travel.php">旅行</a></li>
              </ul>
            </li>
          </ul>
          <!-- 左區 end -->

          <!-- 右區 -->
          <!-- 搜尋 -->
          <form class="d-flex ms-auto" role="search" action="./search.php" method="post">
            <input class="form-control me-2" type="search" name="search_keywords" placeholder="請輸入產品關鍵字" aria-label="Search">
            <button class="btn" type="submit">
              <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #ffffff;"></i>
            </button>
          </form>
          <!-- 購物車 -->
          <a class="nav-link mx-lg-3 mt-3" href="./shoppingCart.php">
            <button type="button" class="btn position-relative ps-0 py-sm-1">
              <i class="fa-solid fa-shopping-cart top-50 start-50 translate-middle-y" style="color: #ffffff;"></i>

              <?php echo '<script>
                            if ((productCount != null)&&(productCount != 0)) {
                              document.write("<span class=\'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\'>+" + productCount + "</span>");
                            } 
                          </script>';
              ?>

            </button>
          </a>
          <!-- 會員 -->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user mx-1" style="color: #ffffff;"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="./mem_profile.php">會員資料</a></li>
              <li><a class="dropdown-item" href="./mem_order.php">訂單紀錄</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="./mem_login.php">
                  <?php
                  if (isset($_SESSION["loginMember"]) && ($_SESSION["memberLevel"] == "member")) {
                    echo "登出";
                  } else {
                    echo "登入";
                  }
                  ?>
                </a></li>
              <?php
              if (!isset($_SESSION["loginMember"]) || ($_SESSION["memberLevel"] != "member")) {
                echo "<li>
                    <hr class='dropdown-divider'>
                  </li>
                  <li><a class='dropdown-item' href='./manager_login.php'>管理系統</a></li>";
              }
              ?>
            </ul>
          </div>
          <!-- 左區 end -->
        </div>
      </div>
    </nav>
  </div>
</div>

<script>
  $(document).ready(function() {
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();

      if (scroll >= 100) {
        $(".sticky-top").removeClass("bg-dark");
        $(".sticky-top").addClass("bg-secondary");

      } else {
        $(".sticky-top").removeClass("bg-secondary");
        $(".sticky-top").addClass("bg-dark");
      }
    });
  });
</script>