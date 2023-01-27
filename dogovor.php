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
    if (isset($_POST["DATADOG"])) {
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_id'])) {
          $sql = $link->query("UPDATE `dogovor` SET `IDDOG` = '{$_POST['IDDOG']}', `DATADOG` = '{$_POST['DATADOG']}',`CENADOG` = '{$_POST['CENADOG']}',`PLOSHAD` = '{$_POST['PLOSHAD']}',`IDCL` = '{$_POST['IDCL']}',`IDSOTR` = '{$_POST['IDSOTR']}',`IDOB` = '{$_POST['IDOB']}' WHERE `IDDOG`={$_GET['red_id']}");
      } else {
          //Иначе вставляем данные, подставляя их в запрос
          $sql = $link->query("INSERT INTO `dogovor` (`IDDOG`, `DATADOG`, `CENADOG`, `PLOSHAD`, `IDCL`, `IDSOTR`, `IDOB`) VALUES ('{$_POST['IDDOG']}', '{$_POST['DATADOG']}', '{$_POST['CENADOG']}', '{$_POST['PLOSHAD']}', '{$_POST['IDCL']}', '{$_POST['IDSOTR']}', '{$_POST['IDOB']}')");
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
      $sql = $link->query("DELETE FROM `dogovor` WHERE `IDDOG` = {$_GET['del_id']}");
      if ($sql) {
        echo "<p>Договор удален.</p>";
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }
  

    //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red_id'])) {
      $sql = $link->query("SELECT `IDDOG`, `DATADOG`, `CENADOG`, `PLOSHAD`, `IDCL`, `IDSOTR`, `IDOB` FROM `dogovor` WHERE `IDDOG`={$_GET['red_id']}");
      $product = mysqli_fetch_array($sql);
    }
  ?>

  <form action="" method="post">
  <table class="table table-striped table-condensed table-bordered table-rounded">
  <tr>
        <td>Идентификатор:</td>
        <td><input type="text" name="IDDOG" value="<?= isset($_GET['red_id']) ? $product['IDDOG'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Дата:</td>
        <td><input type="text" name="DATADOG" value="<?= isset($_GET['red_id']) ? $product['DATADOG'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Цена:</td>
        <td><input type="text" name="CENADOG" value="<?= isset($_GET['red_id']) ? $product['CENADOG'] : ''; ?>"> </td>
      </tr>
    <tr>
        <td>Площадь:</td>
        <td><input type="text" name="PLOSHAD" value="<?= isset($_GET['red_id']) ? $product['PLOSHAD'] : ''; ?>"> </td>
      </tr>
    <tr>
        <td>Идентификатор клиента:</td>
        <td><input type="text" name="IDCL" value="<?= isset($_GET['red_id']) ? $product['IDCL'] : ''; ?>"> </td>
      </tr>
         <tr>
        <td>Идентификатор обекта:</td>
        <td><input type="text" name="IDOB" value="<?= isset($_GET['red_id']) ? $product['IDOB'] : ''; ?>"> </td>
      </tr>
      <tr>
    <tr>
        <td>Идентификатор сотрудника:</td>
        <td><input type="text" name="IDSOTR" value="<?= isset($_GET['red_id']) ? $product['IDSOTR'] : ''; ?>"> </td>
      </tr>
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
    $res = $link->query("SELECT COUNT(*) FROM `dogovor`");
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
      $sql = $link->query("SELECT * FROM `dogovor` ORDER BY {$_GET['up_id']} LIMIT $art,$kol", $db);
    }else{
     $sql = $link->query("SELECT * FROM `dogovor` LIMIT $art,$kol", $db);
    } 
     echo '<tr>' .
             "<td><a href='?up_id=`IDDOG`'>Идентификатор</a></td>" .
             "<td><a href='?up_id=`DATADOG`'>Дата</a></td>" .
             "<td><a href='?up_id=`CENADOG`'>Цена</a></td>" .
			       "<td><a href='?up_id=`PLOSHAD`'>Площадь</a></td>" .
             "<td><a href='?up_id=`NAMESERVICE`'>Услуга</a></td>" .
			       "<td><a href='?up_id=`IDCL`'>Идентификатор клиента</a></td>" .
            "<td><a href='?up_id=`IDOB`'>Идентификатор объекта</a></td>" .
             "<td><a href='?up_id=`IDSOTR`'>Идентификатор сотрудника</a></td>" .
			       "<td>Удаление</td>" .
             "<td>Редактирование</td>" .
             '</tr>';

       while ($result = mysqli_fetch_array($sql)) {
        echo '<tr>' .
             "<td>{$result['IDDOG']}</td>" .
             "<td>{$result['DATADOG']}</td>" .
             "<td>{$result['CENADOG']}</td>" .
			       "<td>{$result['PLOSHAD']}</td>" .
             "<td>{$result['NAMESERVICE']}</td>" .
             "<td>{$result['IDCL']}</td>" .
             "<td>{$result['IDOB']}</td>" .
             "<td>{$result['IDSOTR']}</td>" .
             "<td><a href='?del_id={$result['IDDOG']}'>Удалить</a></td>" .
             "<td><a href='?red_id={$result['IDDOG']}'>Изменить</a></td>" .
             '</tr>';
      }
      require_once('universal_link_bar.php');
       universal_link_bar($page, $total, $pages_count, 2);
    ?>
	</tbody>
  </table>
  
</body>
</html>