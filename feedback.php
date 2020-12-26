<?php
//import the config,php file to establish database connectivity
require('database.php');
//turn on buffer output
ob_start();

//retrive professor assigned lecture from cookies
$email=$_COOKIE["email"];

// If cookies is empty them redirect to login page
if($email==""){
  header("Location: index.php");
}
//If cookies is present then page will load
else{
// If form submitted, insert values into the database.

if (!empty($_POST)) {

  $response = array("error" => FALSE);
    
    $query = "INSERT INTO `feedback` (`name`, `email`, `mobile_number`, `buses`, `rating`) VALUES (:name, :email, :mobile, :buses, :rating)";
    $query_params = array(
  ':name' => $_COOKIE['name'],
        ':email' => $_COOKIE['email'],
  ':mobile' => $_COOKIE['mobile'],
        ':buses' => $_POST['buses'],
        ':rating' => $_POST['rating'],
           
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
        echo 'alert("Your Feedback has been recorded, Thankyou!");'; 
        echo 'window.location.href = "home.php";';
        echo '</script>';
        }
      }?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Account Page</title>
    
    <link rel="stylesheet" href="style.css">
     <script type = "text/javascript">
      history.pushState(null, null, location.href);
      history.back(); history.forward();
      window.onpopstate = function () { history.go(1); };
  </script>
</head>

<body onload="javascript:fetchValues()">
    <div id="bg">
        
    </div>
 <div><a class="logout" href="login.php" onclick="logout_cookie()">Logout</a></div>   
<div><a class="home" style="text-decoration:none" href="index.php">Home</a></div>
<div><a class="book" style="text-decoration:none" href="book.php">Book Ticket</a></div>
<div><a class="ticket" style="text-decoration:none" href="myticket.php">My Ticket</a></div>
<div><a class="my-account" style="text-decoration:none" href="account.php">Account</a></div>
<div><a class="feedback" style="text-decoration:none" href="feedback.php">Feedback</a></div>
    
    <div class="tab-header"><h1 style="text-align: center; font-weight: bold; color: #000000; font-family: sans-serif; margin-top: -46px";>! Bus Ticket Booking System !</h1></div>
    <div><p class="book-ticket">Give Feedback</p></div>
    <div class="home-container">
        <div class="ticket-container">

            <form action="" method="post">
            <div class="form-group"
            
            <label for="buses" style="color:black; margin-top: 4px" ><strong>Buses</strong></label>
        <select id="Origin" name="buses" size="1.2" class ="text-size">
          <option value="Click to select bus">Click to select bus</option>
          <option value="NCI Bus">NCI Bus</option>
          <option value="Londen Hills">Londen Hills</option>
          <option value="Patricks Travller">Patricks Travller</option>
          <option value="Trinity Bus">Trinity Bus</option>
          <option value="Dublin Bus">Dublin Bus</option>
        </select>
    
        <label for="rating" style="color:black; margin-top: 4px"><strong>Rating</strong></label>
        <select id="Destination" name="rating" size="1.2" class ="text-size">
          <option value="Click to give rating">Click to give rating</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
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
