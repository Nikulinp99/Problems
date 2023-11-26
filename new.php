<?php
// подключение файл db.php
require_once "db.php";
session_start();
$login = $_SESSION['log'];//получаем логин

$stmt = $pdo->query("select * from category");
$categorys = $stmt->fetchAll();

//получаем ид
$stmt = $pdo->prepare("SELECT id FROM user WHERE login = ?");
$stmt->execute([$login]);
$id_user = $stmt->fetchColumn();

// проверка что name не пустое
if (!empty($_POST['name'])) {
    // Загружаем файл с фото
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    // запрос на запись в базу и выполнение его
    $stmt = $pdo->prepare("insert into applications (name, description, category, photo,status,id_user) values(?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['description'],
        $_POST['category'],
        $target_dir . $_POST['photo'],
        1,
        $id_user
    ]);
    // перенаправление на главную страницу
     header("Location: user.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleNew.css">
    <title>Новая заявка</title>
</head>

<body>
    <form method="POST" action="new.php">
        <div class="reg-window" actionp>
            <h1>Новая заявка</h1>
            <Div class="reg-input">
                <label class="name" for=""> Название: </label> <input required name="name" type="text" class="name"
                    placeholder="Название">
                <label class="description" for=""> Описание: </label> <textarea class="description" id="description"
                    name="description" required placeholder="Описание"></textarea>
                <input type="submit" class="btn-reg" value="Добавить заявку">
                <button onclick="document.location='user.php'" class="btn-back">Назад</button>
            </Div>
            <div class="category">
                <label class="label-category">Катерогия:</label>
                <select class="btn-category" id="category" name="category" required>
                    <option value="0" hidden disabled selected>Выберите категорию...</option>
                    <?php foreach ($categorys as $category): ?>
                        <option value="<?= $category['id'] ?>"> <?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="photo">
                <input class="foto" type="file" id="photo" name="photo" accept="image/*" required
                    placeholder="Выберите фото">
                <input type="hidden" name="timestamp" value="<?= date('Y.m.d') ?>">
            </div>
        </div>
    </form>
</body>

</html>