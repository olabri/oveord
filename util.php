<?php

class Db {

  public $file;
  private $db;

  public function __construct($file= "ord.sqlite") {
    global $env;
    $this->file = $file;
  }

  public function connect($file = false){
    if ($file !== false) {
      $this->file = $file;
    }
    $this->db = new PDO("sqlite:$this->file");
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->prepareTables();
  }

  public function disconnect() {
    $this->db = null;
  }

  private function prepareTables () {
    $query = "CREATE TABLE IF NOT EXISTS ord (
      id STRING PRIMARY KEY,
      ord STRING,
      kjonn STRING,
      created DATETIME DEFAULT CURRENT_TIMESTAMP);";
    $this->exec($query);

  }

  /*
  * Creates an insert SQL sentece.
  *
  * @param string $table Name of the table to insert
  * @param array $pairs Array The key is the name of the field and the value is the value of the field.
  * @return array the record that was replaced or inserted.
  */
  public function insertOrReplace ($table, $pairs) {
    $this->checkValidName('table', $table);
    $sql = "INSERT OR REPLACE INTO $table " .$this->insertPredicate($pairs);
    return $this->exec($sql);
  }

  public function insertIfUniqueNotExist ($table, $pairs) {
    $this->checkValidName('table', $table);
    $sql = "INSERT INTO $table " . $this->insertPredicate($pairs);
    try {
      return $this->exec($sql);
    } catch (PDOException $e) {
      // 23000 == Integrity contrain violation [http://docstore.mik.ua/orelly/java-ent/jenut/ch08_06.htm]
      // errorInfo[0] is the SQLSTATE error code [http://php.net/manual/en/pdo.errorinfo.php]
      if ($e->errorInfo[0] == '23000')
        return 0;
      else
        throw $e;
    }
  }
  public function query ($query, $fetch_style = PDO::FETCH_ASSOC) {
    return $this->db->query($query, $fetch_style);
  }

  public function exec ($query) {
    return $this->db->exec($query);
  }

  public function quote ($value) {
    return $this->db->quote($value);
  }

}
