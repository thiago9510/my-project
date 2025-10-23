<?php
namespace MyProject\core\repositories;
// Core/Repositories/BaseRepository.php
class BaseRepository {
  protected $table;
  protected $db;

  public function __construct($table) {
    $this->table = $table;
  //  $this->db = Connection::get();
  }

  public function findAll() {
    return $this->db->query("SELECT * FROM {$this->table}")->fetchAll();
  }

  public function findById($id) {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  // insert, update, delete...
}
