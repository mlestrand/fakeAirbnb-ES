<?php
/* PHP code for AJAX interaction goes here */

// receives listing ID from script.js + performs SQL queries
// after retrieving data, returns JSON to results.php

include("src/functions.php");
$db=dbConnect();
try {
    $stmt = $db->prepare("select * from listings where id='$_POST['listing_id]'");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch (Exception $e) {
    echo $e;
}
return $data;

?>