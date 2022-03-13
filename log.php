<?php
require_once 'config/db.php';
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);
$token = "1995157538:AAGFeHeDBkuPC-ABz0qek7xqkcnua8mbwGM";
$chatid = "317794726";

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

function sendMessageToTelegram($chatID, $messaggio, $token)
{

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);

    $result = file_get_contents($url);
    return $result;
}

$file = 'log.txt';
$counterVisit = $_COOKIE["visited"] > 0 ? $_COOKIE["visited"] . " посещение" : "первый раз";
$data = "IP - " . $message["query"] .
"\r\nстрана - " . $message["country"] .
"\r\nгород - " . $message["city"] .
"\r\nпровайдер - " . $message["isp"] .
"\r\n" . $counterVisit .
"\r\nвход выполнен: " . date("Y-m-d H:i:s") .
    "\r\n\r\n";

$ip = getIp();
$info = file_get_contents('http://ip-api.com/json/' . $ip . '?lang=ru');
$message = json_decode($info, true);
$ip_addr = $message["query"];

if (!isset($_COOKIE["id"])) {
    $lifetime = 60 * 60 * 24 * 30;
    $newUserUniqueId = uniqid($prefix = "pte-");
    setcookie("id", $newUserUniqueId, time() + $lifetime);
}

if (isset($_POST["email"]) and $_POST["email"] !== "") {
    $mail = $_POST["email"];
    $userId = $_COOKIE["id"];
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO users (unique_id, mail, ip_addr, last_visit_at)
    VALUES ('$userId', '$mail', '$ip_addr', CURRENT_TIMESTAMP)";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    unset($_POST["email"]);
    header("Location: " . $_SERVER['PHP_SELF']);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start(["cookie_lifetime" => '0']);
}

// file_put_contents($file, $data, FILE_APPEND);

// sendMessageToTelegram($chatid, "На сайт выполнен вход!\r\n" . $data, $token);

function debug($param)
{
    echo "<pre>";
    var_dump($param);
    echo "</pre>";
}
