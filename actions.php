<?php
// Database connection file
include 'config.php';
//error_reporting(0);
if(isset($_POST['send']))
{
  $i= 0;

 $transno ="TRANS/".date('Ymd')."/".rand(10,90);
  $test_name = $_POST['tet'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $phonen = $_POST['phonen'];
  $age = $_POST['age'];
  $sex = $_POST['sex'];
  $clinic = $_POST['clinic'];
  $dia = $_POST['dia'];
 $depart = $_POST['depart'];
  $cost = $_POST['fee'];
  $paid = $_POST['paid'];
  $bal = $_POST['bal'];
  $trans_sql2 = "INSERT INTO trans(trans_no, fname, lname, phone, age,sex, clinic_id, dia, dated, timed)
                  VALUES ('$transno','$fname','$lname','$phonen', '$age','$sex','$clinic','$dia',now(),now())";
    $trans_sql = "INSERT INTO daliy_test(depart, t_name, cost, paid, balance,trans_no, dated, timed, Answered)
                  VALUES ('$depart','$test_name','$cost','$paid', '$bal','$transno',now(),now(),'0')";
    $conn->query($trans_sql);
    $conn->query($trans_sql2);

    exist();



}
?>

<?php
if(isset($_POST['display'])){

  $dept_table = '';
  echo "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">


      <thead>
          <tr>
            <th>Roll No</th>
             <th >Transaction No.</th>
              <th>Full Name</th>
              <th>Phone</th>
              <th>Clinic</th>
              <th>prognosis</th>
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
          <th>Phone</th>
          <th>Clinic</th>
          <th>prognosis</th>
          <th>Date</th>
          <th>Time</th>
          <th></th>
      </tr>

      </tfoot>
          <tbody id=\"myTable\">";

    $trans_data_sql = "SELECT * FROM trans where dated = CURDATE() order by timed DESC";
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
          echo '<tr id="comment_box" ><td>'.$r_id.'</td><td>'.$t_id.'</td><td>'.$fname.' '.$lname.'</td><td>'.$phone.'</td><td>'.  $clinic.'</td><td>'.$dia.'</td><td>'.$date.'</td><td>'.$time.'</td><td> <button onclick="location.href=\'test.php?id='.$r_id.'\'" class="btn btn-primary btn-sm">View</button></td></tr>';



        }
      }
      else
      {
        echo  '<tr id="comment_box"><td colspan="4" align="center"> <strong>  No Transaction!  </td></tr>';

      }
      echo "	</tbody>
      </table>";
 exit();
}

 ?>
 <?php
 if(isset($_POST['lab'])){

   $dept_table = '';
   
   echo "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" id=\"table-test\">


       <thead>
           <tr>
             <th data-field=\"date\" data-sortable=\"true\">Date</th>
			 <th>Time</th>
              <th >Transaction No.</th>
               <th>Full Name</th>
               <th>Prognosis</th>
               <th>Department</th>
               <th>Tests</th>
               <th>Response</th>
           </tr>
       </thead>

       <tfoot>
         <tr>
             <th>Date</th>
			 <th>Time</th>
              <th >Transaction No.</th>
               <th>Full Name</th>
               <th>Prognosis</th>
               <th>Department</th>
               <th>Tests</th>
               <th>Response</th>
           </tr>

       </tfoot>
           <tbody id=\"myTable\">";

     $trans_data_sql = "SELECT * FROM daliy_test INNER JOIN trans ON daliy_test.trans_no= trans.trans_no WHERE daliy_test.dated= CURDATE() order by dt_id DESC";
       $res_data = $conn->query($trans_data_sql);

       if ($res_data->num_rows > 0) {
       while($row = mysqli_fetch_array($res_data))
         {
         //here goes the data
           $dt_id = $row["dt_id"];
           $depart = $row["depart"];
           $tname = $row["t_name"];
           $trans_no = $row["trans_no"];
           $timed = $row["timed"];
		   $res11 = $row["Answered"];
          
	
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
			
        if($res11 == "1")
		{
			$ans = '<button class="btn btn-primary btn-sm " style="cursor: context-menu;" >Sent</button>';
		}
		else
		{
			$ans = '<button onclick="location.href=\'update.php?id='.$dt_id.'\'" class="btn btn-primary btn-sm" style="background-color:#FFD700;">Waiting</button>';
		}

           echo '<tr id="comment_box" ><td>'.$date.'</td><td>'.$timed.'</td><td>'.$trans_no.'</td><td>'.$fname.' '.$lname.'</td><td>'.$pro.'</td><td>'.  $dep_name.'</td><td>'.$tname.'</td><td> '.$ans.'</td></tr>';



         }
       }
       else
       {
         echo  '<tr id="comment_box"><td colspan="4" align="center"> <strong>  No Transaction!  </td></tr>';

       }
       echo "	</tbody>
       </table>";
  exit();
 }

  ?>
  <?php
  if(isset($_POST['dep'])){

    $dept_table = '';
    echo "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">


        <thead>
            <tr>
              <th>Dep. Id</th>
               <th >Department Name</th>
                <th>Edit</th>
                <th>Trash</th>

            </tr>
        </thead>

        <tfoot>
        <tr>
        <th>Dep. Id</th>
         <th >Department Name</th>
          <th>Edit</th>
          <th>Trash</th>

        </tr>

        </tfoot>
            <tbody id=\"myTable\">";

      $trans_data_sql = "SELECT * FROM departments order by dep_id DESC ";
        $res_data = $conn->query($trans_data_sql);

        if ($res_data->num_rows > 0) {
        while($row = mysqli_fetch_array($res_data))
          {
          //here goes the data
            $d_id = $row["dep_id"];
            $d_name = $row["dep_name"];
            	echo '<tr id="comment_box" ><td>'.$d_id.'</td><td>'.$d_name.'</td><td> <button onclick="location.href=\'test.php?id='.$d_id.'\'" class="btn btn-primary btn-sm">Edit</button></td><td> <button onclick="location.href=\'test.php?id='.$d_id.'\'" class="btn btn-primary btn-sm"><i class="material-icons">delete</i> </button></td></tr>';



          }
        }
        else
        {
          echo  '<tr id="comment_box"><td colspan="4" align="center"> <strong>  No Transaction!  </td></tr>';

        }
        echo "	</tbody>
        </table>";
   exit();
  }
  
  if(isset($_POST['send']))
{
			$username = $_POST['user'];
			$password = $_POST['pass'];
			
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
				}
				$log_sql = "INSERT INTO login_log (staff_id, last_login_date)
				VALUES ('".$_SESSION["staff_id"]."', now())";

				$conn->query($log_sql);
				
				header('Location: front-transact.php');
				
			} 
			
	

}

