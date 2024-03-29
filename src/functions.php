<?php
include ("config/config.php");

function findNumberOfResults($db, $nId, $rId, $a){
    // NEED TO MAKE EXCEPTIONS FOR "ANY"
    try {
        $stmt = $db->prepare("select COUNT(*) from listings where neighborhoodId='$nId' 
        and roomTypeId='$rId' and accommodates>='$a'");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows[0]["COUNT(*)"];
}

function getResults($db, $nId, $rId, $a){
    // NEED TO MAKE EXCEPTIONS FOR "ANY"
    try {
        $stmt = $db->prepare("select * from listings where neighborhoodId='$nId' 
        and roomTypeId='$rId' and accommodates>='$a'");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}

function convertNeighborhoodId($db, $id){
    try {
        $stmt = $db->prepare("select neighborhood from neighborhoods where id='$id'");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows[0]["neighborhood"];
}

function convertRoomId($db,$id){
    try {
        $stmt = $db->prepare("select type from roomTypes where id='$id'");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows[0]["type"];
}

function getNeighborhoods($db){
    try {
        $stmt = $db->prepare("select * from neighborhoods order by neighborhood asc");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}

function getRoomTypes($db){
    try {
        $stmt = $db->prepare("select * from roomTypes order by type asc");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}


function dbConnect(){
    /* defined in config/config.php */
    /*** connection credentials *******/
    $servername = SERVER;
    $username = USERNAME;
    $password = PASSWORD;
    $database = DATABASE;
    $dbport = PORT;
    /****** connect to database **************/

    try {
        $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4;port=$dbport", $username, $password);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
    return $db;
}



?>