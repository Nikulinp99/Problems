<?php
require_once "db.php";

session_start();
//присваиваем перменной ЛОГИН- _SESSION['log'] , переданная с другой станицы
$login = $_SESSION['log'];


$stmt = $pdo->prepare("SELECT Fio FROM user WHERE Login = ?");
$stmt->execute([$login]);
$fio = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT id FROM user WHERE Login = ?");
$stmt->execute([$login]);
$id_user = $stmt->fetchColumn();

//запоминает ид в _SESSION['user_id']
$_SESSION['id_user'] = $id_user;

$idSt = 2;

// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.id, t1.name, t1.description, t1.category, t2.name as category, t1.photo, t1.created_at, t1.photoBefor
FROM applications t1
JOIN category t2 ON t1.category = t2.id
WHERE t1.status = ?");
$stmt->execute([$idSt]);
$works = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователь</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/twentytwenty.css">

</head>

<body>
    <form action="">
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
                        <li class="active"><a href="#">Главная</a></li>
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
                <h1>Привет, дорогой друг!</h1>
                <p>
                    Вместе мы сможем улучшить наш любимый город. Нам очень сложно узнать обо всех проблемах города,
                    поэтому мы
                    предлагаем тебе помочь своему городу!
                </p>
                <p>
                    Увидел проблему? Дай нам знать о ней и мы ее решим!
                </p>
                <p>
                    <a class="btn btn-success btn-lg" href="new.php" role="button">Сообщить о проблеме</a>
                </p>
            </div>
        </div>

        <div class="container">
            <h2>Последние решенные проблемы</h2>
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
                    <div class="data">
                        <?= $message['created_at'] ?>
                    </div>


                    <div class="before-after text">
                        <a class="img-wrapper" data-sub-html="<?= $message['name'] ?>" href="<?= $message['photo'] ?>">
                            <img class='image before-after__item' src="<?= $message['photo'] ?>" height="450" width="500" />
                        </a>
                        <a class="img-wrapper" data-sub-html="<?= $message['name'] ?>" href="<?= $message['photoBefor'] ?>">
                            <img class='image before-after__item' src="<?= $message['photoBefor'] ?>" height="450"
                                width="500" />
                        </a>
                    </div>
                    <p></p>
                    <hr style="height:1px;border:none;color:#333;background-color:#333;">
                <?php endforeach; ?>
            </div>
        </div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.js"></script>

        <!-- Скрипты -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/jquery.event.move.js"></script>
        <script src="js/jquery.twentytwenty.js"></script>
        <script>
            $(function () {
                $(".before-after").twentytwenty({
                    move_slider_on_hover: true,
                    no_overlay: true,
                    // orientation: 'vertical',
                    // before_label: 'Было',
                    // after_label: 'Стало',
                });
            });
        </script>
    </form>
</body>

</html>