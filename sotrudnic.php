<!doctype html>
<html lang="ru">
<head>
  <title>Админ-панель</title>
   <link rel="stylesheet" type="text/css" media="screen" href="css/style1.css">
   <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
   <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
   
  
</head>
<body>
  
		<div id="navbar">
			<div class="menu">
				<ul class="nav">
				  <li><a class="link" href="index.php">Объекты</a></li>
					<li><a class="link" href="client.php">Клиенты</a></li>
					<li><a class="link" href="sotrudnic.php">Сотрудники</a></li>
					<li><a class="link" href="dogovor.php">Договоры</a></li>
				</ul>
			</div>
		</div>
		

  <?php
	$link = new mysqli('localhost', 'root', 'root', 'nedv');

   //Если переменная Name передана
    if (isset($_POST["FAMSOTR"])) {
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_id'])) {
          $sql = $link->query("UPDATE `sotrudnic` SET `IDSOTR` = '{$_POST['IDSOTR']}', `FAMSOTR` = '{$_POST['FAMSOTR']}',`NAMESOTR` = '{$_POST['NAMESOTR']}',`DATASOTR` = '{$_POST['DATASOTR']}',`ADSOTR` = '{$_POST['ADSOTR']}',`DOLSOTR` = '{$_POST['DOLSOTR']}' WHERE `IDSOTR`={$_GET['red_id']}");
      } else {
          //Иначе вставляем данные, подставляя их в запрос
          $sql = $link->query("INSERT INTO `sotrudnic` (`IDSOTR`, `FAMSOTR`, `NAMESOTR`, `DATASOTR`, `ADSOTR`, `DOLSOTR`) VALUES ('{$_POST['IDSOTR']}', '{$_POST['FAMSOTR']}', '{$_POST['NAMESOTR']}', '{$_POST['DATASOTR']}', '{$_POST['ADSOTR']}', '{$_POST['DOLSOTR']}')");
      }

      //Если вставка прошла успешно
      if ($sql) {
        echo '<p>Успешно!</p>';
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }

    if (isset($_GET['del_id'])) { //проверяем, есть ли переменная
      //удаляем строку из таблицы
      $sql = $link->query("DELETE FROM `sotrudnic` WHERE `IDSOTR` = {$_GET['del_id']}");
      if ($sql) {
        echo "<p>Сотрудник удален.</p>";
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }
  

    //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red_id'])) {
      $sql = $link->query("SELECT `IDSOTR`, `FAMSOTR`, `NAMESOTR`, `DATASOTR`, `ADSOTR`, `DOLSOTR` FROM `sotrudnic` WHERE `IDSOTR`={$_GET['red_id']}");
      $product = mysqli_fetch_array($sql);
    }
  ?>

  <form action="" method="post">
    <table class="table table-striped table-condensed table-bordered table-rounded">
  <tr>
        <td>Идентификатор:</td>
        <td><input type="text" name="IDSOTR" value="<?= isset($_GET['red_id']) ? $product['IDSOTR'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Фамилия:</td>
        <td><input type="text" name="FAMSOTR" value="<?= isset($_GET['red_id']) ? $product['FAMSOTR'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Имя:</td>
        <td><input type="text" name="NAMESOTR" value="<?= isset($_GET['red_id']) ? $product['NAMESOTR'] : ''; ?>"> </td>
      </tr>
    <tr>
        <td>Дата начала работы:</td>
        <td><input type="text" name="DATASOTR" value="<?= isset($_GET['red_id']) ? $product['DATASOTR'] : ''; ?>"> </td>
      </tr>
    <tr>
        <td>Адрес:</td>
        <td><input type="text" name="ADSOTR" value="<?= isset($_GET['red_id']) ? $product['ADSOTR'] : ''; ?>"> </td>
      </tr>
    <tr>
        <td>Должность:</td>
        <td><input type="text" name="DOLSOTR" value="<?= isset($_GET['red_id']) ? $product['DOLSOTR'] : ''; ?>"> </td>
      </tr>
      <tr>
      <tr>
        <td colspan="2"><input type="submit" value="OK"></td>
      </tr>
    </table>
  </form>
   <p><a href="?add=new">Добавить</a></p>
  <table class="table table-striped table-condensed table-bordered table-rounded">

    <tbody>
    <?php
       // Текущая страница
    if (isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else $page = 1;
   

    $kol = 5;  // количество записей для вывода
    $art = ($page * $kol) - $kol;
    

    // Определяем все количество записей в таблице
    $res = $link->query("SELECT COUNT(*) FROM `sotrudnic`");
    $row = mysqli_fetch_array($res);
    $total = $row[0]; // всего записей
    echo  "Всего записей: ".$total."</br>";

    // Количество страниц для пагинации
    $pages_count = ceil($total / $kol);
    // формируем пагинацию
    for ($i = 1; $i <= $str_pag; $i++){
        echo "<a href=index.php?page=".$i."> Страница ".$i." </a>";
    }

   if (isset($_GET['up_id'])) {
      $sql = $link->query("SELECT * FROM `sotrudnic` ORDER BY {$_GET['up_id']} LIMIT $art,$kol", $db);
    }else{
     $sql = $link->query("SELECT * FROM `sotrudnic` LIMIT $art,$kol", $db);
    } 
     echo '<tr>' .
             "<td><a href='?up_id=`IDSOTR`'>Идентификатор</a></td>" .
             "<td><a href='?up_id=`FAMSOTR`'>Фамилия</a></td>" .
             "<td><a href='?up_id=`NAMESOTR`'>Имя</a></td>" .
			       "<td><a href='?up_id=`DATASOTR`'>Дата начала работы</a></td>" .
             "<td><a href='?up_id=`ADSOTR`'>Адрес</a></td>" .
			       "<td><a href='?up_id=`DOLSOTR`'>Должность</a></td>" .
			       "<td>Удаление</td>" .
             "<td>Редактирование</td>" .
             '</tr>';

   while ($result = mysqli_fetch_array($sql)) {
        echo '<tr>' .
             "<td>{$result['IDSOTR']}</td>" .
             "<td>{$result['FAMSOTR']}</td>" .
             "<td>{$result['NAMESOTR']}</td>" .
       "<td>{$result['DATASOTR']}</td>" .
             "<td>{$result['ADSOTR']}</td>" .
        "<td>{$result['DOLSOTR']}</td>" .
             "<td><a href='?del_id={$result['IDSOTR']}'>Удалить</a></td>" .
             "<td><a href='?red_id={$result['IDSOTR']}'>Изменить</a></td>" .
             '</tr>';
      }
      require_once('universal_link_bar.php');
       universal_link_bar($page, $total, $pages_count, 2);
    ?>
	</tbody>
  </table>
  
</body>
</html>