<?php
// подключение файл db.php
require_once "../db.php";

$stmt = $pdo->query("select * from category");
$categorys = $stmt->fetchAll();

// проверка что categoryText не пустое
if (!empty($_POST['categoryText'])) {

    // проверка уникальности category
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM category WHERE name = ?");
    $stmt->execute([$_POST['categoryText']]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        // сохраняем значения полей в сессии
        session_start();
        $_SESSION['categoryText'] = $_POST['categoryText'];



        echo ' <script>alert("Такая категория уже существует");</script>';

    } else {
        // запрос на запись в базу и выполнение его
        $stmt = $pdo->prepare("insert into category (name) values(?)");
        $stmt->execute([
            $_POST['categoryText']
        ]);
        header('Location: change.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/change.css">
    <title>Изменение категориий</title>
</head>

<body>
    <div class="reg-window">
        <h1>Изменение категориий</h1>
        <form action="change.php" method="POST">
            <Div class="reg-input">
                <label class="log" for=""> Добавить категорию: </label> <input type="text" name="categoryText"
                    class="log" placeholder="доавьте категорию">
                <div class="btn-regClass">
                    <input type="submit" class="btn-reg" value="Изменить">
                </div>
        </form>

        <form class="form" action="del.php" method="POST">
            <div class="category">
                <label class="label-category">Катерогия:</label>
                <select class="btn-category" id="category" name="category" required>
                    <option value="0" hidden disabled selected>Выберите категорию...</option>
                    <?php foreach ($categorys as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $row['category'] ? 'selected' : '' ?>>
                            <?= $category['name'] ?></option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="btn-DellClass">
                <input type="submit" class="btn-Dell" value="Удалить">
            </div>
        </form>
    </Div>
    
    </div>
    <div class="btn-backClass">
    <button onclick="document.location='index.php'" class="btn-back">Назад</button>
    </div>
   
</body>

</html>