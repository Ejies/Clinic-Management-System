<?php

	// Session authenticaton
	session_start();
	error_reporting(0);
	if(empty($_SESSION['staff_id']) && empty($_SESSION['staff_username']) && empty($_SESSION['staff_password']) && empty($_SESSION['role'])) {
	   header("Location: index.php");
	}
	
	// Database connection file 
	include 'config.php';
	
	// Fetch User Record
	$user_data_sql = "SELECT * FROM staff where staff_id = '".$_SESSION['staff_id']."' ";
		$result = $conn->query($user_data_sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$staff_id = $row["staff_id"];
				$center_id = $row["center_id"];
				$staff_fname = $row["staff_fname"];				
				$staff_lname = $row["staff_lname"];				
				$staff_email = $row["staff_email"];				
				$staff_phone = $row["staff_phone"];
				$staff_address = $row["staff_address"];
				$job_desc = $row["job_description"];
			}
		}
		else
		{
		}
		

	//Fetch Transaction Record - 
	
		$dept_table = '';
		
							
		$trans_data_sql = "SELECT * FROM clinics" ;
        $res_data = $conn->query($trans_data_sql);
		
		if ($res_data->num_rows > 0) {
        while($row = mysqli_fetch_array($res_data))
			{
            //here goes the data
				$c_id = $row["clinic_id"];
				$c_n = $row["clinic_name"];
				$c_cn = $row["clinic_contact_name"];
				$c_phone = $row["clinic_phone"];
				$c_add = $row["clinic_address"];
				
				
				
				
				
				
				
				// Displaying each rows
				$dept_table .= '<tr><td>'.$c_id.'</td><td>'.$c_n.'</td><td>'.$c_cn.'</td><td>'.$c_phone.'</td><td>'.$c_add.'</td><td> 
				<form action="edit_clinic.php?id='.$c_id.'&clinic='.$c_n.'&contact='.$c_cn.'&phone='.$c_phone .'
				 &add='.$c_add.'"
				 method="POST"><button class="btn btn-primary btn-round "><i class="material-icons">mode_edit</i></button></form></td><td><form action="" method="post"><button class="btn btn-primary btn-round btn-delete"  name="delete" value='.$clinic_id.' id='.$clinic_id.'><i class="material-icons">delete</i></button></form></td></tr>';
				
				
				
			}
		}			
		else
		{
			$dept_table .= '<tr><td colspan="5" align="center"> <strong>  No Clinic Registered!  </td></tr>';
		
		}
		
			$dept_table .='';
			
	
	// Inserting new department Record
		

	
	if($_POST['submit_dept']){
		$dept_name = $_POST["dept_name"];
		$i=0;
		
		$insert_dept_sql = "INSERT INTO departments (dep_name)
		VALUES ('".$dept_name."')";

		if ($conn->query($insert_dept_sql) === TRUE) {
			$i++;
			$insert_err =  '<div class="alert alert-success">
                            <div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-thumb-up"></i>
							</div>
							<strong>Well Done!!</strong> Record Successfully Added</div></div>' ;
							header("Refresh:0");
		} else {
			$insert_err =  '<div class="alert alert-danger">
							<div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-block"></i>
							</div>
                            <strong>Oh Snap!</strong> An Error Occurred </div></div>' ;
		}
		
	}
	
	// Delete Row
	if($_POST['delete'])
	{
		$id=$_POST['delete'];
		$j=0;
		$delete = "DELETE FROM departments WHERE dep_id=".$id;
		if ($conn->query($delete) === True)
		{
			$j++;
			$insert_err =  '<div class="alert alert-success">
							<div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-thumb-up"></i>
							</div>
								<strong>Well Done!</strong> Record successfully trashed </div></div>' ;
								header("Refresh:0");
		}
		else
		{
			$insert_err =  '<div class="alert alert-danger">
							<div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-block"></i>
							</div>
								<strong>Oh snap!</strong> Data could not be trashed '.mysql_error() .'</div></div>';
		}
	}
	
	//Update Record
	if($_POST['update_staff'])
	{
		$update_staff_fname = $_POST['staff_fname'];
		$update_staff_lname = $_POST['staff_lname'];
		$update_dep = $_POST['dep_name'];
		$update_center = $_POST['center'];
		$update_email = $_POST['staff_email'];
		
		$update_address = $_POST['staff_address'];
		
		$update_phone = $_POST['staff_phone'];
		
		$update_jb = $_POST['job_desc'];
		$id = $_POST['update_staff'];
		
		$update_sql = "UPDATE staff SET center_id ='".$update_center."', dep_id='".$update_dep."'
		, staff_fname='".$update_staff_fname."', staff_lname ='".$update_staff_lname."', staff_email='".$update_email."'
		, staff_phone='".$update_phone."',  staff_address='".$update_address."', job_description='".$update_jb."' WHERE staff_id=".$id;

		if ($conn->query($update_sql) === TRUE) {
			$insert_err =  '<div class="alert alert-success">
							<div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-block"></i>
							</div>
								<strong>Well Done!</strong> Record successfully Updated</div></div>';
								header("Refresh:0");
		
		} 
		else {
			$insert_err =  '<div class="alert alert-danger">
							<div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-block"></i>
							</div>
								<strong>Oh snap!</strong>  ' . $conn->error.'</div></div>';
		
			echo "Error updating record: " . $conn->error;
		}
	}
		
	if($_POST['insert_clinic'])
	{
		$i= 0;
		$c_name = $_POST['c_name'];
		$c_cname = $_POST['c_cname'];
		$phone = $_POST['phone'];
		$c_address = $_POST['c_address'];
	
		$insert_sql = "INSERT INTO clinics (clinic_name, clinic_contact_name, clinic_phone, clinic_address, date )
			VALUES ('$c_name','$c_cname','$phone','$c_address',now())";

			if ($conn->query($insert_sql) === TRUE) {
			$i++;
			$insert_err =  '<div class="alert alert-success">
                            <div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-thumb-up"></i>
							</div>
							<strong>Well Done!!</strong> Transaction Successful</div></div>' ;
							header("Refresh:0");
		} else {
			$insert_err =  '<div class="alert alert-danger">
							<div class="container">
							<div class="alert-icon">
								<i class="zmdi zmdi-block"></i>
							</div>
                            <strong>Oh Snap!</strong> An Error Occurred ' .$conn->error.'</div></div>' ;
		}
		
	}
