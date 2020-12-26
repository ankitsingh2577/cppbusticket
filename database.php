<?php
$password="x19205121";
$host = "busticketdb.ckdlhcaxf9fi.us-east-1.rds.amazonaws.com"; // AWS RDS-mysql database endpoint
$dbname = "busticket";
$username = "busticket";
 
// setting connection charset
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
 
    try { 
        // Connection Request to mysql database
        $database = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", "busticket", $username, $password, $options); 
        
    } catch(PDOException $ex) { 

        die("Failed to connect to the database: " . $ex->getMessage()); 
        echo "error";
    } 
    // sets an attribute on the database handle for error reporting
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
 
    // sets an atribute on the database handle to fetch array index by column name
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
 
  //automatically escape string
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) { 
        function undo_magic_quotes_gpc(&$array) { 
            foreach($array as &$value) { 
                if(is_array($value)) { 
                    undo_magic_quotes_gpc($value); 
                } 
                else { 
                 //Un-quotes a quoted string
                    $value = stripslashes($value); 
                } 
            } 
        } 
 
        undo_magic_quotes_gpc($_POST); // removes all slashes from $ _POST
        undo_magic_quotes_gpc($_GET);  // removes all slashes from $ _GET
        undo_magic_quotes_gpc($_COOKIE); // removes all slashes from $ _COOKIE
    } 
 
    header('Content-Type: text/html; charset=utf-8'); 
 
    session_start(); 
 
?>
