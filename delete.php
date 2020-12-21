<?php
require('database.php');
ob_start();

if (!empty($_GET)) {
    $response = array("error" => FALSE);
	
        $query = "DELETE FROM book_ticket WHERE ticket_number= :ticket";
	
	$query_params = array(
        ':ticket' => $_GET['ticket_number']
    );
	try {
        $stmt = $database->prepare($query);
        $result = $stmt->execute($query_params);
}
	catch (PDOException $ex) {
        $response["error"] = true;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
	
    $ticket=$_GET['ticket_number'];
    echo $ticket;
    if ($result) {
    	header("Location: myticket.php");  
    }
}
?>
