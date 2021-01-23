<?php

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Counter | Live</title>
	<style>
	body{
		background-color:#f1f1f1;
	}
		h1{
			text-align:center;
			font-size:50px;
			color: #444;
		  text-shadow: 
			1px 0px 1px #ccc, 0px 1px 1px #eee, 
			2px 1px 1px #ccc, 1px 2px 1px #eee,
			3px 2px 1px #ccc, 2px 3px 1px #eee,
			4px 3px 1px #ccc, 3px 4px 1px #eee,
			5px 4px 1px #ccc, 4px 5px 1px #eee,
			6px 5px 1px #ccc, 5px 6px 1px #eee,
			7px 6px 1px #ccc;

		}
		button{
			padding:12px;
			font-size: 20px;
			border:none;
			outline:none;
			border-radius:15px;
			background-color:#f1f1f1;
			transition:0.5s ease;
			margin-bottom:12px;
		}
		button:hover{
			cursor:pointer;
			color:#f1f1f1;
		}
		button#end{
			margin-left:20px;
			box-shadow: 2px 6px 8px red;
		}
		button#start{
			box-shadow: 2px 6px 8px green;
		}
		button#start:hover{
			background-color:green;
		}
		button#end:hover{
			background-color:red;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
	</script>
</head>
<body>
	<br/>
	<button id="start" onclick="start_counter()">Start Counter</button>
	
	<button id="end" onclick="stop_counter()">Stop Counter</button>
	<br/>
	<br/>
	<!--<label> Start Time:
	<input type="time" name="st_time" >-->
	<!--</label>
	<label> End Time:
	<input type="time" name="end_time" >
	</label>-->
	<br/>
	<h1 id="count"></h1>
	
</body>
<script>
let intial_hr;
let final_hr;
let intial_mili;
let final_mili;
let difference;
let interval;
let push_db_str;
function resent(){
		$.get("get_time.php",function(data, status){
			console.log("Status: " + status,data);
			 intial_hr = new Date();
			 final_hr = new Date(intial_hr.getTime()+3600000);
			 intial_mili = intial_hr.getTime();
			 final_mili = final_hr.getTime();
			 difference = 0;
			difference = final_mili-intial_mili;
			document.getElementById("count").innerHTML = msToTime(difference);
			pushIntoDb(msToTime(difference))
		});
	}
$("document").ready(resent());
	
	
	function msToTime(duration) {
		let milliseconds = parseInt((duration % 1000) / 100),
		 seconds = Math.floor((duration / 1000) % 60),
		 minutes = Math.floor((duration / (1000 * 60)) % 60),
		 hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

		  hours = (hours < 10) ? "0" + hours : hours;
		  minutes = (minutes < 10) ? "0" + minutes : minutes;
		  seconds = (seconds < 10) ? "0" + seconds : seconds;

		return hours + ":" + minutes + ":" + seconds;
	}
	
	
	
	function counter(){
		intial_mili = intial_mili+1000;
		difference = final_mili-intial_mili;
		push_db_str = msToTime(difference);
		document.getElementById("count").innerHTML = push_db_str;
		pushIntoDb(push_db_str);
	}
	
	function start_counter(){
		resent();
		interval = setInterval(counter, 1000);
	}
	function stop_counter(){
		clearInterval(interval);
	}
	
	function pushIntoDb(push_db_str){
		$.post("set_time.php",{counter_value: push_db_str},
		  function(data, status){
			//console.log("Data: " + data + "\nStatus: " + status);
		 });
	}
	
</script>
</html>
