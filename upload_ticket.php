<?php
require('database.php');
ob_start();
   $email=$_COOKIE['email'];
// If cookies is empty them redirect to login page
if($_COOKIE['email']==""){
  header("Location: login.php");
}
//If cookies is present then page will load
else{ 
 
	if (!empty($_POST)) {
      $response = array("error" => FALSE);
    $query = "UPDATE book_ticket SET date= :date WHERE ticket_number= :ticket";
	
		$query_params = array(
        ':date' => $_POST['date'],
	':ticket' => $_COOKIE['ticket']		
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
	
    if ($query ) {
        header("Location: myticket.php");  
    }
}
?>	
	
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Ticket Page</title>
    
    <link rel="stylesheet" href="style.css">
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.119.0.min.js"></script>
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
    
    <div class="tab-header"><h1 style="text-align: center; font-weight: bold; color: #000000; font-family: sans-serif; margin-top: -46px";>! Bus Ticket Booking System !</h1></div>
    <div><p class="book-ticket">UPLOAD TICKET</p></div>
    <div class="home-container">
        <div class="ticket-container">
        <div class="form">
      <!-- input filled for name -->
      <input  type="file" id="file-chooser" style="margin-top: 80px; background: #1b083d; color: #ffffff; border: none;
  border-radius: 4px;
  font-size: 10pt;
  padding: 10px;
  cursor: pointer;
  margin-bottom: 5px;
  margin-left: 120px;
  box-shadow: 1px 2px 5px #1b1b1b;" />
      <div>\n\n</div>
      <button id="upload-button" style="margin-top: 20px; background: #1b083d; color: #ffffff; border: none;
  border-radius: 4px;
  font-size: 10pt;
  padding: 10px;
  cursor: pointer;
  margin-bottom: 5px;
  margin-left: 180px;
  box-shadow: 1px 2px 5px #1b1b1b;"">Upload to S3</button>
    <div id="results"></div>
  </div>
</div>

</div> </div>
<script type="text/javascript">
    AWS.config.region = 'us-east-1'; // 1. Enter your region

    AWS.config.credentials = new AWS.CognitoIdentityCredentials({
        IdentityPoolId: 'us-east-1:3ea06c31-5925-4807-b391-fb7a56da2619' // 2. Enter your identity pool
    });

    AWS.config.credentials.get(function(err) {
        if (err) alert(err);
        console.log(AWS.config.credentials);
    });

    var bucketName = 'bus-ticket'; // Enter your bucket name
        var bucket = new AWS.S3({
            params: {
                Bucket: bucketName
            }
        });

        var fileChooser = document.getElementById('file-chooser');
        var button = document.getElementById('upload-button');
        var results = document.getElementById('results');
        button.addEventListener('click', function() {

            var file = fileChooser.files[0];

            if (file) {

                results.innerHTML = '';
                var objKey = file.name;
                var params = {
                    Key: objKey,
                    ContentType: file.type,
                    Body: file,
                    ACL: 'public-read'
                };

                bucket.putObject(params, function(err, data) {
                    if (err) {
                        results.innerHTML = 'ERROR: ' + err;
                    } else {
                        listObjs(); // this function will list all the files which has been uploaded
                        //here you can also add your code to update your database(MySQL, firebase whatever you are using)

                    }
                });
            } else {
                alert("Nothing to upload");
            }
        }, false);
        function listObjs() {
            var prefix = 'testing';
            bucket.listObjects({
                Prefix: prefix
            }, function(err, data) {
                if (err) {
                    results.innerHTML = 'ERROR: ' + err;
                } else {
                    var objKeys = "";
                    data.Contents.forEach(function(obj) {
                        objKeys += obj.Key + "<br>";
                    });
                    results.innerHTML = objKeys;
                    alert("File uploaded sucessfully");
                    header("Location: welcome.html");
                }
            });
        }
        </script>

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
