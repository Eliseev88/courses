<?php
  function canUpload($file){
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return 'Файл слишком большой.';
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
	
	return true;
  }
  
  function makeUpload($file){	
	// формируем уникальное имя картинки: случайное число и name
	$name = mt_rand(0, 10000) . $file['name'];
	copy($file['tmp_name'], 'img/' . $name);
  }

  function getGallery() {
        //Выбираем все содержимое папки img, и записываем в массив $files
        $files = scandir("img/"); 
        $gallery_files = array();
        foreach ($files as $key => $value) { //Проходим по массиму
            //Проверяем файл или нет, если файл, то:
            if (filetype("img/" . $value) == "file") { 
                $gallery_files[] = $value;  //Записываем в массив
            }
        }
        return $gallery_files; //Возвращаем массив
  }