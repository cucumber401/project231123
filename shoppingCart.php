<?php
$cart = [];
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>購物車</title>

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
    .cart_item_header {
      background-color: silver;
      border-top-left-radius: 3px;
      border-top-right-radius: 3px;
    }

    .cart_item {
      background-color: #f2f2f2;
      border-radius: 3px;
    }

    .cart_item_footer {
      background-color: #f2f2f2;
      border-bottom-left-radius: 3px;
      border-bottom-right-radius: 3px;
      border-top: #e0e0e0 1.5px solid;
    }
  </style>
</head>


<body>

  <?php include('./t_navbar.php') ?>
  <br><br><br>
  <div class="container-lg">
    <h3 class="text-center">購物車</h3>
    <br>
    <div id="cartZone">
      <!-- 購物車商品 -->
    </div>
    <div class="pt-4 container">
      <!-- <ul id="cart">
        顯示購物車清單(暫)
      </ul> -->
      <p class="text-end" id="total"></p>
      <div id="submitZone" class="my-5 text-center">
        <!-- 要傳送的資料+按鈕 -->
      </div>
    </div>
  </div>


  <!-- footer -->
  <?php include('./t_footer.php') ?>

  <script>
    var cart = [];
    if (localStorage.getItem("cart")) {
      cart = JSON.parse(localStorage.getItem("cart"));
      // JSON.parse()：接收JSON字串，轉為Javascript物件或是值
    }
    setCart();

    function setCart() {
      var cartList = "",
        cartZone = `<div class="container">
        <div class="container cart_items_container">
          <div class="row cart_item_header my-3 d-none d-md-flex">
            <div class="col-4">商品</div>
            <div class="col">單價</div>
            <div class="col">數量</div>
            <div class="col">小計</div>
            <div class="col">刪除</div>
          </div>
        `,
        submitZone = "",
        s_price = 0,
        total = 0;

      var productCount = cart.length;
      localStorage.setItem("productCount", productCount);

      if (cart.length == 0) {
        cartZone = `<div class="text-center">購物車暫無商品</div>`;
        submitZone = `<a class="btn btn-dark text-white mx-3" href="./pro_home.php">去逛逛</a>`;
      } else {
        // cartZone
        for (let i = 0; i < cart.length; i++) {
          s_price = cart[i]["price"] * cart[i]["amount"]; //小計
          total += s_price; // 總計
          cartList += `<li> ${cart[i]["name"]} , 單價: $${cart[i]["price"]}, 數量: ${cart[i]["amount"]}, 小計: $${s_price}</li>`;

          cartZone += `
            <div class="row cart_item align-items-center py-2 d-none d-md-flex">
              <div class="col-4">
                <div class="row align-items-center">
                  <div class="col-4" >
                    <img class="bg-light w-100 rounded-1" src="./photo/pro_home/${cart[i]["pic"]}">
                  </div>
                  <input type="hidden" class="productPic" value="${cart[i]["pic"]}">
                  <div class="col-8 card-title" >${cart[i]["name"]}</div>
                </div>
              </div>
              <div class="col">
                $${cart[i]["price"]}
              </div>
              <div class="col align-items-center" style="margin-left:-25px;">
                <button class="btn" onclick="cartUpdate(${i}, 'minus')">-</button>
                <span class="amount">${cart[i]["amount"]}</span>
                <button class="btn" onclick="cartUpdate(${i}, 'plus')">+</button>
              </div>
              <div class="col card-text" style="margin-left:25px;">
                $${cart[i]["amount"] * cart[i]["price"]}
              </div>
              <div class="col">
                <button class="btn" onclick="cartItemRemove(${i})"><i class="fa-regular fa-trash-can" style="color: #787878;"></i></button>
              </div>
            </div>
            <!-- ------------手機板------------- -->
            <div class="container-fuild my-3" style="min-width:200px;">
              <div class="row cart_item align-items-center mt-2 d-flex d-md-none">
                <!-- 圖片 -->
                <div class="col-4 ">
                  <div class="row align-items-center m-2">
                    <img class="bg-light w-100 rounded-1" src="./photo/pro_home/${cart[i]["pic"]}">
                    <input type="hidden" class="productPic" value="${cart[i]["pic"]}">
                  </div>
                </div>
                <div class="col-5 ">

                  <!-- 商品名稱 -->
                  <div class="row card-title mb-0"><strong>${cart[i]["name"]}</strong></div>
                  <!-- 單價 -->
                  <div class="row lead"><small>$${cart[i]["price"]}</small></div>

                  <!-- 數量 -->
                  <div class="row align-items-center">
                    <button class="btn col-2 offset-0 text-end" onclick="cartUpdate(${i}, 'minus')"><i class="fa-solid fa-minus" style="color: #787878;"></i></button>
                    <span class="amount col-2 text-center">${cart[i]["amount"]}</span>
                    <button class="btn col-2 text-start" onclick="cartUpdate(${i}, 'plus')"><i class="fa-solid fa-plus" style="color: #787878;"></i></button>
                  </div>

                </div>
                <div class="col-3 ">
                <!-- 刪除 -->
                  <div class="row p-0 m-0 ">
                    <button class="btn text-end" onclick="cartItemRemove(${i})"><i class="fa-regular fa-trash-can" style="color: #787878;"></i></button>
                  </div> 
                </div>
              </div>
              <div class="row cart_item_footer align-items-center mb-2 py-1 d-flex d-md-none">
              <!-- 小計 -->
                  <div class="col card-text text-end">小計 : $${cart[i]["amount"] * cart[i]["price"]}</div>
              </div>
            </div>`
          ;
        }
        cartZone += `</div></div>`;

        // submitZone
        submitZone += `<form action="./transaction.php" method="post">
        <input type="hidden" name="cartdetail" value="${cartList}">
        <input type="hidden" name="carttotal" value="${total}">
        <button class="btn btn-dark text-white mx-3" id="buy" type="submit">結帳</button>
        <a class="btn btn-secondary text-white mx-3" onclick="cartClear()">清空</a>
        <a class="btn btn-dark text-white mx-3" href="./pro_home.php">再逛逛</a>
        </form>`;

        $("#total").text("總價： " + total + "元");

      }

      $("#cartZone")
        .empty()
        .append(cartZone);

      $("#submitZone")
        .empty()
        .append(submitZone);


      // $("#cart")
      //   .empty()
      //   .append(cartList);

      localStorage.setItem("cart", JSON.stringify(cart));

    };

    function cartClear() {
      let ask = confirm("確定清空購物車?");
      if (ask == true) {
        cart = [];
        localStorage.removeItem("cart");
        setCart();
        location.reload();
      }
    };

    // +-
    function cartUpdate(i, operate) {
      if (operate == "minus") {
        cart[i].amount = Number(cart[i].amount) - 1;
        if (cart[i].amount <= 0) {
          let ask = confirm("確定將此商品移除購物車?");
          if (ask == true) {
            cart.splice(i, 1);
          } else {
            cart[i].amount = Number(cart[i].amount) + 1;
          }
        }
      } else {
        cart[i].amount = Number(cart[i].amount) + 1;
      }
      setCart();
    }

    function cartItemRemove(i) {
      let ask = confirm("確定將此商品移除購物車?");
      if (ask == true) {
        cart.splice(i, 1);
        setCart();
      }

    }
  </script>

</body>

</html>