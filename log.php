<?php
require __DIR__ . '/vendor/autoload.php';
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);

session_start();
$session_id_update_interval = 60 * 60 * 24;

if (!isset($_SESSION['EXPIRES']) || $_SESSION['EXPIRES'] < time()) {
    session_regenerate_id();
    $_SESSION['EXPIRES'] = time() + $session_id_update_interval;
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$telegram_token = $_ENV["TELEGRAM_TOKEN"];
$chat_id = $_ENV["TELEGRAM_CHAT_ID"];

function getIp()
{
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR',
    ];

    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = trim(end(explode(',', $_SERVER[$key])));
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
}

function get_mail()
{
    global $conn;

    if (isset($_POST["email"])) {
        $mail = $_POST["email"];
        // unset($_POST["email"]);

    } else {
        $sql = "SELECT * FROM users";

        if (mysqli_query($conn, $sql)) {
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["unique_id"] === $_COOKIE["id"]) {
                    $mail = $row["mail"];
                }
            }
        }
        // else {
        //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        // }
        // mysqli_close($conn);
    }
    return $mail;
}

$current_ip = getIp();
$current_mail = get_mail();

// debug($current_mail);
// debug($_POST);

$info = file_get_contents('http://ip-api.com/json/' . $current_ip . '?lang=ru');
$message = json_decode($info, true);
$ip_addr = $message["query"];

$data_first = "email - " . $current_mail .
"\r\nIP - " . $message["query"] .
"\r\nстрана - " . $message["country"] .
"\r\nгород - " . $message["city"] .
"\r\nпровайдер - " . $message["isp"] .
"\r\nпервый визит: " . date("Y-m-d H:i:s") .
    "\r\n\r\n";

$data_no_first = "email - " . $current_mail .
"\r\nIP - " . $message["query"] .
"\r\nстрана - " . $message["country"] .
"\r\nгород - " . $message["city"] .
"\r\nпровайдер - " . $message["isp"] .
"\r\nповторный вход: " . date("Y-m-d H:i:s") .
    "\r\n\r\n";

$data = strlen($_COOKIE["id"]) > 0 ? $data_no_first : $data_first;

function sendMessageToTelegram($chatID, $messaggio, $token)
{
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);

    $result = file_get_contents($url);
    return $result;
}

$lifetime = 60 * 60 * 24 * 30;
$newUserUniqueId = uniqid($prefix = "pte-");

if (!isset($_COOKIE["id"]) or ($_COOKIE["id"] === null)) {

    if ($_POST["email"] and !empty($current_mail)) {

        setcookie("id", $newUserUniqueId, time() + $lifetime);
        $userId = $_COOKIE["id"];

        sendMessageToTelegram($chat_id, "На сайт выполнен вход!\r\n" . $data, $telegram_token);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO users (unique_id, mail, ip_addr, last_visit_at)
            VALUES ('$newUserUniqueId', '$current_mail', '$ip_addr', CURRENT_TIMESTAMP)";

        mysqli_query($conn, $sql);

        mysqli_close($conn);
        // header("Location: " . $_SERVER['PHP_SELF']);

    } else {
        setcookie("id", "", time() - 3600);
    }

} else {

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users";

    if (mysqli_query($conn, $sql)) {
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["unique_id"] === $_COOKIE["id"] and $_SESSION["current"] !== session_id()) {
                sendMessageToTelegram($chat_id, "На сайт выполнен вход!\r\n" . $data, $telegram_token);
                $_SESSION["current"] = session_id();
            }
        }
    }
    // else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    // }

    mysqli_close($conn);
}
unset($_POST["email"]);
unset($current_mail);
// debug($current_mail);
// debug($_POST);
// file_put_contents($file, $data, FILE_APPEND);

function debug($param)
{
    echo "<pre>";
    var_dump($param);
    echo "</pre>";
}
