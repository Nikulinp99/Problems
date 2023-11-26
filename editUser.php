<?php

require_once "db.php";
$stmt = $pdo->query("SELECT * FROM category");
$status = $stmt->fetchAll();

session_start();
$idAP = $_GET['id'];
$stat = $_POST['status'];
$UpName = $_POST['name'];
$UpDescription = $_POST['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stat = $_POST['status'];



    $photoBefor = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $photoBefor = $target_file . $_POST['photo'];
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    $sql = "UPDATE applications SET name =?, description = ?, category = ?, photo = ? WHERE id = ?;";
    $works = $pdo->prepare($sql);
    $works->execute([$UpName, $UpDescription, $stat, $photoBefor, $idAP]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменение заявки</title>
    <link rel="stylesheet" href="css/editUser.css">
</head>

<body>
    <form action="" method="POST">
       

            <Div class="Class">
                <h2>Изменить заявку</h2>
                <div class="NameClass">
                <label class="name" for=""> Название: </label> <input required name="name" type="text" class="name"
                    placeholder="Название">
                    </div>

                    <div class="descriptionClass">
                <label class="description" for=""> Описание: </label> <textarea class="description" id="description"
                    name="description" required placeholder="Описание"></textarea>
                    </div>

                    <div class="statusClass">
                        <label for="">Категория:</label>
                <select class="status" id="status" name="status">
                    <option value="all">Все</option>
                    <?php foreach ($status as $stat): ?>
                        <option value="<?= $stat['id'] ?>" <?= $selected_status == $stat['id'] ? 'selected' : '' ?>> <?= $stat['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </div>
                <div class="photoClass">
                    <input class="foto" type="file" id="photo" name="photo" accept="image/*" required
                        placeholder="Выберите фото">
                </div>

                <button class="btn" name="editAP">Применить изменения</button>

                <a class="btn-back" href="list.php">назад</a>

            </div>
         
    </form>
</body>

</html>