<?php
//import database config.php file
require('database.php');
//turn on buffer output
ob_start();
// If form submitted, insert values into the database.
if (!empty($_POST)) {
    $response = array("error" => FALSE);
    $email = $_POST['email'];
    $password=$_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = :email";
    
    $query_params = array(
        ':email' => $_POST['email']
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
    $row = $stmt->fetch();
	$name=$row['name'];
        $email=$row['email'];
        $mobile=$row['mobile_number'];
        $hash_password=hash("sha512", $password);
    $check_pass=strcmp($hash_password,$row['password']);
	
    if ($check_pass==0) {
	setcookie("name", "$name", time()+30*24*60*60, "/");
        setcookie("mobile", "$mobile", time()+30*24*60*60, "/");
        setcookie("email", "$email", time()+30*24*60*60, "/");
        session_start();
        header("Location: home.php");      
    }
  else{
      echo "Invalid password"; 
    }
  }
else{?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign in</title>
    
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
    <div class="page-container">
        <div class="login-container">
            <div class="form-header">
                
                <div class="login-txt">
                    Sign in
                </div> 
                <div class="dark-side">

                </div>  
            </div>
                  <form action="" method="post" >
                    <div class="form-body">
                        
                      <input type="email" name="email" id="email" placeholder="Email" data-rule="email"  data-msg="Please enter a valid email" />  <div class="validation"></div> 
                      <input type="password" name="password" id="password" placeholder="Enter Your Password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]).{8,}" />
                      <a class="redirect-link" href="register.php">Sign Up</a>
                     <button type="submit" method="post"> Sign-In
                         </button>
    </div>
    </form>
    </div>
    </div>
</body>
</html>
<?php }?>
