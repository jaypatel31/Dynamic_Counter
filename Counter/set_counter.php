<?php
	include "pdo.php";
	
	$st_time = $_POST['st_val'];
	$end_time = $_POST['end_val'];
	$id=1;
	try{
		$sql = "UPDATE time_set SET start_time=:st_time, end_time=:end_time WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			":st_time"=>$st_time,
			":end_time"=>$end_time,
			":id"=>$id
		));
		echo json_encode(array("statusCode" => 400));
	}catch(PDOException $e){
		echo json_encode(array("statusCode" => 401));
	}
?>