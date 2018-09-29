<?php
	include 'config.php';
	session_start();
	//error_reporting(0);
	if(empty($_SESSION['staff_id']) && empty($_SESSION['staff_username']) && empty($_SESSION['staff_password']) && empty($_SESSION['role'])) {
	   header("Location: index.php");
	}
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
     <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
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
					 "display" : 1
				},
				success: function(d) {
					$('#display_area').html(d);
				}
			});
		}
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
            <h1>Transaction</h1>
            <hr>
            <p>Enter New Patient (<font style="color:red;">Note: Fill in all the fields</font>)</p>

            <form id="taxDetails">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <div class="form-label-group" >
                      <input type="text" id="inputFirstName" class="form-control" name="fname" placeholder="First Name" required="required" autofocus="autofocus">
                      <label for="inputFirstName">First Name</label>
                    </div>
                  </div>
                </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-label-group" >
                        <input type="text" id="inputLastName" class="form-control" name="lname" placeholder="Last Name" required="required">
                        <label for="inputLastName">Last Name</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-label-group" >
                        <input type="phone" id="inputPhone" class="form-control" name="phone" placeholder="Phone" required="required">
                        <label for="inputPhone">Phone</label>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <div class="form-label-group" >
                      <input type="text" id="inputAge" class="form-control" name="age" placeholder="Age" required="required" autofocus="autofocus">
                      <label for="inputAge">Age</label>

                    </div>
                  </div>
                </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-label-group" >
                        <select name= "sex" id="sex" class="form-control">
                          <option>Select Sex</option>
                          <option>Male</option>
                          <option>Female</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-label-group" >
                        <?php echo $clin_dd;  ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <div class="form-label-group" >
                      <input type="text" id="inputPro" class="form-control" name="pro" placeholder="Prognosis"  autofocus="autofocus">
                      <label for="inputPro">Prognosis</label>

                    </div>
                  </div>
                </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-label-group" >
                        <?php

											$country_result = $conn->query('select * from departments');
											?><select class="form-control" name="country" id="countries-list">
											<option value="">Select Department</option>
											<?php
											if ($country_result->num_rows > 0) {
											// output data of each row
											while($row = $country_result->fetch_assoc()) {
											?>
											<option value="<?php echo $row["dep_id"]; ?>"><?php echo $row["dep_name"]; ?></option>
											<?php
											}
											}
											?>
                    </select>


                      </div>
                    </div>
                  </div>
                  <!-- JavaScript to get test based of departments 
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
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
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-label-group" >
                        <!-- JavaScript to get test based of departments 
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
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
                        <select  class="form-control" name="states"  id="states" >
                          <option>select Test</option>
                            </select>
                        <script>

										var form = document.getElementById('taxDetails');
										var sel = document.getElementById('states');
										form.elements.states.onchange = function () {
											var form = this.form;

											var daytxt = sel.options[sel.selectedIndex].text;

											form.elements.tet.value = daytxt;
											form.elements.fee.value = this.value;
										};
										</script>
                    <div class="toshow" style="display:none">
											<input type="text" id = "tet" name = "tet" class="form-control" />

											</div>

                      </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <div class="form-label-group" >
                      <input type="text" id="fee" class="form-control" name="fee"  disabled>
                    </div>
                  </div>
                </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-label-group" >
                        <input type="text" id="paid" class="form-control" name="paid" placeholder="Paid" required="required"  autofocus="autofocus">

                     <!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->




											<script>
												$('#paid').keyup(function(){
													var textone;
													var texttwo;
													textone = parseFloat($('#fee').val());
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
                        <input type="text" id="bal" class="form-control" name="bal"  disabled>

                      </div>
                    </div>
                  </div>
              </div>
              <br>
            </form>
            <center>  <input type="submit" class="btn btn-primary btn-block" style="width:10%;"  id="submit_comment"></center>
            <!-- End of Transaction -->

            <!--- Start Todays display-->

            <h1>Todays Patients</h1>
            <hr>
            <p>Manage Patient (<font style="color:red;">Note: To add new test for an exsisting patient, select the patient from the record below.</font>)</p>

            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-table"></i>
                Data Table </div>
              <div class="card-body">
                <div class="table-responsive" id="display_area">

                </div>
              </div>
              <div class="card-footer small text-muted">Updated Today at <?php echo date("h:i:sa"); ?></div>
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
      <!-- Demo scripts for this page-->
      <script src="js/demo/datatables-demo.js"></script>
      <!-- Page level plugin JavaScript-->
      <script src="vendor/datatables/jquery.dataTables.js"></script>
      <script src="vendor/datatables/dataTables.bootstrap4.js"></script>



    </body>

  </html>
