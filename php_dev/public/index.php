<?php
  include_once('../engine/functions.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Загрузка изображений на сервер</title>
  </head>
  <body>
    <?php
    	include '../templates/upload.html'; // подключаем форму загрузки изображения
	    // если была произведена отправка формы
	    if(isset($_FILES['file'])) {
	      // проверяем, можно ли загружать изображение
	      $check = canUpload($_FILES['file']);
	    
	      if($check === true){
	        // загружаем изображение на сервер
	        makeUpload($_FILES['file']);
	        echo "<strong>Файл успешно загружен!</strong>";
	      } else echo "<strong>$check</strong>"; // выводим сообщение об ошибке    
	    }

	    echo '<hr>';

	    // получаем массив с картинками
	    $gallery = getGallery();

	    // выводим картинки на экран
	   	foreach ($gallery as $key => $value) { ?>
			<a href="/img/<?=$value;?>" target="_blank" style="display: inline;">
				<img src="/img/<?=$value;?>" alt="#" width="200" height="150">
			</a>
	   	<?php } ?> 
  </body>
</html>
