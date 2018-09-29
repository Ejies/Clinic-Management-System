<?php
	include 'config.php';
	include 'upload_config.php';
	if($_POST["send"])
	{
		echo "yeah";
		
  
     $trans_data_sql = "SELECT * FROM daliy_test INNER JOIN trans ON daliy_test.trans_no= trans.trans_no ";
       $res_data = $conn->query($trans_data_sql);

       if ($res_data->num_rows > 0) {
       while($row = mysqli_fetch_array($res_data))
         {
         //here goes the data
           $dt_id = $row["dt_id"];
           $depart = $row["depart"];
           $tname = $row["t_name"];
           $cost = $row["cost"];
           $paid = $row["paid"];
           $bal = $row["balance"];
           $trans_no = $row["trans_no"];
           $timed = $row["timed"];
		   $res11 = $row["Answered"];
          
	
				$id = $row["id"];
				$fname = $row["fname"];
				$lname = $row["lname"];
				$phone = $row["phone"];
				$age = $row["age"];
				$sex = $row["sex"];
				$clinic_id = $row["clinic_id"];
				
				$date = $row["dated"];
				$time = $row["timed"];
				$pro = $row["dia"];
			
			$trans_sql2 = "INSERT INTO trans( id, trans_no, fname, lname, phone, age,sex, clinic_id, dia, dated, timed)
                  VALUES ('$id','$transno','$fname','$lname','$phonen', '$age','$sex','$clinic_id','$dia',now(),now())";
			$trans_sql = "INSERT INTO daliy_test(dt_id, depart, t_name, cost, paid, balance,trans_no, dated, timed, Answered)
                  VALUES ('$dt_id','$depart','$test_name','$cost','$paid', '$bal','$transno',now(),now(),'0')";
			
			$conn2->query($trans_sql);
			$conn2->query($trans_sql2);

		
			 echo  '<strong>  fetched!  </strong>';
         }
       }
       else
       {
         echo  '<strong>  No Transaction!  </strong>';

       }
     
  
	}
?><html>
<head>
</head>
<body>

<form method="post" action="upload.php">
<button type="submit" name="send" value="yes"> Upload </button>
</form>
</body>
</html>