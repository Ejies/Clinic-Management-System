<?php
  session_start();
	error_reporting(0);
	if(empty($_SESSION['staff_id']) && empty($_SESSION['staff_username']) && empty($_SESSION['staff_password']) && empty($_SESSION['role'])) {
	   header("Location: index.php");
	} 	include 'config.php';
	//Fetch Transaction Record -

		$dept_table = '';
		$dept_table1 = '';

			$row_id = $_GET['id'];
			$test_id = $_GET['dt_id'];

      $trans_data_sql = "SELECT * FROM trans where id=$row_id";
        $res_data = $conn->query($trans_data_sql);

        if ($res_data->num_rows > 0) {
        while($row = mysqli_fetch_array($res_data))
          {
          //here goes the data
            $r_id = $row["id"];
            $t_id = $row["trans_no"];
            $fname = $row["fname"];
            $lname = $row["lname"];
            $clinic_id = $row["clinic_id"];
            $phone = $row["phone"];
            $dia = $row["dia"];
            $age = $row["age"];
            $sex = $row["sex"];
            $date = $row["dated"] ;
            $time = $row["timed"] ;

						if ($clinic_id == 0)
						{
							$clinic = "SELF";

						}

						else
						{
							$clinic_data_sql = "SELECT * FROM clinics WHERE clinic_id=".$clinic_id;
							$res_data3= $conn->query($clinic_data_sql);
							while($row = mysqli_fetch_array($res_data3))
							{
								$clinic = $row["clinic_name"] ." -- ". $row["clinic_contact_name"] ;
							}
						}



						// Displaying each rows
						$dept_table .= '<table cellpadding ="10px" style="font-size:20px"><tr ><td ><Strong>Age:</strong> '. $age. '</td><td> <strong>Sex:</strong> ' . $sex .'</td></tr> <tr><td> <strong>Clinic: </strong> '. $clinic . '</td><td> <strong> Phone:</strong> ' . $phone . '</td></tr> <tr><td colspan="2"><strong> Prognosis:</strong> '.$dia.'</td></tr> </table>';
           
            $trans_data_sql1 = "SELECT * FROM daliy_test where dt_id=".$test_id;
              $res_data1 = $conn->query($trans_data_sql1);

               if ($res_data1->num_rows > 0) {
              while($row2 = mysqli_fetch_array($res_data1))
                {
                //here goes the data
                  $dt_id = $row2["dt_id"];
                  $dept = $row2["depart"];
                  $tname = $row2["t_name"];
                  $cost = $row2["cost"];
                  $paid = $row2["paid"];
                  $balance = $row2["balance"];
                  $trans = $row2["trans_no"];
                  $t = $row2["timed"];


                  // Displaying each rows

            $dept_table1 .= '<table cellpadding ="10px" style="font-size:20px"><tr ><td ><Strong>Cost:</strong>
			'. $cost. '</td><td> <strong>Paid:</strong> ' . $paid .'</td><td> <strong>Outstanding Balance: </strong> '. $balance . '</td><td> <strong> Test:</strong> ' . $tname . '</td></tr></table>';
           


                }
              
			   }
			   else
			   {
				   $dept_table1 .= '<tr><td colspan="5" align="center"> <strong>  No Transaction!  </td></tr>';

			   }
				   
					}
				}
				else
				{
					$dept_table .= '<tr><td colspan="5" align="center"> <strong>  No Transaction!  </td></tr>';

				}



