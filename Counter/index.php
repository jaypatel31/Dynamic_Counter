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
	<!--<button id="start" onclick="start_counter()">Start Counter</button>
	
	<button id="end" onclick="stop_counter()">Stop Counter</button>
	<br/>
	<br/>-->
	<form>
	<label> Start Time:
	<input type="time" id="start_time" name="st_time" onchange="check_st('start_time')">
	</label>
	<label> End Time:
	<input type="time" id="end_time" name="end_time" disabled onchange="check_end(event)">
	</label>
	<br/>
	<br/>
	<button id="start" type="button">Submit</button>
	<form>
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
let set_time_mili =0;
let end_time_mili =0;
let current_time;
let start_value;
let end_time;
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
	
	$('#start').click(function(){
		check_st('start_time');
		if(set_time_mili!=0 && end_time_mili!=0){
			pushCounterTime(start_value,end_value);
		}
	});
	
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
	
	function check_st(id){
		 start_value = $("#"+id).val();
		$.get("get_time.php",function(data, status){
			current_time = new Date(data);
			set_time_mili = new Date(current_time.toLocaleDateString()+" "+start_value).getTime();
			let current_time_mili = current_time.getTime();
			if(current_time_mili<set_time_mili){
				$("#end_time").attr("min",start_value);
				$("#end_time").removeAttr("disabled");
				$("#end_time").attr("value", new Date(set_time_mili+60000).toTimeString().slice(0,5));
			}
			else{
				alert("Please Choose Starting time Greater than "+ current_time.toLocaleTimeString()+" and Lesser than 12:00:00 AM");
				$("#start_time").val("");
				$("#end_time").attr("value","");
				$("#end_time").attr("disabled","disable");
				set_time_mili =0;
				start_value="";
			}
		});
	}
	
	function check_end(event){
		end_value = event.target.value;
		end_time_mili = new Date(current_time.toLocaleDateString()+" "+end_value).getTime();
		if(set_time_mili<end_time_mili){
			
		}
		else{
			alert("Please Choose Starting time Greater than Set Time");
			event.preventDefault();
			$("#end_time").val(new Date(set_time_mili+60000).toTimeString().slice(0,5));
			end_time_mili=0;
			end_value="";
		}
	}
	
	function pushCounterTime(start_value,end_value){
		//To be Updated
	}
</script>
</html>
