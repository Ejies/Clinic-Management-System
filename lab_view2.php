<?php
	include 'config.php';
?>
<?php
$cen_result = $conn->query('select * from clinics order by clinic_name ASC');
											 $clin_dd ="<select class=\"form-control  name=\"clinic\" id=\"clinic\" >
											 <option value=\"\">Select Clinic</option>\";
											 <option value=\"0\">SELF</option>";
											 if ($cen_result->num_rows > 0) {
											 // output data of each row
											 while($row = $cen_result->fetch_assoc()) {

											 $clin_dd .=" <option value=". $row["clinic_id"].">". $row["clinic_name"] ." -- " . $row["clinic_contact_name"]. "</option>";

											 }
											 }
													 $clin_dd .= "</select>";


										 ?>
										 
<?php
	 if($_POST['find'])
	{
		$time = strtotime($_POST['dated']);

		$newformat = date('Y-m-d',$time);
		$dept_table = '';
		$dept_table .=  "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">


       <thead>
           <tr>
             <th>Roll No</th>
              <th >Transaction No.</th>
               <th>Full Name</th>
               <th>Prognosis</th>
               <th>Department</th>
               <th>Tests</th>
               <th>Date</th>
               <th>Time</th>
               <th></th>
           </tr>
       </thead>

       <tfoot>
       <tr>
         <th>Roll No</th>
          <th >Transaction No.</th>
           <th>Full Name</th>
           <th>Prognosis</th>
           <th>Department</th>
           <th>Tests</th>
           <th>Date</th>
           <th>Time</th>
           <th></th>
       </tr>

       </tfoot>
           <tbody id=\"myTable\">";
		
			$trans1_data_sql = "SELECT * FROM trans INNER JOIN daliy_test ON trans.trans_no=daliy_test.trans_no WHERE Date(trans.dated) >= ".$newformat;
				$res1_data = $conn->query($trans1_data_sql);
				
				if ($res1_data->num_rows > 0) {
				while($row = mysqli_fetch_array($res1_data))
					{
					//here goes the data
			 //here goes the data
           $dt_id = $row["dt_id"];
           $depart = $row["depart"];
           $tname = $row["t_name"];
           $trans_no = $row["trans_no"];
           $timed = $row["timed"];
          
	
				$fname = $row["fname"];
				$lname = $row["lname"];
				$age = $row["age"];
				$sex = $row["sex"];
				$date = $row["dated"];
				$pro = $row["dia"];
			
			$trans_data_sql1 = "SELECT * FROM departments WHERE dep_id = $depart";
			$res_data1 = $conn->query($trans_data_sql1);
			while($row1 = mysqli_fetch_array($res_data1))
			{
				$dep_name = $row1["dep_name"];
				
			}
			
        

          $dept_table .= '<tr id="comment_box" ><td>'.$dt_id.'</td><td>'.$trans_no.'</td><td>'.$fname.' '.$lname.'</td><td>'.$pro.'</td><td>'.  $dep_name.'</td><td>'.$tname.'</td><td>'.$date.'</td><td>'.$timed.'</td><td> <button onclick="location.href=\'test.php?id='.$dt_id.'\'" class="btn btn-primary btn-sm">View</button></td></tr>';



         }
       }
       else
       {
        $dept_table .= '<tr id="comment_box"><td colspan="4" align="center"> <strong>  No Transaction!  </td></tr>';

       }
        $dept_table .="	</tbody>
       </table>";
	
	}
	else
	{
		header('Location: lab_view.php');
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
<script type="text/javascript">
		$(document).ready(function(){
      //display records on page load
      displaytrans();

      //on submit store record in variables and sent to action.php
      $("#submit_comment").click(function(){
        var fname = $("#inputFirstName").val();
        var lname = $("#inputLastName").val();
        var phonen = $("#inputPhone").val();
        var age = $("#inputAge").val();
        var sex = $("#sex").val();
        var clinic = $("#clinic").val();
        var dia = $("#inputPro").val();
        var depart = $("#countries-list").val();
        var tet = $("#tet").val();
        var fee = $("#fee").val();
        var paid = $("#paid").val();
        var bal = $("#bal").val();

        $.ajax({
  				url: "actions.php",
  				type: "POST",
  				async: false,
  				data: {
  					 "send": 1,
  					 "fname": fname,
  					 "lname": lname,
  					 "phonen": phonen,
						 "age":age,
						 "sex":sex,
  					 "clinic": clinic,
  					 "dia": dia,
						 "depart":depart,
  					 "tet": tet,
  					 "fee": fee,
  					 "paid": paid,
						 "bal":bal
  				},
          success: function(data){
						$("#inputFirstName").val("");
					  $("#inputLastName").val("");
					  $("#inputPhone").val("");
					  $("#inputAge").val("");
					  $("#sex").val("");
					  $("#clinic").val("");
					  $("#inputPro").val("");
					  $("#countries-list").val("");
					  $("#states").val("");
					  $("#fee").val("");
					  $("#paid").val("");
					  $("#bal").val("");
            //so new record after submit
            displaytrans();
            //display success message
						alert("Patient Submitted Successfully!!!");

  				}
        })
      });
		});

    function displaytrans(){
			$.ajax({
				url: "actions.php",
				type: "POST",
			  async: false,
				data:{
					 "lab" : 1
				},
				success: function(d) {
					$('#display_area').html(d);
				}
			});
		}
 </script>
 <script>
 $(document).ready(function(){
	 //display records on page load
	 $('#dat').hide();
	 $("#text").show();
 }
 $("#criteria").change(function () {
					var case = $( "#criteria option:selected" ).val();
					if(case=="dated")
					{
						//show 2 form fields here and show div
						 $("#dat").show();
						  $("#text").hide();
					}
					else {
						$("#dat").hide();
 						$("#text").show();
					}
			});
 </script>
    </head>

    <body id="page-top">

    <?php  include 'nav.php'; ?>

      <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidemenu.php'  ?>

        <div id="content-wrapper">

          <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="front-transact.php">Transaction</a>
              </li>
              <li class="breadcrumb-item active">Patient Record</li>
            </ol>

            <!-- Page Content -->
            <h1>Search </h1>
            <hr>
            <p>Search Records By Date </p>

            <form class="form-group" id="taxDetails"  method="POST" action="lab_view2.php">
				<div class="row clearfix">
							
					<div class="col-sm-4">
						<div class="form-group">    
						<input type="date"  name="dated" id="dated" class="form-control"   />
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">    
						<input type="hidden" name="find" value="yes">
						<button class="btn btn-raised btn-primary btn-round waves-effect" type="submit">Find Record </button></div>
					</div>
				</div>
				</form>
						<!-- End of Transaction -->

            <!--- Start Todays display-->

            <h1>Todays Patients</h1>
            <hr>
            <p>Manage Patient (<font style="color:red;">Note: To add new test for an exsisting patient, select the patient from the record below.</font>)</p>

            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-table"></i>
                Data Table Example</div>
              <div class="card-body">
                <div class="table-responsive" >
				<?php echo $dept_table; ?>

                </div>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>


          </div>
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
              <a class="btn btn-primary" href="login.html">Logout</a>
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
      <!-- Demo scripts for this page-->
      <script src="js/demo/datatables-demo.js"></script>
      <!-- Page level plugin JavaScript-->
      <script src="vendor/datatables/jquery.dataTables.js"></script>
      <script src="vendor/datatables/dataTables.bootstrap4.js"></script>



    </body>

  </html>
