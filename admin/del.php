<?php
// подключение файл db.php
require_once "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST["category"];
  
    // Удалить категорию из таблицы Category
    $stmt = $pdo->prepare("DELETE FROM category WHERE id = ?");
    $stmt->execute([$category_id]);
    header('Location: change.php');
    exit();
  }
?>

?>