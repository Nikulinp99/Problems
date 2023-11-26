<?php
// подключение файл db.php
require_once "db.php";
// проверка что name не пустое
if (!empty($_POST['fio'])) {
    // проверка уникальности логина
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE Login = ?");
    $stmt->execute([$_POST['log']]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        // сохраняем значения полей в сессии
        session_start();
        $_SESSION['fio'] = $_POST['fio'];
        $_SESSION['log'] = $_POST['log'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['pass'] = $_POST['pass'];

        
       echo' <script>alert("Такой логин уже существует");</script>';

    } else {
        // запрос на запись в базу и выполнение его
        $stmt = $pdo->prepare("insert into user (Fio, Login, Email, Password) values(?,?,?,?)");
        $stmt->execute([
            $_POST['fio'],
            $_POST['log'],
            $_POST['email'],
            $_POST['pass']

        ]);
        // перенаправление на главную страницу
        header("Location: index.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/MyStyle.css">
    <title>Регистрация</title>
</head>

<body>
    <form method="POST" action="registration.php">
        <div class="reg-window" actionp>
            <h1>Регистрация</h1>
            <Div class="reg-input">
                <label class="fio" for=""> ФИО: </label> <input required name="fio" type="text" class="fio"
                    placeholder="Введите ФИО">
                <label class="log" for=""> Логин: </label> <input required name="log" type="text" class="log"
                    placeholder="Введите логин">
                <label class="email" for=""> Эл.Почта: </label> <input required name="email" type="text" class="email"
                    placeholder="Введите email">
                <label class="pass" for=""> Пароль: </label> <input id="pass" required name="pass" type="text"
                    class="pass" placeholder="Введите пароль">
                <label class="accpass" for=""> Подтвердите пароль: </label> <input id="accpass" type="text"
                    class="accpass" placeholder="Подтвердите пароль">
                <div class="error-message" id="password-confirm-error"></div>
                <input type="submit" class="btn-reg" value="Зарегистрироваться">
                <button onclick="document.location='index.php'" class="btn-back">Назад</button>
            </Div>
            <div class="checkbox">
                <input type="checkbox">
                <label for="">Я согласен с условиями использования сайта</label>
            </div>
        </div>
    </form>


    <script>
        const form = document.querySelector('form');
        const passwordInput = document.querySelector('#pass');
        const passwordConfirmInput = document.querySelector('#accpass');
        const passwordConfirmError = document.querySelector('#password-confirm-error');

        form.addEventListener('submit', (event) => {
            if (passwordInput.value !== passwordConfirmInput.value) {
                event.preventDefault();
                passwordConfirmError.textContent = 'Пароли не совпадают';
            } else {
                passwordConfirmError.textContent = '';
            }
        });

        function goBack() {
            window.location.href = "index.php";
        };
    </script>
</body>

</html>