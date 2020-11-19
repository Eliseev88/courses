<? 
// 1 exercise
	$a = rand(-15, 15);
	$b = rand(-15, 15);

	if($a >= 0 && $b >= 0) echo($a - $b);
	else if($a < 0 && $b < 0) echo($a * $b);
	else echo($a + $b);

	echo '<hr>';

// 2 exercise
	$c = rand(0, 15);

	switch ($c) {
		case 0:
			echo ' 0 <br>';
		case 1:
			echo '1 <br>';
		case 2:
			echo '2 <br>';
		case 3:
			echo '3 <br>';
		case 4:
			echo '4 <br>';	
		case 5:
			echo '5 <br>';
		case 6:
			echo '6 <br>';
		case 7:
			echo '7 <br>';
		case 8:
			echo '8 <br>';
		case 9:
			echo '9 <br>';	
		case 10:
			echo '10 <br>';	
		case 11:
			echo '11 <br>';
		case 12:
			echo '12 <br>';
		case 13:
			echo '13 <br>';
		case 14:
			echo '14 <br>';	
		case 15:
			echo '15 <br>';
			break;	
		default:
			echo 'No number';
			break;
	}

	// 3 exercise
		echo '<hr>';

		function sum($firstNum, $secondNum){
			return $firstNum + $secondNum;
		};

		function sub($firstNum, $secondNum){
			return $firstNum - $secondNum;
		};

		function mult($firstNum, $secondNum){
			return $firstNum * $secondNum;
		};

		function div($firstNum, $secondNum){
			return $firstNum / $secondNum;
		};

		echo(sum(10, 10).'<br>');
		echo(sub(10, 10).'<br>');
		echo(mult(10, 10).'<br>');
		echo(div(10, 10).'<br>');

	// 4 exercise
		echo '<hr>';

		function mathOperation($arg1, $arg2, $operation){
			switch ($operation) {
				case 'sum':
					return sum($arg1, $arg2);
				case 'sub':
					return sub($arg1, $arg2);
				case 'mult':
					return mult($arg1, $arg2);
				case 'div':
					return div($arg1, $arg2);
				default:
					# code...
					break;
			};
		};

		echo(mathOperation(100, 11, 'sum'));
		echo '<hr>';
?>

<!-- 5 exercise -->
<footer><?php echo date("Y");?></footer>