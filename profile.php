<?php
  session_start();
	error_reporting(0);
	if(empty($_SESSION['staff_id']) && empty($_SESSION['staff_username']) && empty($_SESSION['staff_password']) && empty($_SESSION['role'])) {
	   header("Location: index.php");
	}
	include 'config.php';
	//Fetch Transaction Record -

		$dept_table = '';
    $del_hold = '';
			$row_id = $_GET['id'];
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
              $_SESSION["trans"] = $row["trans_no"];
              $_SESSION["ROW"]= $r_id;

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
            $dept_table1 = "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">


                <thead>
                    <tr>

                       <th >Transaction No.</th>
                        <th>Department</th>
                        <th>Test</th>
                        <th>Cost</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Time</th>
                        <th>Trash</th>
						<th>Pay</th>
                    </tr>
                </thead>

                <tfoot>
                <tr>
                <th >Transaction No. </th>
                 <th>Department</th>
                 <th>Test</th>
                 <th>Cost</th>
                 <th>Paid</th>
                 <th>Balance</th>
                 <th>Time</th>
                 <th>Trash</th>
				 <th>Pay</th>
                </tr>

                </tfoot>
                    <tbody id=\"myTable\">";
            $trans_data_sql1 = "SELECT * FROM daliy_test where trans_no='".$t_id."' order by timed DESC";
              $res_data1 = $conn->query($trans_data_sql1);
            $del_hold .='  <!-- Delete Modal-->
              <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">You should only delete this item if patient is changing their required test.</div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                      ';
					  $paybal="";
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

				if($balance > 0)
				{
					$paybal = '<button type="submit" onclick="location.href=\'pay_bal.php?id='.$row_id.'&dt_id='.$dt_id.'\'"
					class="btn btn-primary btn-sm"><i class="material-icons">Pay Balance</i> </button>';
				}
				else
				{
					$paybal = "N/A";
				}
                  // Displaying each rows

            $dept_table1 .= '<tr id="comment_box" ><td>'.$trans.'</td><td>'.$dept.'</td><td>'.$tname.'</td><td> '.$cost.'
			</td><td>'.$paid.'</td><td>'.  $balance.' </td><td>'.$t.'</td><td>
			<form action="test.php?id='.$row_id.'&trn='.$dt_id.'" method="post">
			<input type="hidden" name="deleted" value="yes">
			<button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\');
			" class="btn btn-primary btn-sm"><i class="material-icons">delete</i> </button></form></td><td>'.$paybal.'</td></tr>';
           
                }
                $del_hold .= '  </div>
                </div>
              </div>
            </div>';
        echo $del_hold;
              }
              else
              {
                $dept_table1 .=  '<tr id="comment_box"><td colspan="8" align="center"> <strong>  No Transaction!  </td></tr>';

              }
            $dept_table1 .= "	</tbody>
              </table>";




					}
				}
				else
				{
					$dept_table .= '<tr><td colspan="5" align="center"> <strong>  No Transaction!  </td></tr>';

				}



?>
<?php
if($_POST['deleted'])
	{
		$delete_id=$_GET['trn'];
		
		$j=0;
		$delete = "DELETE FROM daliy_test WHERE dt_id=".$delete_id;
		if ($conn->query($delete) === True)
		{
			$j++;
			$insert_err =  '<div class="alert alert-success" id="success-alert" >
			Success Message</div>' ;
			header("Refresh:0");
							
		}
		else
		{
			$insert_err =  '<div class="alert alert-danger" id="success-alert" >
			'.mysql_error() .'</div>';
		}
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
	<script src="jquery.min.js" ></script>
	<script>
	
	</script>
  </head>

  <body id="page-top">

  <?php include 'nav.php'; ?>

    <div id="wrapper">

      <!-- Sidebar -->
        <?php include 'sidemenu.php'  ?>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="front-transact.php">Transactions</a>
            </li>
            <li class="breadcrumb-item active">Patients Day Tests</li>
          </ol>

          <!-- Page Content -->
          <h1><?php echo $_SESSION["staff_name"]; ?></h1>
          <hr />
          <p>Below are the informtions of the above patient, Registerd Today.</p>
          <?php echo $dept_table; ?>
          <br />
          <hr />

          <!--- Start Todays display-->
			<?php echo $insert_err;  ?>
          <h1>Change Password</h1>
          <hr />
          <p>Manage Patient (<font style="color:red;">Note: To add new test for an exsisting patient, select the patient from the record below.</font>)</p>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
              Data Table </div>
            <div class="card-body">
               <div style="float:right;">
                 <button onclick="window.open('receipt.php?id=<?php echo $row_id; ?>', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400 ');" class="btn btn-primary btn-sm">Print Receipt</button>  
				 <button onclick="location.href='new_test.php?id=<?php echo $row_id; ?>'" class="btn btn-primary btn-sm">Add New Test</button>
                 <br /><br />
               </div>
              <div class="table-responsive" >
                <?php echo $dept_table1; ?>
              </div>
            </div>
            <div class="card-footer small text-muted">Updated Today at <?php echo date("h:i:sa"); ?></div>
          </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->


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
