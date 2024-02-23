<?php

class WorkingDatabase {
  public $servername;
  public $username;
  public $password;
  public $dbName;
  public $tableName;
  
  public $linkPage;
  public $informationPropertyRes;
  public $initialPrice;
  public $eMail;
  public $phone;
  public $inn;
  public $numberBankruptcyCase;
  public $tradingDate;
  
  public function __construct(string $servername, string $username, string $password, string $dbName, string $tableName) {
    $this->servername = $servername;
    $this->username = $username;
    $this->password = $password;
    $this->dbName = $dbName;
    $this->tableName = $tableName;
    $this->linkPage = $_POST['linkPage'];
    $this->informationPropertyRes = $_POST['informationPropertyRes'];
    $this->initialPrice = $_POST['initialPrice'];
    $this->eMail = $_POST['eMail'];
    $this->phone = $_POST['phone'];
    $this->inn = $_POST['inn'];
    $this->numberBankruptcyCase = $_POST['numberBankruptcyCase'];
    $this->tradingDate = $_POST['tradingDate'];
  }

  public function isWorking() {
    $conn = new mysqli($this->servername, $this->username, $this->password);
    if (!mysqli_select_db($conn, $this->dbName) ){
    $sql = "CREATE DATABASE " . $this->dbName;
      if ($conn->query($sql) === TRUE) {
        echo "База данных '$this->dbName' успешно создана";
        $this->CreateTable();
        $this->InsertEntry();
      } else {
        echo "Ошибка при добавлении базы данных '$this->dbName': " . $conn->error;
      }
    } else {
      echo "База данных '$this->dbName' уже существует.";
      $this->CreateTable();
      $this->InsertEntry();
    }
  }

  public function CreateTable() {
    $connect = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
      $sql = "CREATE TABLE $this->tableName (id INTEGER AUTO_INCREMENT PRIMARY KEY, link_page TEXT, information_property TEXT, initial_price VARCHAR(30), e_mail VARCHAR(30), phone VARCHAR(30), inn VARCHAR(30), number_bankruptcy_case VARCHAR(30), trading_date TEXT);";
      if(mysqli_query($connect, $sql)){
          echo "Таблица $this->tableName успешно создана";
      } else {
          echo "Ошибка при добавлении таблицы: " . $connect->error;
      }
      $connect->close();
  }

  public function InsertEntry() {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
    $this->searchDuplicates();
    $sql = "INSERT INTO $this->tableName (`link_page`, `information_property`, `initial_price`, `e_mail`, `phone`, `inn`, `number_bankruptcy_case`, `trading_date`) VALUES ('$this->linkPage', '$this->informationPropertyRes', '$this->initialPrice', '$this->eMail', '$this->phone', '$this->inn', '$this->numberBankruptcyCase', '$this->tradingDate')";
    if($conn->query($sql)){
      echo "Строка успешно добавлена";
      header("Location: ../../index.php");
    } else{
      echo "Ошибка при добавлении строки" . $conn->error;
    }
    $conn->close();
  }

  public function searchDuplicates() {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
    $sql = "SELECT * FROM $this->tableName";
    $result = $conn->query($sql);
    foreach($result as $row){
        if($row["link_page"] == $this->linkPage && $row["information_property"] == $this->informationPropertyRes && $row["initial_price"] == $this->initialPrice && $row["e_mail"] == $this->eMail && $row["phone"] == $this->phone && $row["inn"] == $this->inn && $row["number_bankruptcy_case"] == $this->numberBankruptcyCase && $row["trading_date"] == $this->tradingDate) {
          $sql = "DELETE FROM $this->tableName WHERE id = '$row[id]'";
          if($conn->query($sql)){
              echo "Дублируемая строка удалена";
          } else {
              echo "Ошибка: " . $conn->error;
          }
          $conn->close();
        }
    }
  }
}

$dbInfoLots = new WorkingDatabase('localhost', 'root', 'root', 'info_lots', 'lots');
$dbInfoLots->isWorking();