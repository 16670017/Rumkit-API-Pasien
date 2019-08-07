<?php
/**
 * Created by PhpStorm.
 * User: iav
 * Date: 12/15/2018
 * Time: 2:20 AM
 */
include '../dbconn.php';
error_reporting(0);


    $querryTzmpilData = mysqli_query($db, "Select * from books");
    $arrayJson = array();
    while ($ambilData = mysqli_fetch_assoc($querryTzmpilData)){
    $arrayJson[]= $ambilData;
    }
    echo json_encode($arrayJson);

?>