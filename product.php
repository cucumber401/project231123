<?php
// 獲取URL中的p_id參數值
if (isset($_GET['p_id'])) {
  $productId = $_GET['p_id'];
  // 根據$productId執行相應的資料庫查詢或其他操作
  // 顯示相關產品資訊
}
?>
<?php
include("./conn/connMysql.php");

$sql_query = "SELECT * FROM products WHERE p_id = $productId";
$result = $db_link->query($sql_query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>商品詳情</title>

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

  <style>
    .customFoot {
      background-image: url(./photo/H1_background.png);
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
      font-size: 1.1rem;
    }

    .proSlogan {
      color: #000000;
      font-weight: 400;
      font-size: 1.5rem;
    }

    .btnMore {
      z-index: 0;
      border-radius: 64px;
    }

    .carousel-control-prev-icon {
      background-image: url('./icon/chevron-left-solid.svg');
    }

    .carousel-control-next-icon {
      background-image: url('./icon/chevron-left-solid.svg');
      transform: rotate(180deg);
    }

    .carousel-indicators [data-bs-target] {
      box-sizing: content-box;
      flex: 0 1 auto;
      width: 30px;
      height: 3px;
      padding: 0;
      margin-right: 3px;
      margin-left: 3px;
      text-indent: -999px;
      cursor: pointer;
      background-color: #111111;
      background-clip: padding-box;
      border: 0;
      border-top: 10px solid transparent;
      border-bottom: 10px solid transparent;
      opacity: .5;
      transition: opacity .6s ease
    }

    .carousel-indicators .active {
      opacity: 1
    }

    .colorNav-ul {
      display: inline-block;
      list-style: none;
      margin: 0 0 10px -30px;
    }

    .colorNav-li {
      list-style: none;
    }

    a {
      text-decoration: none;
      color: black;
    }

    
  </style>
</head>


<body>
  <?php include('./t_navbar.php') ?>

  <!-- goTop按鈕 -->
  <div class="btnGoTop fixed-bottom d-flex justify-content-end p-3">
    <i onclick="goTop()" class="fa-sharp fa-solid fa-circle-chevron-up" style="color: gray; font-size: 54px; cursor: pointer;"></i>
  </div>

  <!-- 商品款式 -->
  <!-- md -->
  <div class="container justify-content-center">
    <div class="row productDiv_pic align-items-center">
      <?php while ($i_result = $result->fetch_assoc()) { ?>
        <!-- 左 -->
        <div class="col-6 offset-md-1 col-md-5">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="./photo/pro_home/<?php echo $i_result['p_pic'] ?>" class="d-block w-100">
                <input type="hidden" class="productPic" value="<?php echo $i_result['p_pic'] ?>">
              </div>
              <div class="carousel-item">
                <img src="./photo/pro_home/<?php echo $i_result['p_pic'] ?>" class="d-block w-100">
              </div>
              <div class="carousel-item">
                <img src="./photo/pro_home/<?php echo $i_result['p_pic'] ?>" class="d-block w-100">
              </div>
            </div>
            <br>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <!-- 右 -->
        <div class="col-6 productDiv col-md-4 pt-lg-5 offset-lg-1">
          <br>
          <p class="h2 productName"><?php echo $i_result['p_name'] ?></p>
          <p class="lead productPrice">$<?php echo $i_result['p_price'] ?></p>
          <p class="lead productDesc"><small><?php echo $i_result['p_desc'] ?></small></p>
          <ul class="colorNav-ul">顏色 :
            <li class="colorNav-li">
              <input type="radio" name="color" id="color-white" checked>
              <label for="color-white">
                <img width="16" height="16" src="https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MNFX3_SW_COLOR?wid=64&amp;hei=64&amp;fmt=jpeg&amp;qlt=90&amp;.v=1645215538255">
              </label>
            </li>
            <li class="colorNav-li">
              <input type="radio" name="color" id="color-white">
              <label for="color-white">
                <img width="16" height="16" src="https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MNFV3_SW_COLOR?wid=64&amp;hei=64&amp;fmt=jpeg&amp;qlt=90&amp;.v=1645215538530">
              </label>
            </li>
          </ul>
          <br>
          <p> 數量 : </p>
          <input class="productAmount mb-2" type="number" value="1">
          <button class="btn btn-dark add_cart">加入購物車</button>
        </div>
      <?php }; ?>
    </div>
  </div>
  <!-- 商品款式 end -->

  <!-- 產品特色 -->
  <div class="container B my-5 px-5 w-75">
    <p class="my-2 lead">產品特色</p>
    <div class="row">
      <div class="col-12 h-100">
        <div class="shadow bg-body rounded-3 p-3">
          <img class="w-100" src="./photo/productDetail/p6.png">
          <p class="my-2 lead">LDS 雷射導航</p>
          <p class="">快速精確繪製地圖</p>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-6">
        <div class="shadow bg-body rounded-3 p-3 h-100">
          <img class="w-100" src="./photo/productDetail/p4.png">
          <p class="my-2 lead">4000Pa 強效吸力風扇鼓風機</p>
          <p class="">吸入各種灰塵</p>
        </div>
      </div>
      <div class="col-6">
        <div class="shadow bg-body rounded-3 p-3 h-100">
          <img class="w-100" src="./photo/productDetail/p5.png">
          <p class="my-2 lead">Z 字型與 Y 字型清潔路線</p>
          <p class="">大幅改善清潔效率</p>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-4">
        <div class="shadow bg-body rounded-3 p-3 h-100">
          <img class="w-100" src="./photo/productDetail/p1.png">
          <p class="my-2 lead">多個感測器</p>
          <p class="">辨識複雜的周遭環境</p>
        </div>
      </div>
      <div class="col-4">
        <div class="shadow bg-body rounded-3 p-3 h-100">
          <img class="w-100" src="./photo/productDetail/p2.png">
          <p class="my-2 lead">智慧水箱</p>
          <p class="">保護地板不因水而損壞</p>
        </div>
      </div>
      <div class="col-4">
        <div class="shadow bg-body rounded-3 p-3 h-100">
          <img class="w-100" src="./photo/productDetail/p3.png">
          <p class="my-2 lead">連接APP</p>
          <p class="">清潔模式自訂</p>
        </div>
      </div>
    </div>
  </div>
  <!-- 產品特色 end -->

  <br><br><br>
  <!-- 猜你喜歡 -->
  <div class="container">
    <h4>人氣商品</h4>
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="row m-1 py-3 shadow bg-body rounded-3">
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

      <div class="col-md-6 col-sm-12">
        <div class="row m-1 py-3 shadow bg-body rounded-3">
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
  <!-- 猜你喜歡end -->

  <!-- 最近瀏覽 -->
  <br><br><br>
  <div class="container my-3">
    <h4>最近瀏覽</h4>
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
  <!-- 最近瀏覽end -->

  <br><br><br><br><br><br>


  <!-- footer -->
  <?php include('./t_footer.php') ?>

  <script>
    var cart = [];
    if (localStorage.getItem("cart")) {
      cart = JSON.parse(localStorage.getItem("cart"));
      // JSON.parse()：接收JSON字串，轉為Javascript物件或是值
    }

    $(".add_cart").click(function() {
      let product = $(this).closest(".productDiv");
      console.log($(this).closest(".productDiv"));
      // 建一個物件
      let newItem = {
        name: product.find(".productName").text(),
        price: product.find(".productPrice").text().replace("$", ""),
        amount: product.find(".productAmount").val(),
        pic: $(this).closest(".productDiv_pic").find(".productPic").val()
      };

      let isDuplicate = false;
      for (let i = 0; i < cart.length; i++) {
        if (cart[i].name == newItem.name) {
          isDuplicate = true;
          if (newItem.amount == 0) {
            cart.splice(i, 1);
            break;
          }
          // 覆蓋舊的 `newItem` 物件
          cart[i] = newItem;
          break; // 停止迴圈，已經找到重複的商品
        }
      }
      if (!isDuplicate) { // 沒有重複的商品
        cart.push(newItem);
      }
      localStorage.setItem("cart", JSON.stringify(cart));
      // JSON.stringify() ：將Javascript物件轉為JSON字串

      var productCount = cart.length;
      localStorage.setItem("productCount", productCount);
      location.reload();
    });
  </script>

</body>

</html>