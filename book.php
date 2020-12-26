<?php
//import the config,php file to establish database connectivity


require('database.php');
//turn on buffer output
ob_start();

$email=$_COOKIE['email'];
$mobile=$_COOKIE["mobile"];
//retrive name & email from cookies
if($_COOKIE['email']==""){

  header("Location: login.php");
}
//If cookies is present then page will load
else{
// If form submitted, insert values into the database.

if (!empty($_POST)) {

  $response = array("error" => FALSE);
    
    $query = "INSERT INTO `book_ticket` (`name`, `email`, `mobile_number`, `origin`, `destination`, `date`, `ticket_number`, `buses`) VALUES (:name, :email, :mobile, :origin, :destination, :date, :ticket, :buses)";
    $query_params = array(
  ':name' => $_POST['name'],
        ':email' => $_COOKIE['email'],
  ':mobile' => $_POST['mobile_number'],
        ':origin' => $_POST['origin'],
        ':destination' => $_POST['destination'],
        ':date' => $_POST['date'],
  ':ticket' => random_int(100000000, 999999999), 
      ':buses' => $_POST['buses'],
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
    if($result){
        echo '<script type="text/javascript">'; 
        echo 'alert("Ticket Booked Sucessfully");'; 
        echo 'window.location.href = "index.php";';
        echo '</script>';
        
        }
      }?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
     <div><a class="logout" href="login.php" onclick="logout_cookie()">Logout</a></div>
<div><a class="home" style="text-decoration:none" href="index.php">Home</a></div>
<div><a class="book" style="text-decoration:none" href="book.php">Book Ticket</a></div>
<div><a class="ticket" style="text-decoration:none" href="myticket.php">My Ticket</a></div>
<div><a class="my-account" style="text-decoration:none" href="account.php">Account</a></div>
<div><a class="feedback" style="text-decoration:none" href="feedback.php">Feedback</a></div>
    
  <div class="tab-header"><h1 style="text-align: center; font-weight: bold; color: #000000; font-family: sans-serif; margin-top: -46px";>! Welcome to Bus Ticket Booking System !</h1></div>
    
    

    <div> <h2 style="position: absolute;  font-weight: bold; margin-top: 0px; color: #000000; font-family: sans-serif;";><marquee behavior="scroll" direction="left">*** Bus Ratings: <?php
    $query = "SELECT buses, avg(rating) FROM feedback GROUP BY buses";

      $result = $database->query($query);
      //loop through the returned data
      $data = array();
      foreach ($result as $row) {
      $data[] = $row;
      
      }
      $keys = array();
foreach ($data as $key) {
    $keys[$key["buses"]][] = $key["avg(rating)"];
}
foreach ($keys as $key => $vals) {
    echo "{$key}: " . max($vals) . ",\n\n";
}
      ?> ***</marquee></h2></div>
    
    <div><p class="book-ticket" style="margin-top: 25px">BOOK TICKET</p></div>
    <div class="home-container">
        <div class="ticket-container">

            <form action="" method="post">
            <div class="form-group">
                
            <input type="text" name="name" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /><div class="validation"></div>
            <input type="text" name="mobile_number" id="mobile_number" placeholder="Enter mobile number" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /><div class="validation"></div>
            
             <label for="buses" style="color:black; margin-top: 4px" ><strong>Buses</strong></label>
        <select id="Origin" name="buses" size="1.2" class ="text-size">
          <option value="Click to select bus">Click to select bus</option>
          <option value="NCI Bus">NCI Bus</option>
          <option value="Londen Hills">Londen Hills</option>
          <option value="Patricks Travller">Patricks Travller</option>
          <option value="Trinity Bus">Trinity Bus</option>
          <option value="Dublin Bus">Dublin Bus</option>
        </select>
              
              <label for="Origin" style="color:black; margin-top: 4px" ><strong>Origin</strong></label>
        <select id="Origin" name="origin" size="1.2" class ="text-size">
          <option value="Click to select your Origin">Click to select your Origin</option>
          <option value="Parnell Square Area">Parnell Square Area</option>
          <option value="O'Connell Street Area">O'Connell Street Area</option>
          <option value="The Quays">The Quays</option>
          <option value="Trinity College Area">Trinity College Area</option>
          <option value="St. Stephen's Green Area">St. Stephen's Green Area</option>
        </select>
    
        <label for="Destination" style="color:black; margin-top: 4px"><strong>Destination</strong></label>
        <select id="Destination" name="destination" size="1.2" class ="text-size">
          <option value="Click to select your Destination">Click to select your Destination</option>
          <option value="Parnell Square Area">Parnell Square Area</option>
          <option value="O'Connell Street Area">O'Connell Street Area</option>
          <option value="The Quays">The Quays</option>
          <option value="Trinity College Area">Trinity College Area</option>
          <option value="St. Stephen's Green Area">St. Stephen's Green Area</option>
        </select>

        <label for="Booking_date" style="color:black;margin-top: 3px"><strong>Booking Date</strong></label>
        <input type="date" placeholder="yyyy-mm-dd" id="date" name="date">
        <button type="submit" method="POST" > Submit</button>
        
        </div>
     
    </form></div></div> 
</body>
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
