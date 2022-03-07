<?php
include('header.php');
require_once('db.php');

// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);

// $sql = "SELECT * FROM users";
// $result = mysqli_query($conn, $sql);
// while($row = mysqli_fetch_assoc($result)) { ?>
<!-- <pre><?php //var_dump($row);?></pre> -->
<?php //} ?>

<?php
// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($conn,"SELECT id, name, password FROM users WHERE name='".mysqli_real_escape_string($conn,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    // var_dump($data);

    // Сравниваем пароли
    if(password_verify($_POST['password'], $data['password']))

    {
        // Ставим куки
        setcookie("name", $data['name'], time()+60*60*24*30, "/");
        header("Location: index.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>

<div class="container">

    <form method="POST" class="login_form">
        <div class="form-group">
            <!-- <label for="exampleInputEmail1">Логин</label> -->
            <input type="text" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Введите Ваш логин">
        </div>
        <div class="form-group">
            <!-- <label for="exampleInputPassword1">Пароль</label> -->
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Введите Ваш пароль">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">запомнить меня</label>
        </div>
        <div class="submit-button">
            <button type="submit" name="submit" class="btn btn-primary">Войти</button>
            <button class="btn btn-outline-dark" style="white-space: normal;><a href="register.php">Регистрация</a></button>
        </div>
    </form>
    <?php include('footer.php');?>
</div>
