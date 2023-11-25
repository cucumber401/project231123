<?php // 用物件的方式建立資料庫物件連結

    // 設定變數(InfinityFree版)
    $db_host = "sql213.infinityfree.com";
    $db_username = "if0_35484634";
    $db_password = "1MFo6UHvQpTeqEo";
    $db_name = "if0_35484634_project0605";

    /*
    // 設定變數(xampp版)
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "1234";
    $db_name = "project0605";
    */
    
    //
    $db_link = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($db_link -> connect_error != ""){
        echo "資料庫連結失敗";
    }else {
        $db_link-> query("SET NAMES 'utf8'"); 
        //"SET NAMES 'utf8'"為指令字串
    }
?>