?>
<?php
$error ="";
// insert New test for an Exsisting Patient
if(isset($_POST["sent"])){
  //$transno = $_session['trans'];
  $paid3 = $_POST['paid'];
  $bal = $_POST['bal'];
  $new_paid = $paid + $paid3;
  
  $update_sql = "UPDATE daliy_test SET paid ='".$new_paid."', balance='".$bal."' WHERE dt_id='".$test_id."'";
  if ($conn->query($update_sql) === TRUE) {
		header("Location: test.php?id=".$_SESSION["ROW"]);
  }
  else
  {
	  $error = "Something Went Wrong" .$conn->error; 
  }

  //$bal = mysqli_real_escape_string($_POST['bal']);

/*  $trans_sql = "INSERT INTO trans(trans_no, fname, lname, phone, age,sex, clinic_id, dia, dated, timed)
   VALUES ('$transno','$bal','$lname','$phonen', '$age','$sex','$clinic','$dia',now(),now())";
  $trans_sql = "INSERT INTO daliy_test(depart,t_name,cost,paid,balance,trans_no)
      VALUES ('$depart','$test_name','$cost','$paid','$bal', '$transno')";
*/
    //$conn->query($trans_sql2);
    /*$trans_sql = "INSERT INTO daliy_test(depart, t_name, cost, paid, balance,trans_no, timed)
                  VALUES ('$depart','$test_name','$cost','$paid', '$bal', '".$_SESSION["trans"]."',now())";
    if($conn->query($trans_sql))
    {
      header("Location: test.php?id=".$_SESSION["ROW"]);
    }
    else {
       echo error;
       exist();
    }*/

}

?>



<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Blank Page</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="jquery.min.js" ></script>
<script>
$('#countries-list').on('change', function(){
var country_id = this.value;
$.ajax({
type: "POST",
url: "get_test.php",
data:'country_id='+country_id,
success: function(result){
$("#states-list").html(result);

}
});
});
</script>
  </head>

  <body id="page-top">

    <?php include 'nav.php' ?>

    <div id="wrapper">

      <!-- Sidebar -->
      <?php include 'sidemenu.php'; ?>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.html">Transaction</a>
            </li>
            <li class="breadcrumb-item">
              <a href="test.php?id=<?php echo $row_id;?>">Patients Day Tests</a>
            </li>
            <li class="breadcrumb-item active">Pay Balance</li>
          </ol>

          <!-- Page Content -->
          <h1><?php echo $fname . " " . $lname ." ".$t_id?></h1>
          <hr>
          <p>Below are the informtions of the above patient, Registerd Today.</p>
          <?php echo $dept_table; ?>
          <br>
          <hr>

          <!--- Start Todays display-->

          <h1>Pay Balance</h1>
          <hr>
          <?php echo $error; ?>
          <form id="taxDetails" action="pay_bal.php?id=<?php echo $row_id; ?>&dt_id=<?php echo $test_id ?>" method="POST">
          <div class="row">
          <div class="col-lg-8">
            <div class="form-group">
              <div class="form-label-group" >
                <?php

              echo $dept_table1 ;
			  ?>


              </div>
            </div>
          </div>
          <!-- JavaScript to get test based of departments -->
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
          <script>
          $('#countries-list').on('change', function(){
          var country_id = this.value;
          $.ajax({
          type: "POST",
          url: "get_test.php",
          data:'country_id='+country_id,
          success: function(result){
          $("#states").html(result);


          }
          });
          });
          </script>
          <!-- End of JavaScript-->


      </div>
      <div class="row">
        <div class="col-lg-4" >
          <div class="form-group">
            <div class="form-label-group" >
             <strong style="font-size:20px">Enter New Payment : </strong>
			 <input type="text" id="paid" class="form-control" name="paid" placeholder="Paid" required="required"  autofocus="autofocus">

                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>




              <script>
                $('#paid').keyup(function(){
                  var textone;
                  var texttwo;
                  textone = parseFloat(<?php echo $balance;?>);
                  texttwo = parseFloat($('#paid').val());
                  var result = textone - texttwo;
                  $('#bal').val(result.toFixed(2));


                });
              </script>
            </div>
          </div>
        </div>
          <div class="col-lg-4">
            <div class="form-group">
              <div class="form-label-group" >
			   <strong style="font-size:20px">New Outstanding : </strong>
                 <input type="text" id="bal" class="form-control" name="bal"  readonly>

              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <div class="form-label-group" >
               
              </div>
            </div>
          </div>
      </div>
      <br>
      <input type="hidden" name="sent" value="ÿes" >
    <center>  <input type="submit" class="btn btn-primary btn-block" style="width:10%;"  id="submit_comment"></center>
    </form>
    <!-- End of Transaction -->

        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2018</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="sign-out.php">Logout</a>
          </div>
        </div>
      </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

  </body>

</html>
