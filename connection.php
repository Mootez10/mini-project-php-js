<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "js";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error){
        die("conn failed".$conn->connect_error);
    }
    echo "";
?>