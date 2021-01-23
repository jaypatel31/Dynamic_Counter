<?php
	include "pdo.php";
	
	$value = $_POST['counter_value'];
	$id =1;
	try{
		$sql = "UPDATE main_table SET counter_value=:value WHERE counter_id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			":value"=>$value,
			":id"=>$id
		));
		echo json_encode(array("statusCode" => 400));
	}catch(PDOException $e){
		echo json_encode(array("statusCode" => 401));
	}
?>