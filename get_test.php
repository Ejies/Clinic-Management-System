<?php

	include 'config.php';
$country_id = $conn->real_escape_string($_POST['country_id']);
if($country_id!='')
{
$states_result = $conn->query('select * from test where dep_id="'.$country_id.'"');
if ($states_result->num_rows > 0) {

	$options = "<option value=''>Select Test</option>";
	while($row = $states_result->fetch_assoc()) {
	$options .= "<option value='".$row['cost']."'>".$row['test_name']."</option>";
	}
	echo $options;
}
else
{
	echo "<option value=''>".$country_id."</option>";
}
}?>
