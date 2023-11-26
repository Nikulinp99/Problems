<?php
// 1 созданный отдельный файл db.php в корне проекта, чтобы в каждом файле не писать подключение к базе
$pdo = new PDO('mysql:host=localhost;dbname=Problems;charset=utf8', 'root', '', [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
?>