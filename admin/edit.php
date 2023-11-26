<?php
require_once "../db.php";
$stmt = $pdo->query("SELECT * FROM status");
$status = $stmt->fetchAll();

session_start();
$idAP = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stat = $_POST['status'];



    $photoBefor = $_FILES['photoBefor']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photoBefor"]["name"]);
    move_uploaded_file($_FILES["photoBefor"]["tmp_name"], $target_file);

    $sql = "UPDATE applications SET status = ?, photoBefor = ? WHERE id = ?";
    $works = $pdo->prepare($sql);
    $works->execute([$stat, $target_file, $idAP]);


}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit.css">
    <title>Изменение заявки</title>
</head>

<body>

    <form action="" method="POST" enctype="multipart/form-data">
<div class="Class">
    <h2>Изменение заявки</h2>
        <div class="statusClass">
            <label for="" class="label">Статус заявки:</label>
        <select class="status" id="status" name="status">
            <option value="all">Все</option>
            <?php foreach ($status as $stat): ?>
                <option value="<?= $stat['id'] ?>"><?= $stat['name'] ?></option>
            <?php endforeach; ?>
        </select>
        </div>

        <div class="descriptionClass">
        <label for="reason" class="descriptionLabel">Причина отклонения заявки:</label>
                <textarea class="description" id="description" name="description" rows="3" cols="40"></textarea><br>
        </div>

        <div class="photoClass">
            <input class="foto" type="file" id="photoBefor" name="photoBefor" accept="image/*" required
                placeholder="Выберите фото">
        </div>
        <button type="submit" class="btn" name="editAP">Применить изменения</button>

        <a class="btn-back" href="index.php">выйти</a>
 </div>
    </form>
</body>

</html>