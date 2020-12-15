<?php
$a = 5;
$b = '05';
var_dump($a == $b);                             // Почему true? Потому что приведение типов к числовому
var_dump((int)'012345');                        // Почему 12345? Потому что целое число не может начинаться с нуля
var_dump((float)123.0 === (int)123.0); // Почему false? Потому что строгое сравнение без приведения типов
var_dump((int)0 === (int)'hello, world'); // Почему true? Потому что 0 === 0  

$title = 'myproject_page';
$date = 2020;
$header = 'First header';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
</head>
<body>
	<h1><?php echo $header; ?></h1>
	<br>
	<p><?php echo $date; ?></p>
</body>
</html>