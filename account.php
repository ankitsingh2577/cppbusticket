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
else{ ?>
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
 <div><a class="logout" href="index.php" onclick="logout_cookie()">Logout</a></div>   
<div><a class="home" style="text-decoration:none" href="home.php">Home</a></div>
<div><a class="book" style="text-decoration:none" href="book.php">Book Ticket</a></div>
<div><a class="ticket" style="text-decoration:none" href="myticket.php">My Ticket</a></div>
<div><a class="my-account" style="text-decoration:none" href="account.php">Account</a></div>
<div><a class="feedback" style="text-decoration:none" href="feedback.php">Feedback</a></div>
    
    <div class="tab-header"><h1 style="text-align: center; font-weight: bold; color: #000000; font-family: sans-serif; margin-top: -46px";>! Bus Ticket Booking System !</h1></div>
    <div><p class="book-ticket">My Account</p></div>
    <div class="home-container">
        <div class="ticket-container">
            <?php
	$response = array("error" => FALSE);
	$query = "SELECT * FROM users WHERE email = :email";
        $query_params = array(
        ':email' => $email	
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
	
    if($result!=0){
            while($row = $stmt->fetch())
              {?>


        	<img src="user_img.png" alt="Avatar" class="avatar">
      		<table class="table">
      		    <caption> </caption>
				<tr>
				  <th scope="row">Name :</th>
				  <td><?php echo $row['name']?></td>
				</tr>
				<tr>
				  <th scope="row">Email :</th>
				  <td><?php echo $row['email']?></td>
				</tr>
				<tr>
				  <th scope="row">Mobile :</th>
				  <td><?php echo $row['mobile_number']?></td>
				</tr>
    </table> 
		<div>\n\n\n\\n</div>
    <a type="submit" href="https://bus-ticket.s3.amazonaws.com/%24tickets.pdf" id="upticket" style="background: #1b083d; color: #ffffff;
  border: none;
  margin-top: 20px; 
  border-radius: 4px;
  font-size: 10pt;
  padding: 10px;
  cursor: pointer;
  margin-bottom: 5px;
  margin-left: 180px;
  box-shadow: 1px 2px 5px #1b1b1b; ">Download Uploadad Ticket</a> 
    </div></div> 
   
    <?php }
}
?>

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
