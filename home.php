<?php
//import the config,php file to establish database connectivity
require('database.php');
//turn on buffer output
ob_start();

$email=$_COOKIE['email'];

//retrive name & email from cookies
if($_COOKIE['email']==""){

  header("Location: index.php");
}
//If cookies is present then page will load
else{
// If form submitted, insert values into the database.
 //loop through the returned data
  $dataPoints = array();
try{
     // Creating a new connection.
    // Replace your-hostname, your-db, your-username, your-password according to your database
    $link = new \PDO(   'mysql:host=busticketdb.ckdlhcaxf9fi.us-east-1.rds.amazonaws.com;dbname=busticket;charset=utf8mb4', //'mysql:host=localhost;dbname=canvasjs_db;charset=utf8mb4',
                        'busticket', //'root',
                        'x19205121', //'',
                        array(
                            \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            \PDO::ATTR_PERSISTENT => false
                        )
                    );
  
    $handle = $link->prepare('SELECT buses, avg(rating) as rating FROM feedback group by buses');
    $handle->execute();
    $result = $handle->fetchAll(\PDO::FETCH_OBJ);
    
    foreach($result as $row){
        array_push($dataPoints, array("buses"=> $row-> buses, "y"=> $row-> rating));

    }
  $link = null;
}
catch(\PDOException $ex){
    print($ex->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  exportEnabled: true,
  theme: "dark2", // "light1", "light2", "dark1", "dark2"
  title:{
    text: ""
  },
  data: [{
    type: "column", //change type to bar, line, area, pie, etc  
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 
}
</script>

    <title>index page</title>
      
    <link rel="stylesheet" href="style.css">
     <script type = "text/javascript">
      history.pushState(null, null, location.href);
      history.back(); history.forward();
      window.onpopstate = function () { history.go(1); };
  </script>
  
</head> 

<body>
    <div id="bg">
        
    </div>
     <div><a class="logout" href="index.php" onclick="logout_cookie()">Logout</a></div>
<div><a class="home" style="text-decoration:none" href="home.php">Home</a></div>
<div><a class="book" style="text-decoration:none" href="book.php">Book Ticket</a></div>
<div><a class="ticket" style="text-decoration:none" href="myticket.php">My Ticket</a></div>
<div><a class="my-account" style="text-decoration:none" href="account.php">Account</a></div>
<div><a class="feedback" style="text-decoration:none" href="feedback.php">Feedback</a></div>
    
    <div class="tab-header"><h1 style="text-align: center; font-weight: bold; color: #000000; font-family: sans-serif; margin-top: -46px";>! Welcome to Bus Ticket Booking System !</h1></div>
    <div><p class="book-ticket">Buses Rating</p></div>
    <div class="home-container">
        <div class="ticket-container">
          <div id="chartContainer" style="height: 470px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
  function logout_cookie(){
    document.cookie = "name" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
    document.cookie = "email" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
    document.cookie = "mobile" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
     document.cookie = "ticket" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
  }
</script>
</html> 
<?php }?>
