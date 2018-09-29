<?php

	// Session authenticaton
	session_start();
	error_reporting(0);
	if(empty($_SESSION['staff_id']) && empty($_SESSION['staff_username']) && empty($_SESSION['staff_password']) && empty($_SESSION['role'])) {
	   header("Location: index.php");
	}

	// Database connection file
	include 'config.php';

	/* Fetch User Record
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
	*/

	//Fetch Transaction Record -

		$dept_table = '';
		
			$row_id = $_GET['id'];
			$trans_data_sql = "SELECT * FROM trans WHERE id = $row_id";
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
						$dept_table .= '<table  width ="330px">
						<tr>
						<td align="center" colspan="2">
						<img src="logo.png" width="50%" > <br />

						Lab Bus/Stop, Isheri Round-About<br/> Idimu. Lagos
						</td>
						</tr>
						<tr>
						<td colspan="2">
						<strong>Phone: </strong> 08148688808 <br />
						<strong>Email: </strong> info@ponsmedicaldianostics.com <br />
						<strong>Website: </strong> www.ponsmedicaldianostics.com
						</td>
						</tr>
						<tr>
						<td align="center" colspan="2">
						Enquiries & Complaints<br />
						08030443980, 08034542000 <br />

						<STRONG>PAYMENT RECEIPT</STRONG><br />

						'.date("d/m/Y").'
						 '.date("h:i:sa").' 
						<h2>'.date("dmY").''.rand(10,100).'<br/>'.$fname.' '.$lname.'</h2>

						</td>
						</tr>
						<tr>
						<td colspan="2" >
						Payment Date: '.$date.'

						</td>

						</tr>
						</table  >
						<table width ="330px" border="1">
						<tr>
						<td>
						<strong>Test Name</strong>
						</td>
						<td> <strong>Cost</strong>
						</td>
						<td> <strong>Paid</strong>
						</td>
						</tr>';

			  $trans_data_sql1 = "SELECT * FROM daliy_test where trans_no='".$t_id."' order by timed DESC";
              $res_data1 = $conn->query($trans_data_sql1);
				
				$trans_data_sql12 = "SELECT sum(balance) FROM daliy_test where trans_no='".$t_id."' order by timed DESC";
              $res_data12 = $conn->query($trans_data_sql12);
			  while($row3 = mysqli_fetch_array($res_data12))
                {
					$total_bal = $row3['sum(balance)'];
				}
				
				$trans_data_sql12 = "SELECT sum(paid) FROM daliy_test where trans_no='".$t_id."' order by timed DESC";
              $res_data12 = $conn->query($trans_data_sql12);
			  while($row3 = mysqli_fetch_array($res_data12))
                {
					$total_paid = $row3['sum(paid)'];
				}
				$trans_data_sql13 = "SELECT sum(cost) FROM daliy_test where trans_no='".$t_id."' order by timed DESC";
              $res_data13 = $conn->query($trans_data_sql13);
			  while($row4 = mysqli_fetch_array($res_data13))
                {
					$total_cost = $row4['sum(cost)'];
				}
				
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
				  $sum_bal = $row['SUM(balance)'];



                  // Displaying each rows
					$dept_table .= '
<tr>
<td>
'.$tname.'
</td>
<td> '.$cost.'
</td>
<td> '.$paid.'
</td>
';
               }
						

						// Displaying each rows
	$dept_table .= '
	<tr  align="center">

<td colspan="3"> <strong>Total Cost: '.$total_cost.'</strong> <br />
<strong>Total Amount Paid:'.$total_paid.'</strong> <br />
<strong>Total Outstanding Balance: '.$total_bal.'</strong> <br /> <hr /> Cashier
</td>
</tr>
<tr  align="center">

<td colspan="3"> <strong> '.$_SESSION["staff_name"] .'</strong> <br /> <hr /> Cashier
</td>
</tr>
<tr align="center">

<td colspan="2"> <strong>Thank you for your patronage</strong>
</td>
</tr>
</table>';



					}
				}
				else
				{
					$dept_table .= '<tr><td colspan="4" align="center"> <strong>  No Transaction!  </td></tr>';

				}


?>
<html>
<head>
<title>Receipt</title>
<script src="jquery.min.js" ></script>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<script>
n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
</script>
</head>
	<body >
	
	<div id="printableArea"><br>
		
		<?php echo $dept_table;?>
	</div>
	<center>
	<table style="font-family:Times New Roman ; font-size:22.5px" width="80%" border="0"  >
	<tr>
				<td  align="center"><br ><br >	</td>
			</tr>
		<tr>
				<td  align="center"><input type="button" onclick="printDiv('printableArea')" class="btn btn-primary btn-sm" value="print " />
								</td>
			</tr>
			<tr>
				<td  align="center"><br><button onclick="location.href='view_transact.php'" class="btn btn-primary btn-sm">Back</button></td>
			</tr>
			</table>
			</center>
			
	</body>
</html>