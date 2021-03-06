
<html>
<head>
	<title>Math App</title>
	<script src="jquery/jquery-1.10.2.min.js"></script>
<style>
		table, th, td{
			border: 1px solid black;
			
			border-collapse: collapse;
		}
		td{
			vertical-align: top;
			padding-bottom: 15px;
		}
		.questions {
			text-align: right;
			display: inline-block;
			margin-right: 29px;
		}
		#exam {
			position: relative;
		}
		.answers {
			width: 20px;
		}
		.settings, #exam {
			border: 1px solid black;
			padding: 10px;
			border-radius: 5px;
		}
		.settings-container {
			display: inline-block;
		}
		#time {
			text-align: center;
			font-size: 16px;
		}
		#score {
			text-align: center;
			font-size: 40px;
			padding-bottom: 5px;
			width: 417px;
		}
		#time-left, #total-score {
			font-size: 150px;
		}
		#app_start, #preview{
			width: 247px;
			height: 47px;
			margin-bottom: 5px;
			font-size: 38px;
		}
	</style>
</head>
<body>
	<h1>Multiplication Exam</h1> 
	<hr>
		<div class="settings-container">
			<div id="level" class="settings">
				<input type="radio" name="time_limit" value="240" />4 Minutes<br>
				<input type="radio" name="time_limit" value="225" />3 Minute 45 Seconds<br>
				<input type="radio" name="time_limit" value="210" />3 Minute 30 Seconds<br>
				<input type="radio" name="time_limit" value="195" />3 Minute 15 Seconds<br>
				<input type="radio" name="time_limit" value="180" />3 Minutes<br>
				<input type="radio" name="time_limit" value="165" />2 Minute 45 Seconds<br>	
				<input type="radio" name="time_limit" value="150" />2 Minute 30 Seconds<br>
				<input type="radio" name="time_limit" value="135" />2 Minute 15 Seconds<br>
				<input type="radio" name="time_limit" value="120" />2 Minutes<br>
				<input type="radio" name="time_limit" value="105" />1 Minute 45 Seconds<br> 
				<input type="radio" name="time_limit" value="90" />1 Minute 30 Seconds<br> 
				<input type="radio" name="time_limit" value="75" />1 Minute 15 Seconds<br> 			
				<input type="radio" name="time_limit" value="60" />1 Minute<br>
			</div>
		</div>
		<div class="settings-container">
			<button id="app_start">Start</button>
			<div id="time" class="settings">
				Time left:<br>
				<span id="time-left">&nbsp;</span><br>
				seconds<br>
			</div>
		</div>
		<div class="settings-container">
			<div id="score" class="settings">
				Score:<br>
				<span id="total-score">&nbsp;</span><br>
				<span id="comment">&nbsp;</span><br>
			</div>
		</div>
		<div class="settings-container">
			<button id="preview">Preview</button>
		</div>
		<br><br>
		<div id="exam"></div>
		
	<script>
		// localStorage.removeItem('level');
		if(typeof(localStorage.level) === "undefined") localStorage.level = 240;
		var level = parseInt(localStorage.level);
		var timer;
		var score = 0;
		
		$('input[name="time_limit"]').each(function( index ) {
			var level_display = parseInt($(this).val());
			if(level_display < level ) $(this).prop('disabled', true);
		});
		
		function shuffle(o){
			for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
			return o;
		}
		
		function submit() {
			clearInterval(timer);
			var ctr = 0;
			$('.answers').prop('readonly', true);
			$('.answers').each(function( index ) {
				if($(this).val() == $(this).data('answer'))
					score = score + 1;
				else 
					$(this).css('background-color', '#D89595');
			});
			if(score == 81) {
				localStorage.level = parseInt(localStorage.level) - 15;
				$('#comment').html('Level Up!!!');
				$('input[value="' + localStorage.level + '"]').prop('disabled', false);
			}
			$('#total-score').html(score + ' / 81');
			score = 0;
			$('#app_start').text('Start');
			$('#preview').show();
		}
		
		$('#preview').click(function(e) {
			if($(this).text() == 'Preview') {
				var test = '';
				for (var i = 0; i <= 80; i++) {
						test = test + myPreview[i];
						if((i+1) % 27 == 0) {
							test = test + '<br><br>';
						}
				}
				$(this).text('Close')
				$('#exam').html(test);
			} else {
				$(this).text('Preview');
				$('#exam').html('');
			}
		});	
		
		$('#app_start').click(function(e) {
			if($(this).text() == 'Start') {
				var time_left = parseInt($('input[name="time_limit"]:checked').val());
				if(isNaN(time_left)) return false;
				$('#preview').hide();
				shuffle(myArray);
				var test = '';
				for (var i = 0; i <= 80; i++) {
						test = test + myArray[i];
						if((i+1) % 27 == 0) {
							test = test + '<br><br>';
						}
				}
				$('#exam').html(test);
				$('#total-score').html('&nbsp;');
				$(this).text('Submit');
				$('#time-left').html(time_left);
				timer = setInterval(function() {
					time_left--;
					if(time_left == 0) {
						submit();
					}
					$('#time-left').html(time_left);
				  }, 1000);
			} else {
				submit();
			}
		});
		var temp = '';
		var myArray = [], myPreview = [], x=0;
		for (var i = 0; i <= 8; i++) {
			for (var j = 0; j <= 8; j++) {
				temp = (i+1)*(j+1);
				myPreview.push('<div class="questions">' + (i+1) + '<br>x ' + (j+1) + '<br><input class="answers" data-answer="' + ((i+1)*(j+1)) + '" type="text" value="'+temp+'"/></div>');
				myArray.push('<div class="questions">' + (i+1) + '<br>x ' + (j+1) + '<br><input class="answers" data-answer="' + ((i+1)*(j+1)) + '" type="text" /></div>');
			}
		}

	</script>
</body>
</html>