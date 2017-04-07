<?php
session_start(); 

//Class for database connection
class ConnectDb {

  private static $instance = null;
  private $conn;
  
  private $host = 'localhost';
  private $user = 'root';
  private $pass = '';
  private $name = 'yanpix';
   
  private function __construct() {
    $this->conn = new PDO("mysql:host={$this->host}; dbname={$this->name}", $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  
  public static function getInstance() {
    if(!self::$instance) {
      self::$instance = new ConnectDb();
    }
   
    return self::$instance;
  }
  
  public function getConnection() {
    return $this->conn;
  }
}

//Insert user action in database
if (isset($_POST['name']) && isset($_POST['action']) && isset($_POST['data'])) {

  $conn_insert = ConnectDb::getInstance()->getConnection();

  $stmt = $conn_insert->prepare('INSERT INTO activity (date_act, user, action) VALUES (:date_act, :user, :action)');

  $stmt->bindParam(':date_act', $date);
  $stmt->bindParam(':user', $_SESSION['login']);
  $stmt->bindParam(':action', $action);

  $date = date('Y-m-d H:i:s');
  $action = $_POST['action'].' '.$_POST['data'].' '.$_POST['name'];
  
  $stmt->execute();
}