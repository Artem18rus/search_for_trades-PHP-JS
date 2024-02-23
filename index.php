<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="src/app.css">
</head>
<body>
	<p class="title">Поиск торгов:</p>
    <form method="post" action="/src/php/submit_page.php" accept-charset="utf-8" id="searchform">
      <input type="string" name="number_bidding" placeholder="Введите номер торгов">
      <input type="number" name="number_lot" placeholder="Введите номер лота">
      <input class="submit" type="submit" value="Найти">
    </form>

    <?php
      $servername = 'localhost';
      $username = 'root';
      $password = 'root';
      $dbName = 'info_lots';
      $tableName = 'lots';

      $dbh = new PDO("mysql:dbname=$dbName;host=$servername", $username, $password);
      $sth = $dbh->prepare("SELECT * FROM $tableName");
      $sth->execute();
      $list = $sth->fetchAll(PDO::FETCH_ASSOC);

      $url = $_SERVER['REQUEST_URI'];
      if($url == '/index.php?+visible_modal') {
        echo "<div style='font-size: 20px; color: red';><h3>Лот не найден!</h3></div>";
      }
    ?>

  <table class="table">
    <p>Найденные торги:</p> 
    <thead>
      <tr>
        <th>URL адрес</th>
        <th>Сведения об имуществе</th>
        <th>Начальная цена лота</th>
        <th>E-mail контактного лица</th>
        <th>Телефон контактного лица</th>
        <th>ИНН должника</th>
        <th>Номер дела о банкротстве</th>
        <th>Дата торгов (начала торгов / проведения торгов) </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($list as $row): ?>
      <tr>
        <td><a href=<?php echo $row['link_page']; ?> target="_blank"><?php echo $row['link_page']; ?></a></td>
        <td><?php echo $row['information_property']; ?></td>
        <td><?php echo $row['initial_price']; ?></td>
        <td><?php echo $row['e_mail']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['inn']; ?></td>
        <td><?php echo $row['number_bankruptcy_case']; ?></td>
        <td><?php echo $row['trading_date']; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>