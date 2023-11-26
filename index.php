<?php
// подключение файл db.php
require_once "db.php";
$idSt = 2;
// количество пользователей
$stmtUser = $pdo->prepare("SELECT COUNT(*) FROM user");
$stmtUser->execute();
$Users = $stmtUser->fetchColumn();

// количество решенных заявок
$stmtReq = $pdo->prepare("SELECT COUNT(*) FROM applications WHERE status = ?");
$stmtReq->execute([$idSt]);
$Requests = $stmtReq->fetchColumn();



// запрос на выборку всех записей из таблицы Works
$stmt = $pdo->prepare("SELECT t1.id, t1.name, t1.description, t1.category, t2.name as category, t1.photo, t1.created_at, t1.photoBefor
FROM applications t1
JOIN category t2 ON t1.category = t2.id
WHERE t1.status = ?");
$stmt->execute([$idSt]);
$works = $stmt->fetchAll();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Улучши свой город</title>
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
                        <li class="active"><a href="index.php">Главная</a></li>
                        <li><a href="registration.php">Зарегистрироваться</a></li>
                        <li><a href="login.php">Войти</a></li>
                        <li class="dropdown">

                    </ul>
                    </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="container ">
            <table class="countUserApplc">
                <tr>
                    <td class="">Количество пользователей</td>
                    <td class="">
                        <?php echo $Users; ?>
                    </td>
                </tr>
                <tr>
                    <td class="">Количество решенных заявок</td>
                    <td class="">
                        <?php echo "&nbsp","&nbsp", $Requests; ?>
                    </td>
                </tr>
            </table>
        </div>
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
                    <a class="btn btn-success btn-lg" href="login.php" role="button">Сообщить о проблеме</a>
                    <a class="btn btn-primary btn-lg" href="registration.php" role="button">Присоедениться к проекту</a>
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