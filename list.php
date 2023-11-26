<?php
// подключение файл db.php
require_once "db.php";

session_start();
//присваиваем перменной ЛОГИН- _SESSION['log'] , переданная с другой станицы
$login = $_SESSION['log'];
$id_user = $_SESSION['id_user'];
// echo $id_user;

//для ввывода фио
$stmt = $pdo->prepare("SELECT Fio FROM user WHERE Login = ?");
$stmt->execute([$login]);
$fio = $stmt->fetchColumn();

$stmt = $pdo->query("select * from status");
$status = $stmt->fetchAll();

// запроса на удаление заявки
if (isset($_POST["delete_application"])) {
    $application_id = $_POST["delete_application"];
    $stmt = $pdo->prepare("DELETE FROM applications WHERE id = ?");
    $stmt->execute([$application_id]);
    // на страницу списка заявок после удаления
    header("Location: list.php");
}




if (isset($_POST['status'])) {

    $selected_status = $_POST['status'];
} else {
    $selected_status = '';
}
//фильтр статуса
if ($selected_status == 'all') {
    $sql = "SELECT t1.id, t1.name, t1.description, t1.category, t2.name as category, t1.photo, t1.created_at, t1.status, t3.name as status, t1.photoBefor
    FROM applications t1
    JOIN category t2 ON t1.category = t2.id
    JOIN status t3 ON t1.status = t3.id
    WHERE  t1.id_user = ?";
    $works = $pdo->prepare($sql);
    $works->execute([$id_user]);
} else if (isset($_POST['status'])) {
    $status = $_POST['status'];
    $sql = "SELECT t1.id, t1.name, t1.description, t1.category, t2.name as category, t1.photo, t1.created_at, t1.status, t3.name as status, t1.photoBefor
    FROM applications t1
    JOIN category t2 ON t1.category = t2.id
    JOIN status t3 ON t1.status = t3.id
            WHERE t1.status = ? and t1.id_user = ?";
    $works = $pdo->prepare($sql);
    $works->execute([$status, $id_user]);
} else {
    $sql = "SELECT t1.id, t1.name, t1.description, t1.category, t2.name as category, t1.photo, t1.created_at, t1.status, t3.name as status, t1.photoBefor
    FROM applications t1
    JOIN category t2 ON t1.category = t2.id
    JOIN status t3 ON t1.status = t3.id
    WHERE  t1.id_user = ?";
    $works = $pdo->prepare($sql);
    $works->execute([$id_user]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <form action="" method="POST">
        <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Городской портал</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="user.php">Назад</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">
                                <?php
                                echo $fio;
                                ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="list.php">Мои заявки</a></li>
                                <li><a href="new.php">Новая заявка</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="index.php">Выход</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="jumbotron">
            <div class="container">

                <label>
                    <h3>Фильтр по статусу</h3>
                </label>
                <select class="" id="status" name="status">
                    <option value="all">Все</option>
                    <?php foreach ($status as $stat): ?>
                        <option value="<?= $stat['id'] ?>" <?= $selected_status == $stat['id'] ? 'selected' : '' ?>> <?= $stat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Применить</button>

            </div>
        </div>
        <div class="container">
            <h2>Мои заявки</h2>
            <br>
            <div id="lightgallery" class="gallery">
                <!-- помещенная картинка в цикл foreach, который перерабатыевает массив works -->
                <?php foreach ($works as $key => $message): ?>
                    <div class="name">
                        <label for="">Название: </label>
                        <?= htmlspecialchars($message['name']) ?>
                    </div>
                    <div class="Email">
                        <label for="">Описание: </label>
                        <?= htmlspecialchars($message['description']) ?>
                    </div>

                    <div>
                        <label for="">Категория: </label>
                        <?= htmlspecialchars($message['category']) ?>
                    </div>

                    <div>
                        <label for="">Статус: </label>
                        <?= htmlspecialchars($message['status']) ?>
                    </div>
                    <div class="data">
                        <?= $message['created_at'] ?>
                    </div>


                    <div class="text">
                        <a class="img-wrapper" data-sub-html="<?= $message['name'] ?>" href="<?= $message['photo'] ?>">
                            <img src="<?= $message['photo'] ?>" />
                        </a>
                    </div>

                    <p></p>
                    <form action='' method='POST'>
                            <input type='hidden' name='editAP' value='<?php echo $message["id"] ?>'>
                            <a href="editUser.php?id=<?= $message["id"] ?>">Изменить</a>
                        </form>
                        <!-- <?php session_start(); $_SESSION["id"] = $message["id"];?> -->
                    <p></p>

                    <form action='list.php' method='POST'>
                            <input type='hidden' name='delete_application' value='<?php echo $message["id"] ?>'>
                            <button type='submit'>Удалить</button>
                        </form>
                    <p></p>
                    <hr style="height:1px;border:none;color:#333;background-color:#333;">
                <?php endforeach; ?>
            </div>
        </div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.js"></script>
    </form>
</body>

</body>

</html>