<?php
require_once "db.php";

$login = $_POST['log'] ?? '';
$pas = $_POST['pass'] ?? '';

session_start();
//запоминает логин в _SESSION['log']
$_SESSION['log'] = $login;

if ($login === 'admin' && $pas === 'admin') {
    header("Location: admin/index.php");
} else {
    $query = $pdo->prepare("SELECT * FROM user WHERE login=?");
    $query->execute([$login]);
    $user = $query->fetch();

    $query2 = $pdo->prepare("SELECT * FROM user WHERE password=?");
    $query2->execute([$pas]);
    $user2 = $query2->fetch();

    if ($user && $user2) {
        header("Location:user.php");
    } else {
        $error = 'Ошибка авторизации';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/MyStyle1.css">
    <title>Авторизация</title>
</head>

<body>
    <form action="" method="POST">
        <div class="reg-window">
            <h1>Авторизация</h1>
            <Div class="reg-input">
                <label class="log" for=""> Логин: </label> <input type="text" name="log" class="log"
                    placeholder="Введите логин">
                <label class="pass" for=""> Пароль: </label> <input type="password" id="pass" name="pass" class="pass"
                    placeholder="Введите пароль">
                <input type="submit"  class="btn-reg" value="Войти">
                <a class="btn-back" href="index.php">Назад</a>
            </Div>
            <div class="checkbox">
                <input onclick="showPassword()" type="checkbox">
                <label for="">Показать пароль</label>
            </div>
        </div>
    </form>
    <script>
        function showPassword() {
            var passwordField = document.getElementById("pass");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        } 
    </script>
</body>

</html>