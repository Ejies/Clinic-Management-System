<?php 
		include 'config.php';
	$insert = "";
	error_reporting(0);
	

	session_start();
	if( isset($_SESSION['role'] ) ){
		
			header("Location: front-transact.php");
		}
	
	if($_POST['signin']):
		
			$username = $_POST['inputUser'];
			$password = $_POST['inputPassword'];
			
			$login_sql = "SELECT * FROM staff where user_name = '".$username."' and password= '".$password."' ";
			$result1 = $conn->query($login_sql);
			$login_err = "";
			if ($result1->num_rows > 0) {
				// output data of each row
				while($row = $result1->fetch_assoc()) {
					$_SESSION["staff_id"] = $row["staff_id"];
					$_SESSION["staff_username"] = $row["staff_username"];
					$_SESSION["staff_password"] = $row["staff_password"];
					$_SESSION["role"] = $row["role"];
					$_SESSION["center"] = $row["center_id"];
					$_SESSION["staff_name"] = $row["staff_fname"] ." " .$row["staff_lname"];
				}
				$log_sql = "INSERT INTO login_log (staff_id, last_login_date)
				VALUES ('".$_SESSION["staff_id"]."', now())";

				$conn->query($log_sql);
				
				header('Location: front-transact.php');
				
			} 
			else {
				$login_err =  '<div class="alert alert-danger">
								<strong>Oh snap!</strong> Username and Password Doesn\'t Match!</div>';
				
			}
			endif;	
?>
	
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
	
  </head>

  <body class="bg-dark">
	
    <div class="container">
      <div class="card card-login mx-auto mt-5">
	  <center> <img src="logo.png" width="300px" ></center>
        <div class="card-header">Login</div>
		<?php echo $login_err ;  ?>
        <div class="card-body">
          <form method="post" action="index.php">
            <div class="form-group">
              <div class="form-label-group">
                <input type="username" name="inputUser" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
                <label for="inputEmail">Username</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
				 <input type="hidden" name="signin" value="yes" >
                
                <input type="password" name="inputPassword" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Password</label>
              </div>
            </div>
			
			
            
            <button type="submit" class="btn btn-primary btn-block"  id="submit_comment">Login</button>
          </form>
       
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
