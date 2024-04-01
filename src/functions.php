<?php
include ("config/config.php");

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

function populateCards($db,$results, $numberOfResults){
    $cards = "";
    for ($i=0;$i<$numberOfResults;$i++){
        $cards.='<div class="col">
        <div class="card shadow-sm">
            <img src='. $results[$i]["pictureUrl"].'>
            <div class="card-body">
                <h5 class="card-title">'.convertNeighborhoodId($db, $results[0]["neighborhoodId"]).'</h5>
                <p class="card-text">'.$results[$i]["name"].'<br>'.convertRoomId($db, $results[$i]["roomTypeId"]).'</p>
                <p class="card-text">Accommodates '.$results[$i]["accommodates"].'</p>
    
                <p class="card-text align-bottom">
                <i class="bi bi-star-fill"></i><span class="">'.$results[$i]["rating"].'</span>
                </p>
    
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" id="3301" class="btn btn-sm btn-outline-secondary viewListing" data-bs-toggle="modal" data-bs-target="#fakeAirbnbnModal">View</button>
        
                    </div>
                    <small class="text-muted">$'.$results[$i]["price"].'</small>
    
                </div>
            </div>
        </div><!--.card-->
    </div><!--.col-->';
    }
    return $cards;
}

function findNumberOfResults($db, $nId, $rId, $a){
    try {
        if ($nId=='any' && $rId=='any'){
            $stmt = $db->prepare("select COUNT(*) from listings where accommodates>='$a'");
        }
        else if ($nId=='any'){
            $stmt = $db->prepare("select COUNT(*) from listings where
            roomTypeId='$rId' and accommodates>='$a'");
        }
        else if ($rId=='any'){
            $stmt = $db->prepare("select COUNT(*) from listings where neighborhoodId='$nId' 
            and accommodates>='$a'");
        }
        else{
            $stmt = $db->prepare("select COUNT(*) from listings where neighborhoodId='$nId' 
            and roomTypeId='$rId' and accommodates>='$a'");
        }
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows[0]["COUNT(*)"];
}

function getResults($db, $nId, $rId, $a){
    try {
        if ($nId=='any' && $rId=='any'){
            $stmt = $db->prepare("select * from listings where accommodates>='$a'");
        }
        else if ($nId=='any'){
            $stmt = $db->prepare("select * from listings where
            roomTypeId='$rId' and accommodates>='$a'");
        }
        else if ($rId=='any'){
            $stmt = $db->prepare("select * from listings where neighborhoodId='$nId' 
            and accommodates>='$a'");
        }
        else {
            $stmt = $db->prepare("select * from listings where neighborhoodId='$nId' 
            and roomTypeId='$rId' and accommodates>='$a'");
        }
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



?>