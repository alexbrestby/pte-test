<?php
include('header.php');
require_once('db.php');

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

$err = [];

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($conn, "SELECT id FROM users WHERE name='".mysqli_real_escape_string($conn, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        $login = $_POST['login'];

        // Шифруем пароль
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, register_at) VALUES ('$login', '01.80@mail.ru', '$password', CURRENT_TIMESTAMP)";
        var_dump($sql);

        mysqli_query($conn, $sql);
        // header("Location: index.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>

<div class="container">

    <form method="POST" class="register_form needs-validation">
        <div class="form-group">
            <!-- <label for="exampleInputEmail1">Логин</label> -->
            <input type="text" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Введите Ваш логин">
        </div>
        <div class="form-group">
            <!-- <label for="exampleInputPassword1">Пароль</label> -->
            <input type="email" name="email" class="form-control" placeholder="Введите email">
        </div>
        <div class="form-group">
            <!-- <label for="exampleInputPassword1">Пароль</label> -->
            <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                placeholder="Введите пароль">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">запомнить меня</label>
        </div>
        <div class="submit-button">
            <button type="submit" name="submit" class="btn btn-primary">Зарегистрироваться</button>
            <button class="btn btn-outline-dark"><a href="login.php">Войти</a></button>
        </div>
    </form>
    <?php include('footer.php');?>
</div>

