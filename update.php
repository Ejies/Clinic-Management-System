<?php
include 'config.php';
$error ="";
// insert New test for an Exsisting Patient
if(isset($_GET["id"])){
  //$transno = $_session['trans'];
  $test_id = $_GET['id'];
  
  $update_sql = "UPDATE daliy_test SET answered = 1 WHERE dt_id='".$test_id."'";
  if ($conn->query($update_sql) === TRUE) {
		header("Location: lab_view.php");
  }
  else
  {
	  echo "Something Went Wrong" .$conn->error; 
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