if(isset($_POST['all'])){

   $dept_table = '';
   
   echo "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" id=\"table-test\">


       <thead>
           <tr>
             <th data-field=\"date\" data-sortable=\"true\">Date</th>
			 <th>Time</th>
              <th >Transaction No.</th>
               <th>Full Name</th>
               <th>Prognosis</th>
               <th>Department</th>
               <th>Tests</th>
               <th>Cost</th>
               <th>Paid</th>
               <th>Balance</th>
           </tr>
       </thead>

       <tfoot>
         <tr>
            <th data-field=\"date\" data-sortable=\"true\">Date</th>
			 <th>Time</th>
              <th >Transaction No.</th>
               <th>Full Name</th>
               <th>Prognosis</th>
               <th>Department</th>
               <th>Tests</th>
               <th>Cost</th>
               <th>Paid</th>
               <th>Balance</th>

           </tr>

       </tfoot>
           <tbody id=\"myTable\">";

     $trans_data_sql = "SELECT * FROM daliy_test  INNER JOIN trans ON daliy_test.trans_no= trans.trans_no order by dt_id DESC";
       $res_data = $conn->query($trans_data_sql);

       if ($res_data->num_rows > 0) {
       while($row = mysqli_fetch_array($res_data))
         {
         //here goes the data
           $dt_id = $row["dt_id"];
           $depart = $row["depart"];
           $tname = $row["t_name"];
           $trans_no = $row["trans_no"];
           $timed = $row["timed"];
		   $res11 = $row["Answered"];
		   $cost = $row["cost"];
		   $paid = $row["paid"];
		   $bal = $row["balance"];
          
	
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
			
        if($res11 == "1")
		{
			$ans = '<button class="btn btn-primary btn-sm " >Sent</button>';
		}
		else
		{
			$ans = '<button onclick="location.href=\'update.php?id='.$dt_id.'\'" class="btn btn-primary btn-sm" style="background-color:#FFD700;">Waiting</button>';
		}

           echo '<tr id="comment_box" ><td>'.$date.'</td><td>'.$timed.'</td><td>'.$trans_no.'</td><td>'.$fname.' '.$lname.'</td><td>'.$pro.'</td><td>'.  $dep_name.'</td><td>'.$tname.'</td><td> '.$cost.'</td><td> '.$paid.'</td><td> '.$bal.'</td></tr>';



         }
       }
       else
       {
         echo  '<tr id="comment_box"><td colspan="4" align="center"> <strong>  No Transaction!  </td></tr>';

       }
       echo "	</tbody>
       </table>";
  exit();
 }
   ?>
