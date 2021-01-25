<?php
	include "pdo.php";
	$id=1;
	$sql = "SELECT * FROM time_set WHERE id=:id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		":id"=>$id
	));
	while($result = $stmt->fetchAll(PDO::FETCH_ASSOC)){
		echo json_encode(array("start_time" => $result[0]['start_time'],'end_time'=>$result[0]['end_time']));
	}
?>