?>



<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
<title>:: CyberLab - Welcome Admin ::</title>
<link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
<link rel="stylesheet" href="../../assets/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css"/>
<link rel="stylesheet" href="../../assets/plugins/morrisjs/morris.min.css" />

<!-- Bootstrap Select Css -->
<!--<link href="../../assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />-->

<!-- Custom Css -->

    <link rel="stylesheet" href="assets/css/authentication.css">
<link rel="stylesheet" href="../../assets/css/main.css">
<link rel="stylesheet" href="../../assets/css/color_skins.css">

<!-- JQuery DataTable Css -->
<link rel="stylesheet" href="../../assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css">
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

<script type="text/javascript" >
        $(function() {

            $(".btn-delete ").click(function() {
                var del_id = $(this).attr("id");
                var info = 'id=' + del_id;
                if (confirm("Sure you want to delete this post? This cannot be undone later.")) {
                    $.ajax({
                        type : "POST",
                        url : "view_dept.php", //URL to the delete php script
                        data : info,
                        success : function() {
                        }
                    });
                    $(this).parents(".record").animate("fast").animate({
                        opacity : "hide"
                    }, "slow");
                }
                return false;
            });
        });


</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</head>
<body class="theme-purple">
<?php
require_once('header.php');

?>
<!-- Main Content -->
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Dashboard
                <small>Welcome, <?php echo $staff_fname ." ".$staff_lname;?></small>
                </h2>
            </div>            
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">
                <div class="inlineblock text-center m-r-15 m-l-15 hidden-md-down">
                    <div class="sparkline" data-type="bar" data-width="97%" data-height="25px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#fff">3,2,6,5,9,8,7,9,5,1,3,5,7,4,6</div>
                    <small class="col-white">...</small>
                </div>
                <div class="inlineblock text-center m-r-15 m-l-15 hidden-md-down">
                    <div class="sparkline" data-type="bar" data-width="97%" data-height="25px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#fff">1,3,5,7,4,6,3,2,6,5,9,8,7,9,5</div>
                    <small class="col-white">...</small>
                </div>
                <button class="btn btn-white btn-icon btn-round hidden-sm-down float-right m-l-10" type="button">
                    <i class="zmdi zmdi-plus"></i>
                </button>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.php"><i class="zmdi zmdi-home"></i> CyberLab</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>New</strong> Clinic<small>Add a new Clinic to the record</small> </h2>
                        <!--<ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right slideUp">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>-->
                    </div>
					<div class="row clearfix">
						<div class="body ">
						
							<div class="row">
									
						</div>
						
						</div>
					</div>
					
				
					<!-- #END# Basic Examples --> 
        <?php echo $insert_err; ?>
		<!-- Exportable Table -->
                   <div class="body ">
				     <form class="form-group" id="taxDetails"  method="POST" action="view_clinic.php">
							<div class="row clearfix">
							
									<div class="col-sm-4">
										<div class="form-group">                                   
										  Clinic Name:  <input type="text" id="c_name" name="c_name"  class="form-control" />                             
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">   
										
										  Contact Name: <input type="text" id="c_cname" name="c_cname"  class="form-control" /> 
											</br></br></br>
											

											
										  
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">        
											Phone Number: <input type="phone" id="phone" name="phone"  class="form-control" /> 
										</div>
									</div>
							</div>
							<div class="row clearfix">
							
									<div class="col-sm-4">
										<div class="form-group">                                   
										     							
										Clinic Address:   <textarea name="c_address" rows="4" class="form-control no-resize" placeholder="Please Enter Address..."></textarea>
                                    					  
										</div>
									</div>
									<div class="col-sm-4" style="text-align:center;">
										<div class="form-group">                                   
										 <input type="hidden" name="insert_clinic" value="yes">
										 <button class="btn btn-raised btn-primary btn-round waves-effect" type="submit">Add </button>
								
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">                                   
											
											</div>
									</div>
									
									
							</div>
							
							<div class="row clearfix">
								<div class="col-sm-4">
								</div>
								<div class="col-sm-4" >
									</div>
								<div class="col-sm-4">
								</div>
								
							</div>
						</form>
					</div>
				</div>
		 
        <!-- #END# Exportable Table --> 
            </div>
        </div>
    </div>
	
	 <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Manage</strong> Clinics <small>Add, Edit and Trash Clinic Records</small> </h2>
                        <!--<ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right slideUp">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>-->
                    </div>
				
					
				
					<!-- #END# Basic Examples --> 
		<!-- Exportable Table -->
                   <div class="body ">
				   <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        
                            <thead>
                                <tr>
                                   <th >Clinic ID</th>
                                    <th>Clinic Name</th>
                                    <th>Contact Name</th>
                                    <th>Phone Number</th>   
									<th>Address</th>
									<th>Edit</th>   
									<th>Delete</th>
                                </tr>
                            </thead>
							<tfoot>
                                <tr>
                                 <th >Clinic ID</th>
                                    <th>Clinic Name</th>
                                    <th>Contact Name</th>
                                    <th>Phone Number</th>   
									<th>Address</th>
                                </tr>
                            </tfoot>
                            <tbody id="myTable">
								<?php echo $dept_table;?>
							</tbody>
						</table>
					</div>
				</div>
		 
        <!-- #END# Exportable Table --> 
            </div>
        </div>
    </div>
	</div>
	</div>
</section><!-- Jquery Core Js --> 
<script src="../../assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
<script src="../../assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 

<!-- Jquery DataTable Plugin Js --> 
<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../../assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js --> 
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
</body>
</html>