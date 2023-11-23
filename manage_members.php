<?php
include("./conn/connMysql.php");

$sql_query = "SELECT * FROM members";
$result = $db_link->query($sql_query);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>會員管理系統</title>

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

  <?php include('./t_navbar.php') ?>

  <br><br>
  <div class="container">
    <!-- 使用table-sm將儲存格padding縮減一半的方式讓表格更加精簡 -->
    <table class="table table-hover table-sm caption-top">
      <caption>會員列表 (共<?php echo $result->num_rows ?>筆)</caption>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">姓名</th>
          <th scope="col">電話</th>
          <th scope="col">地址</th>
          <th scope="col">編輯</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php $i = 1;
        while ($i_result = $result->fetch_assoc()) { ?>

          <tr>
            <th class="py-2" scope="row"><?php echo $i++ ?></th>
            <td class="py-2"><?php echo $i_result['m_name'] ?></td>
            <td class="py-2"><?php echo $i_result['m_phone'] ?></td>
            <td class="py-2"><?php echo $i_result['m_addr'] ?></td>
            <td class="py-2">
              <a href="./manage_members_edit.php?a_id=<?php echo $i_result['m_id'] ?>">
                <button class="btn btn-secondary rounded-4 py-0 px-1">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
              </a>
              <a href="./manage_members_del.php?a_id=<?php echo $i_result['m_id'] ?>">
                <button class="btn btn-light rounded-4 py-0 px-1">X</button>
              </a>
            </td>
          </tr>


        <?php }; ?>
      </tbody>
    </table>
    <a href="./manage_members_add.php">
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