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
		button#reset{
			margin-left:20px;
			box-shadow: 2px 6px 8px red;
		}
		button#start{
			box-shadow: 2px 6px 8px green;
		}
		button#start:hover{
			background-color:green;
		}
		button#reset:hover{
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
	<h2 id="user_info"></h2>
	<form>
	<label> Start Time:
	<input type="time" id="start_time" name="st_time" onchange="check_st('start_time')">
	</label>
	<label> End Time:
	<input type="time" id="end_time" name="end_time" disabled onchange="check_end('end_time')">
	</label>
	<br/>
	<br/>
	<button id="start" type="button">Submit</button>
	</form>
	<button id="reset" type="button">Reset</button>
	<br/>
	<h1 id="count"></h1>
	
</body>
<script>
$('#reset').hide();
let intial_hr;
let final_hr;
let intial_mili;
let final_mili;
let difference;
let interval;
let check_interval;
let push_db_str;
let set_time_mili =0;
let end_time_mili =0;
let current_time;
let start_value;
let end_time;
let server_start_time;
let server_end_time;
function time_checker(){
	$.get("get_counter_time.php",function(data, status){
		data =JSON.parse(data);
		server_start_time = data.start_time;
		server_end_time = data.end_time;
		resent(server_start_time,server_end_time);
	});
}

function current_time_getter(){
	$.get("get_time.php",function(data, status){
			current_time = new Date(data);
	});
}
current_time_getter();
function resent(server_start_time,server_end_time){
			intial_hr = new Date(current_time.toLocaleDateString()+" "+server_start_time);
			final_hr = new Date(current_time.toLocaleDateString()+" "+server_end_time);
			intial_mili = intial_hr.getTime();
			final_mili = final_hr.getTime();
			difference = 0;
			difference = final_mili-intial_mili;
			document.getElementById("count").innerHTML = msToTime(difference);
			pushIntoDb(msToTime(difference))
			check_interval = setInterval(check_counter,1000);
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
		if(difference==0){
			clearInterval(interval);
			reset();
		}
	}
	
	$('#start').click(function(){
		check_st('start_time');
		check_end('end_time');
		if(set_time_mili!=0 && end_time_mili!=0){
			pushCounterTime(start_value,end_value);
			
		}
	});
	$('#reset').click(function(){
		reset();
	});
	function reset(){
		clearInterval(check_interval);
		clearInterval(interval);
		$('form').show();
		$('#start').show();
		$('#reset').hide();
		intial_hr = final_hr = intial_mili = final_mili =0;
		$("#count").text("");
		$("#user_info").text("");
	}
	function check_counter(){
		current_time_getter();
		if(current_time.getTime()>=intial_mili){
			intial_mili = current_time.getTime()+1000;
			difference = final_mili-intial_mili;
			document.getElementById("count").innerHTML = msToTime(difference);
			interval = setInterval(counter, 1000);
			clearInterval(check_interval);
			
		}
		console.log('check');
	}
	
	
	function pushIntoDb(push_db_str){
		$.post("set_time.php",{counter_value: push_db_str},
		  function(data, status){
			//console.log("Data: " + data + "\nStatus: " + status);
		 });
	}
	
	function check_st(id){
			current_time_getter();
			start_value = $('#'+id).val();
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
		
	}
	
	function check_end(id){
		end_value = $('#'+id).val();
		end_time_mili = new Date(current_time.toLocaleDateString()+" "+end_value).getTime();
		if(set_time_mili<end_time_mili){
			
		}
		else{
			alert("Please Choose Starting time Greater than Set Time");
			
			$("#end_time").val(new Date(set_time_mili+60000).toTimeString().slice(0,5));
			end_time_mili=0;
			end_value="";
			return false;
		}
	}
	
	function pushCounterTime(start_value,end_value){
		$.post("set_counter.php",{st_val: start_value,end_val:end_value},
		  function(data, status){
			  console.log(data);
			  data =JSON.parse(data);
			if(data.statusCode==400){
				alert("Succesfully Set The Duration");
				$("#user_info").text("Timer Will Start From "+start_value+" To "+end_value);
				$('form').hide();
				$('#start').hide();
				$('#reset').show();
				time_checker();
			}
			else{
				alert("Please Try Again :)")
			}
		 });
	}
</script>
</html>
