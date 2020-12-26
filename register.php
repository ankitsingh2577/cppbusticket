<?php
//import database config.php file
require('database.php');
//turn on buffer output
ob_start();

// If form submitted, insert values into the database.
if (!empty($_POST)) {
  $response = array("error" => FALSE);
    $email = $_POST['email'];
    
    $query = "INSERT INTO users (name, email, mobile_number, password) VALUES (:name, :email, :mobile, :password)";
    $query_params = array(
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
	':mobile' => $_POST['mobile_number'],   
        ':password' => hash("sha512",$_POST['password'])
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
            echo 'alert("Registered successfully");'; 
            echo 'window.location.href = "login.php";';
            echo '</script>';
        }
}
        else{
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
    
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
   <div><h4 style="position: absolute; margin-left: 130px; font-weight: bold; color: #000000; font-family: sans-serif;";>*** Password: Atleast one Uppercase and Lowercase alphabet, Number and Special character Required ***</h4> </div>
    <div class="page-container">
        
        <div class="login-container">
            <div class="form-header">
                
                <div class="login-txt">
                    Sign up
                </div> 
                <div class="dark-side">

                </div>  
            </div>

           
                  <form  action="" method="post">
                    <div class="form-body">
                    <input type="text" name="name" id="name" placeholder="Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /><div class="validation"></div>
                    
                <input type="email" name="email" id="email" placeholder="Email" data-rule="email"  data-msg="Please enter a valid email" />  <div class="validation"></div> 
            
                <input type="text" name="mobile_number" id="mobile_number" placeholder="Enter mobile number" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /><div class="validation"></div>
            
                     <input type="password" name="password" id="password" placeholder="Enter Your Password" data-rule="password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]).{8,}"/>
                
                     <a class="redirect-link" href="login.php">Sign In</a>
                      <button type="submit" method="post"> Sign-Up
                         </button>
    </div>
    </form>
    </div>
    </div>
</body>
</html>
<?php }?>
