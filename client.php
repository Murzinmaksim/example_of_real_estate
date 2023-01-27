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
      if (isset($_POST["FAMCL"])) {
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_id'])) {
          $sql = $link->query("UPDATE `client` SET `IDCL` = '{$_POST['IDCL']}', `FAMCL` = '{$_POST['FAMCL']}',`NAMECL` = '{$_POST['NAMECL']}',`ADCL` = '{$_POST['ADCL']}',`DATACL` = '{$_POST['DATACL']}',`TELEFON` = '{$_POST['TELEFON']}' WHERE `IDCL`={$_GET['red_id']}");
      } else {
          //Иначе вставляем данные, подставляя их в запрос
          $sql = $link->query("INSERT INTO `client` (`IDCL`, `FAMCL`, `NAMECL`, `ADCL`, `DATACL`, `TELEFON`) VALUES ('{$_POST['IDCL']}', '{$_POST['FAMCL']}', '{$_POST['NAMECL']}', '{$_POST['ADCL']}', '{$_POST['DATACL']}', '{$_POST['TELEFON']}')");
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
      $sql = $link->query("DELETE FROM `client` WHERE `IDCL` = {$_GET['del_id']}");
      if ($sql) {
        echo "<p>Клиент удалена.</p>";
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }
	

    //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red_id'])) {
      $sql = $link->query("SELECT `IDCL`, `FAMCL`, `NAMECL`, `ADCL`, `DATACL`, `TELEFON` FROM `client` WHERE `IDCL`={$_GET['red_id']}");
      $product = mysqli_fetch_array($sql);
    }
  ?>

  <form action="" method="post">
        <table class="table table-striped table-condensed table-bordered table-rounded">
	<tr>
        <td>Идентификатор:</td>
        <td><input type="text" name="IDCL" value="<?= isset($_GET['red_id']) ? $product['IDCL'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Фамилия:</td>
        <td><input type="text" name="FAMCL" value="<?= isset($_GET['red_id']) ? $product['FAMCL'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Имя:</td>
        <td><input type="text" name="NAMECL" value="<?= isset($_GET['red_id']) ? $product['NAMECL'] : ''; ?>"> </td>
      </tr>
	  <tr>
        <td>Адрес:</td>
        <td><input type="text" name="ADCL" value="<?= isset($_GET['red_id']) ? $product['ADCL'] : ''; ?>"> </td>
      </tr>

        <td>Дата:</td>
        <td><input type="text" name="DATACL" value="<?= isset($_GET['red_id']) ? $product['DATACL'] : ''; ?>"> </td>
      </tr>
	  <tr>
        <td>Телефон:</td>
        <td><input type="text" name="TELEFON" value="<?= isset($_GET['red_id']) ? $product['TELEFON'] : ''; ?>"> </td>
      </tr>
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
    $res = $link->query("SELECT COUNT(*) FROM `client`");
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
      $sql = $link->query("SELECT * FROM `client` ORDER BY {$_GET['up_id']} LIMIT $art,$kol", $db);
    }else{
     $sql = $link->query("SELECT * FROM `client` LIMIT $art,$kol", $db);
    } 
     echo '<tr>' .
             "<td><a href='?up_id=`IDCL`'>Идентификатор</a></td>" .
             "<td><a href='?up_id=`FAMCL`'>Фамилия</a></td>" .
             "<td><a href='?up_id=`NAMECL`'>Имя</a></td>" .
			 "<td><a href='?up_id=`ADCL`'>Адрес</a></td>" .
             "<td><a href='?up_id=`DATACL`'>Дата регистрации</a></td>" .
			       "<td><a href='?up_id=`TELEFON`'>Телефон</a></td>" .
			       "<td>Удаление</td>" .
             "<td>Редактирование</td>" .
             '</tr>';

      while ($result = mysqli_fetch_array($sql)) {
        echo '<tr>' .
             "<td>{$result['IDCL']}</td>" .
             "<td>{$result['FAMCL']}</td>" .
             "<td>{$result['NAMECL']}</td>" .
			 "<td>{$result['ADCL']}</td>" .
             "<td>{$result['DATACL']}</td>" .
			  "<td>{$result['TELEFON']}</td>" .
             "<td><a href='?del_id={$result['IDCL']}'>Удалить</a></td>" .
             "<td><a href='?red_id={$result['IDCL']}'>Изменить</a></td>" .
             '</tr>';
      }
      require_once('universal_link_bar.php');
       universal_link_bar($page, $total, $pages_count, 2);
    ?>
	</tbody>
  </table>
  
</body>
</html>